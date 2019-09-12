<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-11
 * Time: 19:43
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;
use app\exception\UserException;


class Address extends BaseController
{

    protected $beforeActionList = [
        'checkUserScope' => ['only' => 'createOrUpdateAddress']
    ];

    public function createOrUpdateAddress() {
        $validate = new AddressNew();
        $ruleParams = $validate -> goCheck();
        /**
         * TODO 根据token获取用户uid
         * TODO 根据uid查找用户数据，判断用户是否存在，如果不存在抛出异常
         * TODO 获取用户从客户端提交的地址信息
         */

        $uid = TokenService::getCurrentUid();

        $user = UserModel::get($uid);

        if (!$user) {
            throw new UserException();
        }

        $userAddress = $user -> address;
        if (!$userAddress) {
            //神奇的新增
            $user -> address() -> save($ruleParams);
        } else {
            //神奇的更新
            $user -> address -> save($ruleParams);
        }

        return success($user);
    }
}