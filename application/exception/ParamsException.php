<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-05
 * Time: 18:18
 */

namespace app\exception;


class ParamsException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
}