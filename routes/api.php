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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings', 'change-locale'],
], function ($api) {
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function ($api) {
        // 小程序登录
        $api->post('weapp/authorizations', 'AuthorizationsController@weappStore')
            ->name('api.weapp.authorizations.store');
        // 小程序注册
        $api->post('weapp/users', 'UsersController@weappStore')
            ->name('api.weapp.users.store');
        // 分类列表
        $api->get('categories', 'CategoriesController@index')
            ->name('api.categories.index');
        // 话题列表
        $api->get('topics', 'TopicsController@index')
            ->name('api.topics.index');
        // 话题详情
        $api->get('topics/{topic}', 'TopicsController@show')
            ->name('api.topics.show');
        // 某个用户发表的话题列表
        $api->get('users/{user}/topics', 'TopicsController@userIndex')
            ->name('api.users.topics.index');
        // 某个话题的回复列表
        $api->get('topics/{topic}/replies', 'RepliesController@index')
            ->name('api.topics.replies.index');
        // 某个用户回复列表
        $api->get('users/{user}/replies', 'RepliesController@userIndex')
            ->name('api.users.replies.index');
        // 资源推荐
        $api->get('links', 'LinksController@index')
            ->name('api.links.index');
        // 活跃用户
        $api->get('actived/users', 'UsersController@activedIndex')
            ->name('api.actived.users.index');
        // 需要 token 验证的接口
        $api->group(['middleware' => 'api.auth'], function ($api) {
            // 编辑登录用户信息
            $api->patch('user', 'UsersController@update')
                ->name('api.user.patch');
            $api->put('user', 'UsersController@update')
                ->name('api.user.update');
            // 发布话题
            $api->post('topics', 'TopicsController@store')
                ->name('api.topics.store');
            // 修改话题
            $api->patch('topics/{topic}', 'TopicsController@update')
                ->name('api.topics.update');
            // 删除话题
            $api->delete('topics/{topic}', 'TopicsController@destroy')
                ->name('api.topics.destroy');
            // 发布回复
            $api->post('topics/{topic}/replies', 'RepliesController@store')
                ->name('api.topics.replies.store');
            // 删除回复
            $api->delete('topics/{topic}/replies/{reply}', 'RepliesController@destroy')
                ->name('api.topics.replies.destroy');
            // 通知列表
            $api->get('user/notifications', 'NotificationsController@index')
                ->name('api.user.notifications.index');
            // 通知统计
            $api->get('user/notifications/stats', 'NotificationsController@stats')
                ->name('api.user.notifications.stats');
            // 标记消息通知为已读
            $api->patch('user/read/notifications', 'NotificationsController@read')
                ->name('api.user.notifications.read');
            $api->put('user/read/notifications', 'NotificationsController@read')
                ->name('api.user.notification.read.put');
            // 当前登录用户权限
            $api->get('user/permissions', 'PermissionsController@index')
                ->name('api.user.permissions.index');
        });
    });
});
