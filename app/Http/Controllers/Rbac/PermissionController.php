<?php

namespace App\Http\Controllers\Rbac;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Permission;
use App\Http\Models\Menu;
use App\Http\Models\RFunction;
use App\Http\Models\Element;
use App\Http\Models\File;
use App\Http\Models\PermissionMenu;
use App\Http\Models\PermissionFunction;
use App\Http\Models\PermissionElement;
use App\Http\Models\PermissionFile;
use App\Http\Models\RolePermission;
use DB;

class PermissionController extends Controller
{
    //权限页面
    public function index(){
        $menus = Menu::get()->toArray();
        $funcs = RFunction::get()->toArray();
        $elems = Element::orderBy('ELEMENTCODE','asc')->get()->toArray();
        return view('rbac.permission.index',compact('menus','funcs','elems'));
    }

    //菜单元素页面
    public function menuelement(Request $request){
        $menucode = Menu::where('MID',$request->mid)->pluck('MENUCODE');
        $elems = Element::where('ELEMENTCODE','like',$menucode.'%')->orderBy('ELEMENTCODE','asc')->get()->toArray();
        return view('rbac.permission.menu.element',compact('elems'));
    }

    //添加权限页面
    public function create(){
        return view('rbac.permission.create');
    }

    //创建菜单页面
    public function cmenu(){
        $topmenus = Menu::where('PARENTMID',0)->get()->toArray();
        return view('rbac.permission.menu.create',compact('topmenus'));
    }

    //创建功能页面
    public function cfunction(){
        $topfunctions = RFunction::where('PARENTFID',0)->get()->toArray();
        return view('rbac.permission.function.create',compact('topfunctions'));
    }

    //创建元素页面
    public function celement(){
        $menus = Menu::get()->toArray();
        return view('rbac.permission.element.create',compact('menus'));
    }

    public function createMenu(Request $request){
        //开启事务 
        DB::beginTransaction();
        try{ 
            $data['MENUNAME'] = $request->menuname?$request->menuname:'未设置';
            $data['MENUCODE'] = $request->menucode?$request->menucode:'00';
            $data['MENUURL'] = $request->menuurl?$request->menuurl:'';
            $data['PARENTMID'] = $request->parentmid?$request->parentmid:0;
            $MID = Menu::insertGetId($data);

            $data = [];
            $data['PERMISSIONTYPE'] = $request->permissiontype?$request->permissiontype:'未设置';
            $data['APPLICATION'] = $request->application?$request->application:'PC';
            $PID = Permission::insertGetId($data);

            $data = [];
            $data['PID'] = $PID;
            $data['MID'] = $MID;

            $result = PermissionMenu::create($data);

            DB::commit();
        }catch (\Exception $e) { 
            DB::rollback();//事务回滚
            return response()->json(['status_code' => '501', 'msg' => 'error']);
        }
        if(!$result){
            return response()->json(['status_code' => '500', 'msg' => 'error']);
        } else {
            return response()->json(['status_code' => '200', 'msg' => 'ok']);
        }
    }

    public function createFunction(Request $request){
        //开启事务 
        DB::beginTransaction();
        try{ 
            $data['FUNCTIONNAME'] = $request->functionname?$request->functionname:'未设置';
            $data['FUNCTIONCODE'] = $request->functioncode?$request->functioncode:'00';
            $data['FILTERURL'] = $request->filterurl?$request->filterurl:'';
            $data['PARENTFID'] = $request->parentfid?$request->parentfid:0;
            $FID = RFunction::insertGetId($data);

            $data = [];
            $data['PERMISSIONTYPE'] = $request->permissiontype?$request->permissiontype:'未设置';
            $data['APPLICATION'] = $request->application?$request->application:'PC';
            $PID = Permission::insertGetId($data);

            $data = [];
            $data['FID'] = $FID;
            $data['PID'] = $PID;

            $result = PermissionFunction::create($data);

            DB::commit();
        }catch (\Exception $e) { 
            DB::rollback();//事务回滚
            return response()->json(['status_code' => '501', 'msg' => 'error']);
        }
        if(!$result){
            return response()->json(['status_code' => '500', 'msg' => 'error']);
        } else {
            return response()->json(['status_code' => '200', 'msg' => 'ok']);
        }
    }

    public function createElement(Request $request){
        //开启事务 
        DB::beginTransaction();
        try{ 
            $data['ELEMENTCODE'] = $request->elementcode?$request->elementcode:'00';
            $data['ELEMENTCODE'] = $request->menucode?$request->menucode.'-'.$data['ELEMENTCODE']:'00'.'-'.$data['ELEMENTCODE'];
            $EID = Element::insertGetId($data);

            $data = [];
            $data['PERMISSIONTYPE'] = $request->permissiontype?$request->permissiontype:'未设置';
            $data['APPLICATION'] = $request->application?$request->application:'PC';
            $PID = Permission::insertGetId($data);

            $data = [];
            $data['PID'] = $PID;
            $data['EID'] = $EID;

            $result = PermissionElement::create($data);

            DB::commit();
        }catch (\Exception $e) { 
            DB::rollback();//事务回滚
            return response()->json(['status_code' => '501', 'msg' => 'error']);
        }
        if(!$result){
            return response()->json(['status_code' => '500', 'msg' => 'error']);
        } else {
            return response()->json(['status_code' => '200', 'msg' => 'ok']);
        }
    }

    public function deletemenu(Request $request){
        $MID = $request->id;
        $PID = PermissionMenu::where('MID',$MID)->pluck('PID');
        if(Menu::where('PARENTMID',$MID)->count() > 0 ){
            return response()->json(['status_code' => '500', 'msg' => '有子栏目，不能删除']);
        }
        DB::beginTransaction();
        try{ 
            PermissionMenu::where('MID',$MID)->delete();
            RolePermission::where('PID',$PID)->delete();
            Menu::where('MID',$MID)->delete();
            Permission::where('PID',$PID)->delete();

            DB::commit();
        }catch (\Exception $e) { 
            DB::rollback();//事务回滚
            return response()->json(['status_code' => '501', 'msg' => '删除失败']);
        }
        return response()->json(['status_code' => '200', 'msg' => 'ok']);
    }

    public function deletefunction(Request $request){
        $FID = $request->id;
        $PID = PermissionFunction::where('FID',$FID)->pluck('PID');
        if(RFunction::where('PARENTFID',$FID)->count() > 0 ){
            return response()->json(['status_code' => '500', 'msg' => '有子功能，不能删除']);
        }
        DB::beginTransaction();
        try{ 
            PermissionFunction::where('FID',$FID)->delete();
            RolePermission::where('PID',$PID)->delete();
            RFunction::where('FID',$FID)->delete();
            Permission::where('PID',$PID)->delete();

            DB::commit();
        }catch (\Exception $e) { 
            DB::rollback();//事务回滚
            return response()->json(['status_code' => '501', 'msg' => '删除失败']);
        }
        return response()->json(['status_code' => '200', 'msg' => 'ok']);
    }

    public function deleteelement(Request $request){
        $EID = $request->id;
        $PID = PermissionElement::where('EID',$EID)->pluck('PID');
        DB::beginTransaction();
        try{ 
            PermissionElement::where('EID',$EID)->delete();
            RolePermission::where('PID',$PID)->delete();
            Element::where('EID',$EID)->delete();
            Permission::where('PID',$PID)->delete();

            DB::commit();
        }catch (\Exception $e) { 
            DB::rollback();//事务回滚
            return response()->json(['status_code' => '501', 'msg' => '删除失败']);
        }
        return response()->json(['status_code' => '200', 'msg' => 'ok']);
    }
}
