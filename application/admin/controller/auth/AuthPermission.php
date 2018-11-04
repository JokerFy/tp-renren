<?php

namespace app\admin\controller\auth;

use think\Controller;
use app\admin\model\{AuthRole as roleModel,AuthToken as tokenModel,AuthUser as userModel};
use think\Request;

class AuthPermission extends Controller{
    /**
     * 4.根据用户的权限生成菜单树（因为前后端分离，所以这里相当于是获取了给前端显示菜单的路由）
     * menulist是用户的路由菜单权限，前端根据该数值动态显示菜单
     * permissions是用户的访问权限，前端根据该值判断用户能访问后端的哪些路由，并且根据权限判断是否显示增加删除等按钮
     * @return \think\response\Json
     */
    public function userMenuData(){
        $userPermisson = $this->userPermission(2);
        $menuList = $this->treeData($userPermisson['userPermission']);
        $permissions = $userPermisson['userAccess'];
        $data = ['data'=>['menulist'=>$menuList,'permissions'=>$permissions]];
        return json($data);
    }
}