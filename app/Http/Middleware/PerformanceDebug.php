<?php

namespace App\Http\Middleware;

use Closure;

class PerformanceDebug
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
        $response = $next($request);

        // 确保在开发环境下
        if (app()->isLocal()) {

            // 计算包含了多少文件
            // $included_files_count = count(get_included_files());
            // dd($included_files_count);
        }

        return $response;
    }
}