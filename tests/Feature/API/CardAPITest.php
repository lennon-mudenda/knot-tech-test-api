<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\Card;
use Tests\ApiTestTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CardAPITest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_card()
    {
        $card = Card::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/cards',
            $card
        );

        $this->assertApiResponse($card);
    }

}
