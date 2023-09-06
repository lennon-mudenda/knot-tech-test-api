<?php

namespace App\Http\Actions\AuthAPI;

use App\Models\User;
use App\Http\Actions\BaseAPIAction;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\API\LoginRequest;

class LoginAction extends BaseAPIAction
{
    public function execute(LoginRequest $request): self
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {

            $user = User::find(request()->user()->getAuthIdentifier());

            $user->tokens()->delete();

            $token = $user->createToken('API_TOKEN');

            $this->result['message'] = 'User Logged In Successfully';

            $this->result['data'] = [
                'token' => $token->plainTextToken,
                'user' => $user->toArray(),
            ];
        } else {
            $this->result['message'] = 'Invalid Credentials';

            $this->result['success'] = false;

            $this->code = 401;
        }

        return $this;
    }
}
