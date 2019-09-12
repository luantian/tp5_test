<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-05
 * Time: 17:42
 */

namespace app\exception;


use think\Exception;
use Throwable;

class BaseException extends Exception
{
    public $code = 500;
    public $msg = '未知错误，请联系管理员';

    public function __construct($params = [])
    {
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
    }
}