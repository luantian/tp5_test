<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-11
 * Time: 20:20
 */

namespace app\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '当前用户不存在';
}