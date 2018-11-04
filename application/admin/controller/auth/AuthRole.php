<?php

namespace app\admin\controller\auth;

use think\Request;
use app\admin\controller\BaseController;

class AuthRole extends BaseController
{
    //获取所有角色的列表
    public function roleList()
    {
        $data = $this->AuthRoleModel::all();
        return SuccessNotify($data);
    }

    //根据用户获取角色列表
    public function userRole(){
        $token = Request::instance()->header('token');
        //根据请求头中的token去获取用户Id
        $userid = $this->AuthTokenModel::getIdByToken($token);
        $data = $this->AuthUserModel->get($userid)->roles;
        return SuccessNotify($data);
    }

    //根据角色id获取角色信息
    public function roleInfo($id){
        $info =$this->AuthRoleModel::get($id);
        return SuccessNotify($info);
    }

    //1.创建一个新角色并授权
    public function addRole()
    {
        $roleData = [
            'role_name' => '创建一个新角色功能测试',
            'remark' => '测试添加新角色功能',
            'create_user_id' => '1',
            'create_time' => '2018-10-31 15:36:45'
        ];

        $permissionList = [
            '0' => '6',
            '1' => '7',
            '2' => '8',
            '3' => '9',
            '4' => '10',
            '5' => '11',
            '6' => '12',
            '7' => '13',
            '8' => '14',
            '9' => '15'
        ];

        Db::startTrans();
        $roleid = $this->AuthRoleModel->create($roleData);

        //查找到当前角色
        $role = $this->AuthRoleModel->get($roleid->id);
        //获取当前角色的所有权限
        $rolePermission = $role->permissions;
        if($rolePermission){
            //删除现有的权限
            $role->deletePermission($rolePermission);
        }
        //更新新的权限
        $grantRes = $role->grantPermission($permissionList);

        if ($roleid && $grantRes) {
            Db::commit();
            return json($role->permissions);
        }
        Db::rollback();
        return json('失败');
    }

    //2.删除角色
    public function deleteRole(){
        $role = $this->AuthRoleModel->get(9);
        //获取当前角色的所有权限
        $rolePermission = $role->permissions;
        Db::startTrans();
        //删除角色中间表中的权限
        $permissonDel = $role->deletePermission($rolePermission);
        //删除角色
        $roleDel = $role->delete();
        if($permissonDel && $roleDel){
            Db::commit();
        }else{
            Db::rollback();
        }
    }

    //3.检查角色有哪些权限
    public function rolePermission(){
        $role = $this->AuthRoleModel->get(8);
        return $role->permissions;
    }

    //4.修改角色权限
    public function editRole(){
        $roleData = [
            'role_name' => 'hehe',
            'remark' => '测试添加新角色功能'
        ];

        $permissionList = [
            '0' => '6',
            '1' => '7',
            '2' => '8',
            '3' => '9',
            '4' => '10',
            '5' => '11',
            '6' => '12'
        ];

        Db::startTrans();
        $role = $this->AuthRoleModel->get(8);
        $updateRole = $role->save($roleData,['id'=>8]);
        //获取当前角色的所有权限
        $rolePermission = $role->permissions;
        if($rolePermission){
            //删除现有的权限
            $role->deletePermission($rolePermission);
        }
        //更新新的权限
        $grantRes = $role->grantPermission($permissionList);

        if ($updateRole && $grantRes) {
            Db::commit();
            return json($role->permissions);
        }
        Db::rollback();
        return json('失败');
    }
}