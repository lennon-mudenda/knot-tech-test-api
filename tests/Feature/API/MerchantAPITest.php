<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Tests\ApiTestTrait;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MerchantAPITest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * Test Get All Merchants Endpoint Scenario.
     */
    public function test_read_all_merchants()
    {
        $this->response = $this->asUser()->getJson(
            $this->urlFromTemplate('/merchants')
        );

        $this->assertApiSuccess();
    }
}
