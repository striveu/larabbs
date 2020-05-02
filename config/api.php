<?php

/*
 * This file is part of the lucifer103/larabbs.
 *
 * (c) Lucifer <luciferi103@outlook.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    /*
     * 接口频率限制
     */
    'rate_limits' => [
        // 访问频率限制，次数 / 分钟
        'access' => [
            'expires' => env('RATE_LIMITS_EXPIRES', 1),
            'limit' => env('RATE_LIMITS', 60),
        ],
        // 登录相关，次数 / 分钟
        'sign' => [
            'expires' => env('SIGN_RATE_LIMITS_EXPIRES', 1),
            'limit' => env('SIGN_RATE_LIMITS', 10),
        ],
    ],
];
