<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-09
 * Time: 16:07
 */

namespace app\api\validate;


use think\Validate;

class BannerValidate extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];
    protected $message = [
        'id.require' => 'id不能为空',
        'id.isPositiveInteger' => 'id必须是正整数'
    ];
}