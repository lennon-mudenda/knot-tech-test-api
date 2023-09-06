<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\Card;
use Tests\ApiTestTrait;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CardAPITest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * Test Credit Card Creation Scenarios.
     */
    public function test_create_card()
    {
        $cardDetails = Arr::only(
            Card::factory()->definition(),
            ['number', 'cvv', 'expiry']
        );

        $this->response = $this->asUser()->postJson(
            $this->urlFromTemplate('/cards'),
            $cardDetails
        );

        $this->response->assertStatus(200);

        $invalidCard = Arr::except($cardDetails, ['number']);

        $this->response = $this->asUser()->postJson(
            $this->urlFromTemplate('/cards'),
            $invalidCard
        );

        $this->response->assertStatus(422);
    }

}
