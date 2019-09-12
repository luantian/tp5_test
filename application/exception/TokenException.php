<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-11
 * Time: 18:54
 */

namespace app\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Token已过期或无效token';
}