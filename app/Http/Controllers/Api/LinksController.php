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

use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Resources\LinkResource;

class LinksController extends Controller
{
    public function index(Link $link)
    {
        $links = $link->getAllCached();

        return LinkResource::collection($links);
    }
}
