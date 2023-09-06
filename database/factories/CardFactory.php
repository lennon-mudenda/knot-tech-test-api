<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;


class CardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Card::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $user = User::first();

        if (!$user) {
            $user = User::factory()->create();
        }

        return [
            'uuid' => Str::uuid(),
            'user_uuid' => $user->uuid,
            'user_id' => $user->id,
            'number' => $this->faker->creditCardNumber,
            'cvv' => (string) $this->faker->numberBetween(100, 999),
            'expiry' => $this->faker->creditCardExpirationDate(true)->format('m/y'),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
