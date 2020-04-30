<?php

/*
 * This file is part of the lucifer103/larabbs.
 *
 * (c) Lucifer <luciferi103@outlook.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Middleware;

use Closure;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 三个判断：
        // 1. 如果用户已经登陆
        // 2. 并且还未认证 Email
        // 3. 并且访问的不是 email 验证相关 URL 或者退出的 URl
        if ($request->user() &&
            !$request->user()->hasVerifiedEmail() &&
            !$request->is('email/*', 'logout')) {
            // 根据客户端返回对应的内容
            return $request->expectsJson()
                ? abort(403, 'Your email address is not verified.')
                : redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
