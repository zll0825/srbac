<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('rbac.index');
});

Route::group(['namespace' => 'Rbac'], function () {
	Route::get('/user/create', 'UserController@create');//添加用户页面
	Route::get('/user/list', 'UserController@index');//用户列表
	Route::get('/user/role', 'UserController@role');//设置用户角色
	Route::get('/user/usergroup', 'UserController@usergroup');//设置用户用户组
	Route::get('/user/permission', 'UserController@permission');//展示用户权限

	Route::get('/usergroup/create', 'UserGroupController@create');//添加用户组页面
	Route::get('/usergroup/list', 'UserGroupController@index');//用户组列表
	Route::get('/usergroup/role', 'UserGroupController@role');//设置用户组角色
	Route::get('/usergroup/permission', 'UserGroupController@permission');//展示用户组权限

	Route::get('/role/create', 'RoleController@create');//添加角色页面
	Route::get('/role/list', 'RoleController@index');//角色列表
	Route::get('/role/permission', 'RoleController@permission');//设置角色权限

	Route::get('/permission/list', 'PermissionController@index');//权限列表
	Route::get('/permission/menu/element', 'PermissionController@menuelement');//菜单元素
	Route::get('/permission/create', 'PermissionController@create');//添加权限
	Route::get('/permission/menu/create', 'PermissionController@cmenu');//添加菜单页面
	Route::get('/permission/function/create', 'PermissionController@cfunction');//添加功能页面
	Route::get('/permission/element/create', 'PermissionController@celement');//添加元素页面



	Route::post('/user/create', 'UserController@createUser');//添加用户
	Route::post('/usergroup/create', 'UserGroupController@createUserGroup');//添加用户组
	Route::post('/role/create', 'RoleController@createRole');//添加角色
	Route::post('/permission/menu/create', 'PermissionController@createMenu');//添加菜单
	Route::post('/permission/function/create', 'PermissionController@createFunction');//添加功能
	Route::post('/permission/element/create', 'PermissionController@createElement');//添加页面元素

	Route::post('/user/getusergroups', 'UserController@getUserUserGroups');//获取用户用户组
	Route::post('/user/getroles', 'UserController@getUserRoles');//获取用户角色
	Route::post('/user/getpermissions', 'UserController@getUserPermissions');//获取用户权限
	Route::post('/usergroup/getroles', 'UserGroupController@getUserGroupRoles');//获取用户组角色
	Route::post('/usergroup/getpermissions', 'UserGroupController@getUserGroupPermissions');//获取用户组权限
	Route::post('/role/getpermissions', 'RoleController@getRolePermissions');//获取角色权限

	Route::post('/user/setusergroups', 'UserController@setUserUserGroups');//设置用户用户组
	Route::post('/user/setroles', 'UserController@setUserRoles');//设置用户角色
	Route::post('/usergroup/setroles', 'UserGroupController@setUserGroupRoles');//设置用户组角色
	Route::post('/role/setpermissions', 'RoleController@setRolePermissions');//设置角色权限

	Route::post('/user/delete', 'UserController@delete');//删除用户
	Route::post('/usergroup/delete', 'UserGroupController@delete');//删除用户组
	Route::post('/role/delete', 'RoleController@delete');//删除角色
	Route::post('/permission/menu/delete', 'PermissionController@deletemenu');//删除权限
	Route::post('/permission/function/delete', 'PermissionController@deletefunction');//删除权限
	Route::post('/permission/element/delete', 'PermissionController@deleteelement');//删除权限
});