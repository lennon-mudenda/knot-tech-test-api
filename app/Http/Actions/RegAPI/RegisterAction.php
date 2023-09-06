<?php

namespace App\Http\Actions\RegAPI;

use Exception;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use App\Http\Actions\BaseAPIAction;
use App\Http\Requests\API\RegisterRequest;

class RegisterAction extends BaseAPIAction
{
    public function execute(RegisterRequest $request): self
    {
        $details = $request->validated();

        try {
            $role = Role::where('uuid', Role::USER_UUID)->first();

            $details['uuid'] = Str::uuid();

            $details['role_id'] = $role->id;

            $details['role_uuid'] = Role::USER_UUID;

            $user = User::create($details);

            $this->result['message'] = 'User Registered Successfully';

            $this->result['data'] = $user->toArray();
        } catch (Exception $exception) {

            $this->result['message'] = $exception->getMessage();

            $this->result['success'] = false;

            $this->code = 422;

        }

        return $this;
    }
}
