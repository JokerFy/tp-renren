<?php

namespace app\admin\controller;

use app\api\model\Auth;
use think\Controller;
use app\admin\model\{
    AuthUser, AuthToken
};
use app\common\validate\LoginValidate;
use app\common\exception\ParameterException;
use app\lib\Safe;
use think\Db;
use think\Request;

class Common extends Controller
{
    /**
     * 后台管理员用户在后台添加，
     * 无需注册
     */
    public function login()
    {
        (new LoginValidate)->goCheck();
        $adminSalt = AuthUser::get(['username' => input('username')]);
        $admin = AuthUser::get([
            'username' => input('username'),
            'password' => Safe::setpassword(input('password'), $adminSalt->salt)
        ]);
        if (!$admin || !$adminSalt) {
            throw new ParameterException([
                'msg' => '账号或密码错误'
            ]);
        }
        //每次登录更新用户token
        AuthToken::updateToken($admin->id);
        //获取用户token并返回
        return SuccessNotify(AuthToken::usertoken($admin->id));
    }

    /**
     * @return mixed
     */
    public function register()
    {
        Db::startTrans();
        //生成管理员
        $user = AuthUser::createUser(input('username'), input('password'));
        if ($user) {
            //生成管理员token到关联表
            $token = AuthToken::createToken($user->id);
            if ($token){
                //创建管理员和token都成功则提交
                Db::commit();
                return SuccessNotify($token);
            }
        }
        Db::rollback();
        throw ParameterException([
            'msg' => '注册失败'
        ]);
    }

    public function loginout()
    {

    }
}