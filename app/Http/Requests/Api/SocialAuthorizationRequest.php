<?php

/*
 * This file is part of the lucifer103/larabbs.
 *
 * (c) Lucifer <luciferi103@outlook.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Requests\Api;

class SocialAuthorizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'code' => 'required_without:access_token|string',
            'access_token' => 'required_without:code|string',
        ];

        if ('weixin' == $this->social_type && !$this->code) {
            $rules['openid'] = 'required|string';
        }

        return $rules;
    }
}
