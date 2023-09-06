<?php

namespace Database\Factories;

use App\Models\CardSwitchTask;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Card;
use App\Models\Merchant;
use App\Models\Card;
use App\Models\Status;
use App\Models\User;

class CardSwitchTaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CardSwitchTask::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create();
        }

        return [
            'uuid' => $this->faker->text($this->faker->numberBetween(5, 36)),
            'card_uuid' => $this->faker->text($this->faker->numberBetween(5, 36)),
            'previous_card_uuid' => $this->faker->text($this->faker->numberBetween(5, 36)),
            'merchant_uuid' => $this->faker->text($this->faker->numberBetween(5, 36)),
            'status_uuid' => $this->faker->text($this->faker->numberBetween(5, 36)),
            'user_uuid' => $this->faker->text($this->faker->numberBetween(5, 36)),
            'card_id' => $this->faker->word,
            'previous_card_id' => $this->faker->word,
            'merchant_id' => $this->faker->word,
            'status_id' => $this->faker->word,
            'user_id' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
