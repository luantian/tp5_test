<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-12
 * Time: 13:22
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\Token as TokenService;
use app\exception\TokenException;
use app\api\enum\ScopeEnum;
use app\exception\ForbiddenException;


class Order extends BaseController
{
    protected $beforeActionList = [
        'checkUserOrAdminScope' => ['only' => 'placeOrder']
    ];

    public function placeOrder() {
        return 'order';
    }
}