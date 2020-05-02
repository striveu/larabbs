<?php

/*
 * This file is part of the lucifer103/larabbs.
 *
 * (c) Lucifer <luciferi103@outlook.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

Route::prefix('v1')
    ->namespace('Api')
    ->name('api.v1.')
    ->group(function () {
        Route::middleware('throttle:'.config('api.rate_limits.sign.limit').','.config('api.rate_limits.sign.expires'))
            ->group(function () {
                // 图片验证码
                Route::post('captchas', 'CaptchasController@store')->name('captchas.store');
                // 短信验证码
                Route::post('verificationCodes', 'VerificationCodesController@store')->name('verificationCodes.store');
                // 用户注册
                Route::post('users', 'UsersController@store')->name('users.store');
                // 第三方登录
                Route::post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')->where('social_type', 'weixin')->name('socials.authorizations.store');
                // 登录
                Route::post('authorizations', 'AuthorizationsController@store')->name('authorizations.store');
                // 刷新 token
                Route::put('authorizations/current', 'AuthorizationsController@update')->name('authorizations.upodate');
                // 删除 token
                Route::delete('authorizations/current', 'AuthorizationsController@destroy')->name('authorizations.destroy');
            });

        Route::middleware('throttle:'.config('api.rate_limits.access.limit').','.config('api.rate_limits.access.expires'))
            ->group(function () {
                // 游客可以访问的接口

                // 某个用户的详情
                Route::get('users/{user}', 'UsersController@show')->name('users.show');

                // 登录后可以访问的接口
                Route::middleware('auth:api')->group(function () {
                    // 当前登录用户信息
                    Route::get('user', 'UsersController@me')->name('user.show');
                    // 上传图片
                    Route::post('images', 'ImagesController@store')->name('images.store');
                    // 编辑登录用户信息
                    Route::patch('user', 'UsersController@update')->name('user.update');
                });
            });
    });
