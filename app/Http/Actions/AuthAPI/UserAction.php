<?php

namespace App\Http\Actions\AuthAPI;

use App\Models\User;
use App\Http\Actions\BaseAPIAction;

class UserAction extends BaseAPIAction
{
    public function execute(): self
    {
        $this->result['message'] = 'Current User Retrieved Successfully';

        $this->result['data'] = [
            'user' => User::find(request()->user()->getAuthIdentifier())->toArray(),
        ];

        return $this;
    }
}
