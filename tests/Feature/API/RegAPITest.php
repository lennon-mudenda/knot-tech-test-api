<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Arr;

class RegAPITest extends TestCase
{
    /**
     * Test user registration
     */
    public function test_user_registration(): void
    {
        $details = Arr::only(User::factory()->definition(), ['email', 'name']);

        $validDetails = array_merge(
            $details,
            [
                'password' => 'password',
                'password_confirmation' => 'password',
            ]
        );

        $response = $this->post(
            $this->urlFromTemplate('/users/register'),
            $validDetails
        );

        $response->assertStatus(200);

        $response = $this->post(
            $this->urlFromTemplate('/users/register'),
            $details
        );

        $response->assertStatus(422);
    }
}
