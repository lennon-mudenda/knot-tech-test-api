<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Arr;

class AuthAPITest extends TestCase
{
    /**
     * Test user Authentication scenarios.
     */
    public function test_user_login(): void
    {
        $user = User::factory()->create();

        $validCredentials = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->postJson(
            $this->urlFromTemplate('/users/auth/login'),
            $validCredentials
        );

        $response->assertStatus(200);

        $invalidCredentials = Arr::only($validCredentials, 'email');

        $response = $this->postJson(
            $this->urlFromTemplate('/users/auth/login'),
            $invalidCredentials
        );

        $response->assertStatus(422);

        $invalidCredentials['password'] = 'ClearlyWrongPassword';

        $response = $this->postJson(
            $this->urlFromTemplate('/users/auth/login'),
            $invalidCredentials
        );

        $response->assertStatus(401);
    }
}
