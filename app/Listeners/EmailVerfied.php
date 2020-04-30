<?php

/*
 * This file is part of the lucifer103/larabbs.
 *
 * (c) Lucifer <luciferi103@outlook.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;

class EmailVerfied
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param Verified $event
     */
    public function handle(Verified $event)
    {
        // 会话里闪存认证成功后的消息提醒
        session()->flash('success', '邮箱认证成功 ^_^');
    }
}
