<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CardSwitchTask;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CardSwitchTaskAPITest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_card_switch_task()
    {
        $cardSwitchTask = CardSwitchTask::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/card-switch-tasks', $cardSwitchTask
        );

        $this->assertApiResponse($cardSwitchTask);
    }

    /**
     * @test
     */
    public function test_mark_card_switch_task_as_failed()
    {
        $cardSwitchTask = CardSwitchTask::factory()->create();
        $editedCardSwitchTask = CardSwitchTask::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/card-switch-tasks/'.$cardSwitchTask->id,
            $editedCardSwitchTask
        );

        $this->assertApiResponse($editedCardSwitchTask);
    }

    /**
     * @test
     */
    public function test_mark_card_switch_task_as_finished()
    {
        $cardSwitchTask = CardSwitchTask::factory()->create();
        $editedCardSwitchTask = CardSwitchTask::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/card-switch-tasks/'.$cardSwitchTask->id,
            $editedCardSwitchTask
        );

        $this->assertApiResponse($editedCardSwitchTask);
    }
}
