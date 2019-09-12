<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-09
 * Time: 17:05
 */

namespace app\exception;


class EmptyException extends BaseException
{
    public $msg = '数据为空';
    public $code = 200;
}