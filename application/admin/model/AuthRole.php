<?php

namespace app\admin\model;
use think\Model;

class AuthRole extends Model
{
    protected $table = 'le_auth_role';
    protected $hidden = ['pivot','create_user_id','create_time'];

    public function users()
    {
        return $this->belongsToMany('AuthUser');
    }

    //当前角色的所有权限
    public function permissions()
    {
        return $this->belongsToMany('AuthPermission','role_menu','menu_id','role_id');
    }

    //添加一个角色
    public function createRole($data){
        return $this->allowField(true)->save($data);
    }

    //给角色赋予权限
    public function grantPermission($permission)
    {
        return $this->permissions()->saveAll($permission);
    }

    //取消角色赋予的权限
    public function deletePermission($permission)
    {
        return $this->permissions()->detach($permission);
    }

    //判断角色是否有权限
    public function hasPermission($permission)
    {
        //判断集合中是否有某个对象
        return $this->permissions->contains($permission);
    }
}
