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
    ->middleware('change-locale')
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
                // 小程序登录
                Route::post('weapp/authorizations', 'AuthorizationsController@weappStore')->name('weapp.authorizations.store');
                // 小程序注册
                Route::post('weapp/users', 'UsersController@weappStore')->name('weapp.users.store');
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
                // 分类列表
                Route::get('categories', 'CategoriesController@index')->name('categories.index');
                // 某个用户发布的话题
                Route::get('users/{user}/topics', 'TopicsController@userIndex')->name('users.topics.index');
                // 话题列表，详情
                Route::resource('topics', 'TopicsController')->only([
                    'index', 'show',
                ]);
                // 话题回复列表
                Route::get('topics/{topic}/replies', 'RepliesController@index')->name('topics.replies.index');
                // 某个用户的回复列表
                Route::get('users/{user}/replies', 'RepliesController@userIndex')->name('users.replies.index');
                // 资源推荐
                Route::get('links', 'LinksController@index')->name('links.index');
                // 活跃用户
                Route::get('actived/users', 'UsersController@activedIndex')->name('actived.users.index');

                // 登录后可以访问的接口
                Route::middleware('auth:api')->group(function() {
                    // 当前登录用户信息
                    Route::get('user', 'UsersController@me')->name('user.show');
                    // 上传图片
                    Route::post('images', 'ImagesController@store')->name('images.store');
                    // 编辑登录用户信息
                    Route::patch('user', 'UsersController@update')->name('user.update');
                    Route::put('user', 'UsersController@update')->name('user.update');
                    // 发布话题
                    Route::resource('topics', 'TopicsController')->only([
                        'store', 'update', 'destroy',
                    ]);
                    // 发布回复
                    Route::post('topics/{topic}/replies', 'RepliesController@store')->name('topics.replies.store');
                    // 删除回复
                    Route::delete('topics/{topic}/replies/{reply}', 'RepliesController@destroy')->name('topics.replies.destroy');
                    // 通知列表
                    Route::get('notifications', 'NotificationsController@index')->name('notifications.index');
                    // 通知统计
                    Route::get('notifications/stats', 'NotificationsController@stats')->name('notifications.stats');
                    // 标记消息通知为已读
                    Route::patch('user/read/notifications', 'NotificationsController@read')->name('users.notifications.read');
                    // 当前登录用户权限
                    Route::get('user/permissions', 'PermissionsController@index')->name('user.permissions.index');
                });
            });
    });
