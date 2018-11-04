<?php

namespace app\admin\controller\auth;

use think\Controller;
use think\Request;

class AuthUser extends Controller{
    //获取所有的管理员用户列表
    public function userList(){
        $data = $this->AuthUserModel->all();
        return SuccessNotify($data);
    }

    //获取当前用户信息
    public function userInfo(){
        $token = Request::instance()->header('token');
        //根据请求头中的token去获取用户Id
        $userid = $this->AuthTokenModel::getIdByToken($token);
        $data = $this->AuthUserModel->get($userid);
        return SuccessNotify($data);
    }

    //修改当前用户密码
    public function changePassword(){
        return SuccessNotify($data);
    }

    //增加用户
    public function addUser()
    {
        Db::startTrans();
        $addUser = $this->AuthUserModel->create([
            'username' => 'test5',
            'password' => '123456'
        ]);
        $user = $this->AuthUserModel->get($addUser->id);
        $res=$user->assignRole(['8']);

        if($res && $addUser){
            Db::commit();
            return json($user);
        }
        Db::rollback();
        return SuccessNotify($data);
    }

    //获取用户所有角色的所有权限
    public function userPermission($id){
        //获取用户
        $user = $this->AuthUserModel->get($id);
        //获取用户所有的角色
        $userRoles = $user->roles;
        //获取用户所有的菜单路由权限
        $userPermission = [];
        //获取用户所有的访问控制器方法的权限
        $userAccess = [];

        //$userRoles是一个二维数组，进行嵌套循环所有每个角色数组下的权限
        foreach($userRoles as $key => $value){
            foreach ($value->permissions->hidden(['pivot']) as $item => $val){
                $userPermission[] = $val;
                if($val['perms']!=false){
                    $userAccess[] = $val['perms'];
                }
            };
        }

        $userPermission = array_unique($userPermission);
        $userAccess = array_unique($userAccess);

        $data = [
            'userPermission'=>$userPermission,
            'userAccess'=>$userAccess
        ];
        return SuccessNotify($data);
    }

    //删除用户
    public function deleteUser(){
        $user = $this->AuthUserModel->get(9);
        //获取所有角色
        $roles = $user->roles;
        //删除中间表下所有角色
        $user->deleteRole($roles);
        //删除用户
        $user->delete();
        return SuccessNotify($data);
    }
}