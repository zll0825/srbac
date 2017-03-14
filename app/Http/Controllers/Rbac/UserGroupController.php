<?php

namespace App\Http\Controllers\Rbac;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\UserGroup;
use App\Http\Models\UserGroupUser;
use App\Http\Models\UserGroupRole;
use App\Http\Models\Role;
use App\Http\Models\PermissionMenu;
use App\Http\Models\PermissionFunction;
use App\Http\Models\PermissionElement;
use App\Http\Models\Menu;
use App\Http\Models\RFunction;
use App\Http\Models\Element;
use DB;

class UserGroupController extends Controller
{
    //创建用户组页面
    public function create(){
        $topgroups = UserGroup::where('PARENTUGID',0)->get()->toArray();
        // dd($topgroups);
        return view('rbac.usergroup.create',compact('topgroups'));
    }

    //用户组列表
    public function index(){
        $usergroups = UserGroup::all();
        return view('rbac.usergroup.list',compact('usergroups'));
    }

    //设置用户组角色
    public function role(Request $request){
        $UGID = $request->usergroupid;
        $groles = UserGroup::find($UGID)->roles()->get()->toArray();
        $roles = Role::all();
        $gr = [];
        foreach ($groles as $grole) {
            $gr[] = $grole['ROLEID'];
        }
        return view('rbac.usergroup.role',compact('roles','gr','UGID'));
    }

    //展示用户组权限
    public function permission(Request $request){
        $UGID = $request->usergroupid;
        $groles = UserGroup::find($UGID)->roles()->get()->toArray();
        $roles = Role::all();
        $gr = [];
        foreach ($groles as $grole) {
            $gr[] = $grole['ROLEID'];
        }
        $rp = [];
        foreach ($gr as $roleid) {
            $permissions = Role::find($roleid)->permissions()->get()->toArray();
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
        return view('rbac.usergroup.permission',compact('menus','funcs','elems'));
    }

    public function createUserGroup(Request $request){
        $data['GROUPNAME'] = $request->groupname?$request->groupname:'未设置';
        $data['PARENTUGID'] = $request->parentugid?$request->parentugid:0;

        $result = UserGroup::create($data);
        if(!$result){
            return response()->json(['status_code' => '500', 'msg' => 'error']);
        } else {
            return response()->json(['status_code' => '200', 'msg' => 'ok']);
        }
    }

    public function setUserGroupRoles(Request $request){
        $data['UGID'] = $request->usergroupid?$request->usergroupid:0;
        //先删除用户组的所有角色
        UserGroupRole::where('UGID',$data['UGID'])->delete();
        $roleids = $request->roleids?$request->roleids:[];
        if($roleids == []){
            return response()->json(['status_code' => '500', 'msg' => 'error']);
        }
        foreach ($roleids as $roleid) {
            $data['ROLEID'] = $roleid;
            $datas[] = ['UGID'=>$data['UGID'],'ROLEID'=>$data['ROLEID']];
        }
        $result = UserGroupRole::insert($datas);
        if(!$result){
            return response()->json(['status_code' => '500', 'msg' => 'error']);
        } else {
            return response()->json(['status_code' => '200', 'msg' => 'ok']);
        }
    }

    public function delete(Request $request){
        $UGID = $request->id;
        DB::beginTransaction();
        try{ 
            UserGroupUser::where('UGID',$UGID)->delete();
            UserGroupRole::where('UGID',$UGID)->delete();
            UserGroup::where('UGID',$UGID)->delete();

            DB::commit();
        }catch (\Exception $e) { 
            DB::rollback();//事务回滚
            return response()->json(['status_code' => '501', 'msg' => '删除失败']);
        }
        return response()->json(['status_code' => '200', 'msg' => 'ok']);
    }
}
