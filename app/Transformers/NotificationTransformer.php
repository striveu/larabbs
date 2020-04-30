<?php

/*
 * This file is part of the lucifer103/larabbs.
 *
 * (c) Lucifer <luciferi103@outlook.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Notifications\DatabaseNotification;

class NotificationTransformer extends TransformerAbstract
{
    public function transform(DatabaseNotification $notification)
    {
        return [
            'id' => $notification->id,
            'type' => $notification->type,
            'data' => $notification->data,
            'read_at' => $notification->read_at ? $notification->read_at->toDateTimeString() : null,
            'created_at' => $notification->created_at->toDateTimeString(),
            'updated_at' => $notification->updated_at->toDateTimeString(),
        ];
    }
}
