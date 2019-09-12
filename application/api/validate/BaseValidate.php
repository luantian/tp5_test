<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-09
 * Time: 11:21
 */

namespace app\api\validate;


use app\exception\ParamsException;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        $request = request();
        $params = $request->param();
        $result = $this->batch()->check($params);
        if ( !$result ) {
            throw new ParamsException([ 'msg' => $this->error ]);
        } else {
            return self::getDataByRule($params);
        }
    }

    protected function isPositiveInteger($value, $rule='', $data='', $field='') {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0)) {
            return true;
        } else {
            return false;
        }
    }

    protected function isMobile($value, $rule='', $data='', $field='') {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    protected function isNotEmpty($value, $rule='', $data='', $field='') {
        if (empty($value)) {
            return false;
        }
        return true;
    }

    private function getDataByRule($params) {
        if (array_key_exists('user_id', $params) | array_key_exists('uid', $params)) {
            //不允许包含user_id或者uid，防止恶意覆盖user_id
            throw new ParamsException([
                'msg' => '参数中包含非法参数名'
            ]);
        }

        $newArray = [];

        foreach($this -> rule as $key => $value) {
            $newArray[$key] = $params[$key];
        }
        return $newArray;
    }

}