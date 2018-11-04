<?php

namespace app\admin\model;
use think\Model;

class AuthPermission extends Model
{
    protected $table = 'le_auth_menu';

    //菜单权限属于哪个角色
    public function roles()
    {
        return $this->belongsToMany('AuthRole','le_auth_role_menu');
    }
}
