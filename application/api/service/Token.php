<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-11
 * Time: 18:34
 */

namespace app\api\service;


use app\exception\TokenException;
use app\api\enum\ScopeEnum;
use app\exception\ForbiddenException;
use think\facade\Cache;
use think\Exception;


class Token
{
    public static function generateToken() {
        //32字符组成一组随机字符串
        $randChars = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME'];
        //salt 盐
        $salt = config('secure.token_salt');

        return md5($randChars.$timestamp.$salt);
    }

    public static function getCurrentTokenVar($key) {
        $request = request();
        $token = $request -> header('token');
        $vars = Cache::get($token);

        if (!$vars) {
            throw new TokenException();
        } else {
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
                if (array_key_exists($key, $vars)) {
                    return $vars[$key];
                } else {
                    throw new Exception('获取token的key值不存在');
                }
            }
        }
    }

    public static function getCurrentUid() {
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    //专属Admin权限访问
    public static function needAdminScope() {
        self::setExclusiveScope(ScopeEnum::Admin);
    }

    //专属User权限访问
    public static function needUserScope() {
        self::setExclusiveScope(ScopeEnum::User);
    }

    //User或者Admin权限访问
    public static function needUserOrAdminScope() {
        self::setMultipleScope([ScopeEnum::User, ScopeEnum::Admin]);
    }

    //设置专属权限
    private static function setExclusiveScope($scopeValue) {
        $scope = self::getCurrentTokenVar('scope');
        if ( !$scope ) { throw new TokenException(); }
        if ($scope == $scopeValue) {
            return true;
        } else {
            throw new ForbiddenException();
        }
    }

    //设置多属权限
    private static function setMultipleScope($scopeValues) {
        $scope = self::getCurrentTokenVar('scope');
        if ( !$scope ) { throw new TokenException(); }
        if (in_array($scope, $scopeValues)) {
            return true;
        } else {
            throw new ForbiddenException();
        }
    }
}