<?php

namespace App\Http\Actions\AuthAPI;

use App\Models\User;
use App\Http\Actions\BaseAPIAction;

class RefreshAction extends BaseAPIAction
{
    public function execute(): self
    {
        $user = request()->user();

        $user->currentAccessToken()->delete(); // @phpstan-ignore-line

        $token = $user->createToken('API_TOKEN'); // @phpstan-ignore-line

        $this->result['message'] = 'User Token Refreshed Successfully';

        $this->result['data'] = [
            'token' => $token->plainTextToken,
            'user' => User::find(request()->user()->getAuthIdentifier())->toArray(),
        ];

        return $this;
    }
}
