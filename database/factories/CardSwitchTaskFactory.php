<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\Status;
use App\Models\Merchant;
use Illuminate\Support\Str;
use App\Models\CardSwitchTask;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {

        $status = Status::where('uuid', Status::INITIATED_UUID)->first();

        $merchant = fake()->randomElement(Merchant::all());

        $card = Card::first();

        if (!$card) {
            $card = Card::factory()->create();
        }

        if (!$merchant) {
            $merchant = Merchant::factory()->create();
        }

        return [
            'uuid' => Str::uuid(),
            'card_uuid' => $card->uuid,
            'previous_card_uuid' => null,
            'merchant_uuid' => $merchant->uuid,
            'status_uuid' => $status->uuid,
            'user_uuid' => $card->user->uuid,
            'card_id' => $card->id,
            'previous_card_id' => null,
            'merchant_id' => $merchant->id,
            'status_id' => $status->id,
            'user_id' => $card->user->id,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
