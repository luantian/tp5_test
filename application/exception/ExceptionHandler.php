<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-05
 * Time: 17:21
 */

namespace app\exception;


use Exception;
use think\exception\Handle;
use think\exception\HttpException;

class ExceptionHandler extends Handle
{
    public $code;
    public $msg;
    public function render(Exception $e)
    {

        if ( $e instanceof BaseException ) {
            $this -> msg = $e -> msg;
            $this -> code = $e -> code;
        } elseif ( $e instanceof HttpException ) {
            $this -> msg = '请求的接口不存在';
            $this -> code = 404;
        } else {
            if ( config('app_debug') ) {
                return parent::render($e);
            } else {
                $this->code = 500;
                $this->msg = '服务器错误, 请联系管理员';
            }
        }

        $result = [
            'code' => $this -> code,
            'msg' => $this -> msg
        ];

        return json($result);

    }
}