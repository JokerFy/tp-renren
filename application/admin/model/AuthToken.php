<?php

namespace app\admin\model;
use think\Model;
use app\lib\Safe;

class AuthToken extends Model
{
    protected $table = "le_auth_user_token";
    protected $hidden = ['update_time'];

    //根据id获取用户token
    public static function usertoken($id){
        $usertoken = self::get($id);
        return $usertoken;
    }

    //根据token来获取用户id
    public static function getIdByToken($token){
        $id = self::get(['token'=>$token])->user_id;
        return $id;
    }

    //根据用户id在中间表生成token
    public static function createToken($id){
        $tokenData = Safe::generateToken();
        self::create([
            'user_id'=>$id,
            'token' => $tokenData['token'],
            'expire_time' => $tokenData['expire'],
            'update_time' => time()
        ]);
    }

    //登录时更新用户Token
    public static function updateToken($id){
        $tokenData = Safe::generateToken();
        self::update([
            'user_id'=>$id,
            'token' => $tokenData['token'],
            'expire_time' => $tokenData['expire'],
            'update_time' => time()
        ]);
    }
}