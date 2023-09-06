<?php

namespace Database\Factories;

use App\Models\Merchant;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;


class MerchantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Merchant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {

        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->company(),
            'website' => $this->faker->url(),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
