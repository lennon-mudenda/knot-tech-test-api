<?php

namespace App\Http\Actions\RegAPI;

use Exception;
use App\Models\User;
use App\Http\Actions\BaseAPIAction;
use App\Http\Requests\API\RegisterRequest;

class RegisterAction extends BaseAPIAction
{
    public function execute(RegisterRequest $request): self
    {
        $details = $request->validated();

        try {
            $user = User::create($details);

            $this->result['message'] = 'User Logged In Successfully';

            $this->result['data'] = $user->toArray();
        } catch (Exception $exception) {

            $this->result['message'] = $exception->getMessage();

            $this->result['success'] = false;

            $this->code = 422;

        }

        return $this;
    }
}
