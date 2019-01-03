<?php

namespace App\Http\Middleware;

use Closure;

class Activity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //前置
        /*if (time() < strtotime('2019-01-20')) {
            return redirect('student/activity');
        }

        return $next($request);*/

        //后置
        $response = $next($request);

        if (time() < strtotime('2019-01-20')) {
            echo 'test';
        }

        return $response;
    }
}
