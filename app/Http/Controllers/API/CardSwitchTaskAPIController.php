<?php

namespace App\Http\Controllers\API;

use App\Models\Status;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CardSwitchTask;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CardSwitchTaskRepository;
use App\Http\Requests\API\CreateCardSwitchTaskAPIRequest;

/**
 * Class CardSwitchTaskController
 */

class CardSwitchTaskAPIController extends AppBaseController
{
    private CardSwitchTaskRepository $cardSwitchTaskRepository;

    public function __construct(CardSwitchTaskRepository $cardSwitchTaskRepo)
    {
        $this->cardSwitchTaskRepository = $cardSwitchTaskRepo;
    }

    /**
     * @OA\Get(
     *      path="/card-switch-tasks",
     *      summary="getCardSwitchTaskList",
     *      tags={"CardSwitchTask"},
     *      description="Get all CardSwitchTasks",
     *      security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Card Switch Tasks retrieved successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/CardSwitchTask")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $cardSwitchTasks = $this->cardSwitchTaskRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($cardSwitchTasks->toArray(), 'Card Switch Tasks retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/card-switch-tasks",
     *      summary="createCardSwitchTask",
     *      tags={"CardSwitchTask"},
     *      description="Create CardSwitchTask",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/CardSwitchTask")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Card Switch Task saved successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/CardSwitchTask"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Invalid Task Creation Data",
     *     )
     * )
     */
    public function store(CreateCardSwitchTaskAPIRequest $request): JsonResponse
    {
        $lastTask = $this->getPreviousCardSwitchTask($request->input('merchant_id'));
        $input = array_merge(
            $request->only(['card_id', 'merchant_id']),
            [
                'uuid' => Str::uuid(),
                'user_id' => auth()->user()->getAuthIdentifier(),
                'status_id' => Status::where('uuid', Status::INITIATED_UUID)->first()->id,
                'status_uuid' => Status::INITIATED_UUID,
                'previous_card_id' => $lastTask?->id,
            ]
        );

        $cardSwitchTask = $this->cardSwitchTaskRepository->create($input);

        return $this->sendResponse($cardSwitchTask->toArray(), 'Card Switch Task saved successfully');
    }

    private function getPreviousCardSwitchTask($merchantId): ?CardSwitchTask
    {
        return CardSwitchTask::where(function ($query) use ($merchantId) {
            $query->where('merchant_id', $merchantId);
            $query->where('user_id', auth()->user()->getAuthIdentifier());
            $query->where('status_uuid', Status::FINISHED_UUID);
        })->first();
    }

    private function update($id, $input, $successMessage = 'CardSwitchTask updated successfully'): JsonResponse
    {
        /** @var CardSwitchTask $cardSwitchTask */
        $cardSwitchTask = $this->cardSwitchTaskRepository->find($id);

        if (empty($cardSwitchTask)) {
            return $this->sendError('Card Switch Task not found', 404);
        }

        if ($cardSwitchTask->user_id != auth()->user()->getAuthIdentifier()) {
            return $this->sendError('You can only update tasks you created', 401);
        }

        if ($cardSwitchTask->status_uuid != Status::INITIATED_UUID) {
            return $this->sendError('Task already at end state. Cannot be marked failed/finished.', 422);
        }

        $lastTask = $this->getPreviousCardSwitchTask($cardSwitchTask->merchant_id);

        if ($input['status_uuid'] == Status::FINISHED_UUID) {
            $lastTask?->delete();
        }

        $cardSwitchTask = $this->cardSwitchTaskRepository->update($input, $id);

        $cardSwitchTask->with('status');

        return $this->sendResponse($cardSwitchTask->toArray(), $successMessage);
    }

    /**
     * @OA\Patch(
     *      path="/card-switch-tasks/{id}/mark-finished",
     *      summary="markTaskFinished",
     *      tags={"CardSwitchTask"},
     *      description="Update CardSwitchTask and Mark as Failed",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of CardSwitchTask",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=false
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Task Marked as Finished Successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/CardSwitchTask"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *          response=404,
     *          description="Card Switch Task Not Found",
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Invalid Persmissions to update Card Switch Task",
     *     )
     * )
     */
    public function markFinished($id): JsonResponse
    {
        $payload = [
            'status_id' => Status::where('uuid', Status::FINISHED_UUID)->first()->id,
            'status_uuid' => Status::FINISHED_UUID,
        ];

        return $this->update($id, $payload, 'Task Marked as Finished Successfully');
    }

    /**
     * @OA\Patch(
     *      path="/card-switch-tasks/{id}/mark-failed",
     *      summary="markTaskFailed",
     *      tags={"CardSwitchTask"},
     *      description="Update CardSwitchTask and Mark as Failed",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of CardSwitchTask",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=false
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Task Marked as Failed Successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/CardSwitchTask"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *          response=404,
     *          description="Card Switch Task Not Found",
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Invalid Persmissions to update Card Switch Task",
     *     )
     * )
     */
    public function markFailed($id): JsonResponse
    {
        $payload = [
            'status_id' => Status::where('uuid', Status::FAILED_UUID)->first()->id,
            'status_uuid' => Status::FAILED_UUID,
        ];

        return $this->update($id, $payload, 'Task Marked as Failed Successfully');
    }
}
