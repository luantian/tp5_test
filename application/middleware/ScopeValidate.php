<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-12
 * Time: 13:59
 */

namespace app\middleware;


class ScopeValidate
{
    public function handle($request, \Closure $next, $name)
    {
        var_dump($name);
        return $next($request);
    }
}