<?php

namespace App\Http\Controllers\Rbac;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Role;
use App\Http\Models\RolePermission;
use App\Http\Models\PermissionMenu;
use App\Http\Models\PermissionFunction;
use App\Http\Models\PermissionElement;
use App\Http\Models\Menu;
use App\Http\Models\RFunction;
use App\Http\Models\Element;
use App\Http\Models\UserRole;
use App\Http\Models\UserGroupRole;
use DB;

class RoleController extends Controller
{
    //创建角色页面
    public function create(){
        return view('rbac.role.create');
    }

    //角色列表
    public function index(){
        $roles = Role::all();
        return view('rbac.role.list',compact('roles'));
    }

    //设置角色权限
    public function permission(Request $request){
        $roleid = $request->roleid;
        $permissions = Role::find($roleid)->permissions()->get()->toArray();
        $rp = [];
        foreach ($permissions as $permission) {
            $rp[] = $permission['PID'];
        }
        $menus = Menu::join('T_RBAC_PERMISSIONMENU','T_RBAC_PERMISSIONMENU.MID','=','T_RBAC_MENU.MID')->get();
        $funcs = RFunction::join('T_RBAC_PERMISSIONFUNCTION','T_RBAC_PERMISSIONFUNCTION.FID','=','T_RBAC_FUNCTION.FID')->get();
        $elems = Element::join('T_RBAC_PERMISSIONELEMENT','T_RBAC_PERMISSIONELEMENT.EID','=','T_RBAC_ELEMENT.EID')->orderBy('ELEMENTCODE','asc')->get();

        $rmenus = PermissionMenu::whereIn('PID',$rp)->lists('MID');
        $rfuncs = PermissionFunction::whereIn('PID',$rp)->lists('FID');
        $relems = PermissionElement::whereIn('PID',$rp)->lists('EID');

        $rmenus = Menu::whereIn('MID',$rmenus)->get()->toArray();
        $rfuncs = RFunction::whereIn('FID',$rfuncs)->get()->toArray();
        $relems = Element::whereIn('EID',$relems)->get()->toArray();
        $rm = [];
        foreach ($rmenus as $rmenu) {
            $rm[] = $rmenu['MID'];
        }
        $rf = [];
        foreach ($rfuncs as $rfunc) {
            $rf[] = $rfunc['FID'];
        }
        $re = [];
        foreach ($relems as $relem) {
            $re[] = $relem['EID'];
        }
        return view('rbac.role.permission',compact('menus','funcs','elems','rm','rf','re','roleid'));
    }

    public function createRole(Request $request){
        $data['ROLENAME'] = $request->rolename?$request->rolename:'未设置';

        $result = Role::create($data);
        if(!$result){
            return response()->json(['status_code' => '500', 'msg' => 'error']);
        } else {
            return response()->json(['status_code' => '200', 'msg' => 'ok']);
        }
    }

    public function setRolePermissions(Request $request){
        $data['ROLEID'] = $request->roleid?$request->roleid:0;
        //先删角色所有的权限
        RolePermission::where('ROLEID',$data['ROLEID'])->delete();
        $permissionids = $request->permissionids?$request->permissionids:[];
        if($permissionids == []){
            return response()->json(['status_code' => '500', 'msg' => 'error']);
        }
        foreach ($permissionids as $permissionid) {
            $data['PID'] = $permissionid;
            $datas[] = ['ROLEID'=>$data['ROLEID'],'PID'=>$data['PID']];
        }
        $result = RolePermission::insert($datas);
        if(!$result){
            return response()->json(['status_code' => '500', 'msg' => 'error']);
        } else {
            return response()->json(['status_code' => '200', 'msg' => 'ok']);
        }
    }

    public function delete(Request $request){
        $ROLEID = $request->id;
        DB::beginTransaction();
        try{ 
            UserGroupRole::where('ROLEID',$ROLEID)->delete();
            RolePermission::where('ROLEID',$ROLEID)->delete();
            UserRole::where('ROLEID',$ROLEID)->delete();
            Role::where('ROLEID',$ROLEID)->delete();

            DB::commit();
        }catch (\Exception $e) { 
            DB::rollback();//事务回滚
            return response()->json(['status_code' => '501', 'msg' => '删除失败']);
        }
        return response()->json(['status_code' => '200', 'msg' => 'ok']);
    }
}
