<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-12
 * Time: 15:43
 */

namespace app\api\controller;
use app\api\service\Token as TokenService;

use think\Controller;

class BaseController extends Controller
{
    protected function checkUserScope() {
        TokenService::needUserScope();
    }

    protected function checkAdminScope() {
        TokenService::needAdminScope();
    }

    protected function checkUserOrAdminScope() {
        TokenService::needUserOrAdminScope();
    }
}