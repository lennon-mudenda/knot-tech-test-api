<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\Status;
use Tests\ApiTestTrait;
use Illuminate\Support\Arr;
use App\Models\CardSwitchTask;

class CardSwitchTaskAPITest extends TestCase
{
    use ApiTestTrait;

    protected function setUp(): void
    {
        parent::setUp();

        CardSwitchTask::factory()->create();
    }

    /**
     * Test Get All Card Switch Task Creation Scenarios.
     */
    public function test_get_all_card_switch_task()
    {
        $this->response = $this->asUser()->getJson(
            $this->urlFromTemplate('/card-switch-tasks')
        );

        $this->response->assertStatus(200);
    }


    /**
     * Test Card Switch Task Creation Scenarios.
     */
    public function test_create_card_switch_task()
    {
        $cardSwitchTaskDetails = Arr::only(
            CardSwitchTask::factory()->definition(),
            ['card_id', 'merchant_id']
        );

        $this->response = $this->asUser()->postJson(
            $this->urlFromTemplate('/card-switch-tasks'),
            $cardSwitchTaskDetails
        );

        $this->response->assertStatus(200);
    }

    /**
     * Test Mark Card Switch Task As Failed Scenarios.
     */
    public function test_mark_card_switch_task_as_failed()
    {
        $cardSwitchTask = CardSwitchTask::where('status_uuid', Status::INITIATED_UUID)->first();

        if (!$cardSwitchTask) {
            $cardSwitchTask = CardSwitchTask::factory()->create();
        }

        $this->response = $this->asUser()->patchJson(
            $this->urlFromTemplate('/card-switch-tasks/{id}/mark-failed', ['id' => $cardSwitchTask->id])
        );

        $this->response->assertStatus(200);
    }

    /**
     * Test Mark Card Switch Task As Failed Scenarios.
     */
    public function test_mark_card_switch_task_as_finished()
    {
        $cardSwitchTask = CardSwitchTask::where('status_uuid', Status::INITIATED_UUID)->first();

        if (!$cardSwitchTask) {
            $cardSwitchTask = CardSwitchTask::factory()->create();
        }

        $this->response = $this->asUser()->patchJson(
            $this->urlFromTemplate('/card-switch-tasks/{id}/mark-finished', ['id' => $cardSwitchTask->id])
        );

        $this->response->assertStatus(200);
    }
}
