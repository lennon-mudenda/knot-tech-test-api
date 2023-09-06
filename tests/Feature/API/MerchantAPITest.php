<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Merchant;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MerchantAPITest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_read_merchant()
    {
        $this->response = $this->json(
            'GET',
            '/api/v1/merchants'
        );

        $this->assertApiSuccess();
    }
}
