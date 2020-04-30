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

use App\Transformers\PermissionTransformer;

class PermissionsController extends Controller
{
    public function index()
    {
        $permissions = $this->user()->getAllPermissions();

        return $this->response->collection($permissions, new PermissionTransformer());
    }
}
