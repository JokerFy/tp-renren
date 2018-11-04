<?php

namespace app\admin\controller;

use app\lib\RegisterTree;
use app\lib\ModelFactory;
use think\Controller;

class BaseController extends Controller
{
    protected $AuthPermissionModel;
    protected $AuthTokenModel;
    protected $AuthRoleModel;
    protected $AuthUserModel;

    public function _initialize()
    {
        //使用工厂模式对使用到的模型进行创建，然后子类继承后可以直接调用模型，减少复用
        $this->AuthPermissionModel = ModelFactory::AuthPermission();
        $this->AuthTokenModel = ModelFactory::AuthToken();
        $this->AuthRoleModel = ModelFactory::AuthRole();
        $this->AuthUserModel = ModelFactory::AuthUser();
    }
}
