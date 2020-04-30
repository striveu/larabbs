<?php

/*
 * This file is part of the lucifer103/larabbs.
 *
 * (c) Lucifer <luciferi103@outlook.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Reply;
use App\Transformers\ReplyTransformer;
use App\Http\Requests\Api\ReplyRequest;
use App\Models\User;

class RepliesController extends Controller
{
    public function store(ReplyRequest $request, Topic $topic, Reply $reply)
    {
        $reply->content = $request->content;
        $reply->topic()->associate($topic);
        $reply->user()->associate($this->user());
        $reply->save();

        return $this->response->item($reply, new ReplyTransformer())
            ->setStatusCode(201);
    }

    public function destroy(Topic $topic, Reply $reply)
    {
        if ($reply->topic_id != $topic->id) {
            return $this->response->errorBadRequest();
        }

        $this->authorize('destroy', $reply);
        $reply->delete();

        return $this->response->noContent();
    }

    public function index(Topic $topic, Request $request)
    {
        /*
         * 关闭 Dingo 的预加载
         * 有可能使用深层 include 地方都可以暂时这么处理。
         */
        app(\Dingo\Api\Transformer\Factory::class)->disableEagerLoading();

        $replies = $topic->replies()->paginate(20);

        if ($request->include) {
            $replies->load(explode(',', $request->include));
        }

        return $this->response->paginator($replies, new ReplyTransformer());
    }

    public function userIndex(User $user, Request $request)
    {
        app(\Dingo\Api\Transformer\Factory::class)->disableEagerLoading();

        $replies = $user->replies()->paginate(20);

        if ($request->include) {
            $replies->load(explode(',', $request->include));
        }

        return $this->response->paginator($replies, new ReplyTransformer());
    }
}
