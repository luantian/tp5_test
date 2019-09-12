<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-11
 * Time: 15:57
 */

namespace app\api\service;


use app\api\enum\ScopeEnum;
use app\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    public function __construct($code)
    {
        $this -> code = $code;
        $this -> wxAppID = config('wechat.app_id');
        $this -> wxAppSecret = config('wechat.app_secret');
        $this -> wxLoginUrl = sprintf(config('wechat.login_url'), $this -> wxAppID, $this -> wxAppSecret, $this -> code);
    }

    public function get() {
        $result = curl_get($this -> wxLoginUrl);
        $wxResult = json_decode($result, true);

        //微信接口返回的错误还并不一定全部包含, 此处不是很稳定

        if (empty($wxResult)) {
            throw new Exception('获取session_key及openID时异常，微信内部错误');
        } else {
            $loginFail = array_key_exists('errcode', $wxResult);

            if ($loginFail) {
                $this -> processLoginError($wxResult);
            } else {
                return $this -> grantToken($wxResult);
            }
        }
    }

    private function grantToken($wxResult) {
        //拿到openid
        //数据库里查看，openID是否已经存在
        //如果存在则不处理，如果不存在则新增一条
        //生成令牌，准备缓存数据，写入缓存
        //把令牌返回到客户端

        $openid = $wxResult['openid'];

        $user = UserModel::getByOpenId($openid);
        if ($user) {
            $uid = $user -> id;
        } else {
            $uid = $this -> newUser($openid);
        }

        $cachedValue = $this -> prepareCachedValue($wxResult, $uid);
        $token = $this -> saveToCache($cachedValue);
        return $token;

    }

    private function saveToCache($cachedValue) {
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_in');

        //tp5自带缓存，需要配置，默认是文件，redis优势在于结构化数据，会比文件快一丢丢
        $request = cache($key, $value, $expire_in);
        if (!$request) {
            throw new TokenException([
                'msg' => '服务器缓存异常'
            ]);
        }
        return $key;
    }

    private function prepareCachedValue($wxResult, $uid) {
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = ScopeEnum::User;
        return $cachedValue;
    }

    private function newUser($openid) {
        $user = UserModel::create([
            'openid' => $openid
        ]);
        return $user -> id;
    }

    private function processLoginError($wxResult) {
        throw new WeChatException([
            'msg' => $wxResult['errmsg']
        ]);
    }
}