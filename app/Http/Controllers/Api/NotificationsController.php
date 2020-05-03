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
use App\Http\Resources\NotificationResource;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()->paginate();

        return NotificationResource::collection($notifications);
    }

    public function stats(Request $request)
    {
        return response()->json([
            'unread_count' => $request->user()->notification_count,
        ]);
    }

    public function read(Request $request)
    {
        $request->user()->markAsRead();

        return response(null, 204);
    }
}
