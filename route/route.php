<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//Route::rule('路由表达式', '路由地址', '请求类型', '路由参数(数组)', '变量规则(数组)');




Route::group(':version/banner', function() {
    Route::rule('/:id', 'api/:version.Banner/index', 'POST');
});

Route::group(':version/token', function() {
    Route::rule('/user', 'api/:version.Token/getToken', 'POST');
});

Route::rule(':version/address', 'api/:version.Address/createOrUpdateAddress', 'POST');
Route::rule(':version/order', 'api/:version.Order/placeOrder', 'POST');

return [

];