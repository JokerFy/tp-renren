<?php
use think\Route;

//登录需要保证用户信息的安全性所以使用post
/*Route::post('sys/login','admin/Common/login');
Route::post('sys/register','admin/Common/register');*/

Route::group('admin/user',function(){
    // 获取用户列表
    Route::get('/list', 'admin/auth.AuthRole/getComplexOne');
    // 修改密码
    Route::post('/password', 'admin/auth.AuthRole/addThemeProduct');
    // 获取用户信息
    Route::post('/info', 'admin/auth.AuthRole/deleteThemeProduct');
    // 添加用户
    Route::post('/add', 'admin/auth.AuthRole/deleteThemeProduct');
    // 修改用户
    Route::post('/update', 'admin/auth.AuthRole/deleteThemeProduct');
    // 删除用户
    Route::post('/delete', 'admin/auth.AuthRole/deleteThemeProduct');
});

Route::group('admin/menu',function(){
    // 获取导航菜单列表 / 权限
    Route::get('/nav', 'admin/auth.AuthRole/getSimpleList');
    // 获取菜单列表
    Route::get('/list', 'admin/auth.AuthRole/getComplexOne');
    // 获取上级菜单
    Route::post('/select', 'admin/auth.AuthRole/addThemeProduct');
    // 获取菜单信息
    Route::post('/info', 'admin/auth.AuthRole/deleteThemeProduct');
    // 添加菜单
    Route::post('/add', 'admin/auth.AuthRole/deleteThemeProduct');
    // 修改菜单
    Route::post('/update', 'admin/auth.AuthRole/deleteThemeProduct');
    // 删除菜单
    Route::post('/delete', 'admin/auth.AuthRole/deleteThemeProduct');
});

Route::group('admin/role',function(){
    // 获取角色列表
    Route::get('/list', 'admin/auth.AuthRole/roleList');
    // 获取角色列表, 根据当前用户
    Route::get('/select', 'admin/auth.AuthRole/userRole');
    // 获取角色信息
    Route::post('/info/:id', 'admin/auth.AuthRole/roleInfo');
    // 添加角色
    Route::post('/add', 'admin/auth.AuthRole/deleteThemeProduct');
    // 修改角色
    Route::post('/update', 'admin/auth.AuthRole/deleteThemeProduct');
    // 删除角色
    Route::post('/delete', 'admin/auth.AuthRole/deleteThemeProduct');
});


//用户权限控制篇：
//角色篇
//1.添加一个新角色
Route::post('api/Role', 'auth/Test/addRole');
//2.授予角色权限
Route::post('api/grantRole', 'auth/Test/grantRolePermission');
//2.删除角色
Route::delete('api/Role', 'auth/Test/deleteRole');
//2.更新角色
Route::put('api/Role', 'auth/Test/editRole');

//User:
//1.添加用户
Route::post('api/User', 'auth/Test/addUser');
//2.删除用户
Route::delete('api/User', 'auth/Test/deleteUser');
//3.获取用户的导航菜单列表 / 权限
Route::get('api/userPermission', 'auth/Test/userMenuData');

