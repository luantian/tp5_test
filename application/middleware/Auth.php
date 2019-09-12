<?php
/**
 * Created by PhpStorm.
 * User: terence
 * Date: 2019-09-12
 * Time: 13:59
 */

namespace app\middleware;


class Auth
{
    public function handle($request, \Closure $next)
    {
        if ($request->param('name') == 'think') {
            return redirect('index/think');
        }

        return $next($request);
    }
}