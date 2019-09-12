<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-11
 * Time: 15:56
 */

namespace app\api\model;


class User extends BaseModel
{
    public function address()
    {
        return $this -> hasOne('UserAddress', 'user_id', 'id');
    }

    public static function getByOpenId($openid) {
        $user = self::where('openid', '=', $openid)
            ->find();

        return $user;
    }
}