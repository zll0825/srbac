<?php

namespace App\Http\Controllers\Rbac;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\User;
use App\Http\Models\UserRole;
use App\Http\Models\UserGroupUser;
use App\Http\Models\Role;
use App\Http\Models\UserGroup;
use App\Http\Models\RolePermission;
use App\Http\Models\PermissionMenu;
use App\Http\Models\PermissionFunction;
use App\Http\Models\PermissionElement;
use App\Http\Models\Menu;
use App\Http\Models\RFunction;
use App\Http\Models\Element;
use DB;

class UserController extends Controller
{
    //创建用户页面
    public function create(){
        return view('rbac.user.create');
    }

    //用户列表
    public function index(){
        $users = User::all();
        return view('rbac.user.list',compact('users'));
    }

    //设置用户角色
    public function role(Request $request){
        $UID = $request->userid;
        $uroles = User::find($UID)->roles()->get()->toArray();
        $roles = Role::all();
        $ur = [];
        foreach ($uroles as $urole) {
            $ur[] = $urole['ROLEID'];
        }
        return view('rbac.user.role',compact('roles','ur','UID'));
    }

    //设置用户用户组
    public function usergroup(Request $request){
        $UID = $request->userid;
        $ugroups = User::find($UID)->usergroups()->get()->toArray();
        $usergroups = UserGroup::all();
        $ug = [];
        foreach ($ugroups as $ugroup) {
            $ug[] = $ugroup['UGID'];
        }
        return view('rbac.user.usergroup',compact('usergroups','ug','UID'));
    }

    //展示用户权限
    public function permission(Request $request){
        $UID = $request->userid;
        $ur = DB::table('V_RBAC_USERROLE')->where('UID',$UID)->select('ROLEID')->get();
        $rp = [];
        foreach ($ur as $role) {
            if(!$role->ROLEID) continue;
            $permissions = Role::find($role->ROLEID)->permissions()->get()->toArray();
            foreach ($permissions as $permission) {
                $rp[] = $permission['PID'];
            }
        }
        $menus = PermissionMenu::whereIn('PID',$rp)->lists('MID');
        $funcs = PermissionFunction::whereIn('PID',$rp)->lists('FID');
        $elems = PermissionElement::whereIn('PID',$rp)->lists('EID');

        $menus = Menu::whereIn('MID',$menus)->get()->toArray();
        $funcs = RFunction::whereIn('FID',$funcs)->get()->toArray();
        $elems = Element::whereIn('EID',$elems)->get()->toArray();
        return view('rbac.user.permission',compact('menus','funcs','elems'));
    }

    //创建用户
    public function createUser(Request $request){
        $data['AVATAR'] = $request->password?$request->password:'未设置';
        $data['NICKNAME'] = $request->nickname?$request->nickname:'未设置';
        $data['REGTIME'] = date('Y-m-d H:i:s', time());
        $data['LOGINIP'] = $request->getClientIp();

        $result = User::create($data);
        if(!$result){
            return response()->json(['status_code' => '500', 'msg' => 'error']);
        } else {
            return response()->json(['status_code' => '200', 'msg' => 'ok']);
        }

    }

    //给用户设置角色
    public function setUserRoles(Request $request){
        $data['UID'] = $request->userid?$request->userid:0;
        //先删除用户的所有角色
        UserRole::where('UID',$data['UID'])->delete();
        $roleids = $request->roleids?$request->roleids:[];
        if($roleids == []){
            return response()->json(['status_code' => '500', 'msg' => 'error']);
        }
        foreach ($roleids as $roleid) {
            $data['ROLEID'] = $roleid;
            $datas[] = ['UID'=>$data['UID'],'ROLEID'=>$data['ROLEID']];
        }
        $result = UserRole::insert($datas);
        if(!$result){
            return response()->json(['status_code' => '500', 'msg' => 'error']);
        } else {
            return response()->json(['status_code' => '200', 'msg' => 'ok']);
        }
    }

    //给用户设置用户组
    public function setUserUserGroups(Request $request){
        $data['UID'] = $request->userid?$request->userid:0;
        //先删除用户的所有用户组
        UserGroupUser::where('UID',$data['UID'])->delete();
        $usergroupids = $request->usergroupids?$request->usergroupids:[];
        if($usergroupids == []){
            return response()->json(['status_code' => '500', 'msg' => 'error']);
        }
        foreach ($usergroupids as $usergroupid) {
            $data['UGID'] = $usergroupid;
            $datas[] = ['UID'=>$data['UID'],'UGID'=>$data['UGID']];
        }
        $result = UserGroupUser::insert($datas);
        if(!$result){
            return response()->json(['status_code' => '500', 'msg' => 'error']);
        } else {
            return response()->json(['status_code' => '200', 'msg' => 'ok']);
        }
    }

    //获取用户角色
    public function getUserRoles(Request $request){
        $UID = $request->userid;
        $roles = User::find($UID)->roles()->get()->toArray();
    }

    //获取用户用户组
    public function getUserUserGroups(Request $request){
        $UID = $request->userid;
        $usergroups = User::find($UID)->userGroups()->get()->toArray();
    }

    //获取用户权限
    public function getUserPermissions(Request $request){
        $UID = $request->userid;
    }

    //获取用户功能
    public function getUserFunctions(Request $request){
        $UID = $request->userid;
        $functions = DB::table('V_RBAC_USERFUNCTIONPERMISSION')->where('UID',$UID)->get();
        dd($functions);
    }

    //获取用户菜单
    public function getUserMenus(Request $request){
        $UID = $request->userid;
    }

    //获取用户页面元素
    public function getUserElements(Request $request){
        $UID = $request->userid;
    }

    public function delete(Request $request){
        $UID = $request->id;
        DB::beginTransaction();
        try{ 
            UserGroupUser::where('UID',$UID)->delete();
            UserRole::where('UID',$UID)->delete();
            User::where('UID',$UID)->delete();

            DB::commit();
        }catch (\Exception $e) { 
            DB::rollback();//事务回滚
            return response()->json(['status_code' => '501', 'msg' => '删除失败']);
        }
        return response()->json(['status_code' => '200', 'msg' => 'ok']);
    }
}
