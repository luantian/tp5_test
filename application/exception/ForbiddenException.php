<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-12
 * Time: 11:34
 */

namespace app\exception;


use app\api\validate\BaseValidate;

class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不足';
}