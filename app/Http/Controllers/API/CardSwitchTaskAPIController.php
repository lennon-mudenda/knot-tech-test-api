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
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
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
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/CardSwitchTask")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
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
     *      )
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

    private function update($id, $input): JsonResponse
    {
        /** @var CardSwitchTask $cardSwitchTask */
        $cardSwitchTask = $this->cardSwitchTaskRepository->find($id);

        if (empty($cardSwitchTask)) {
            return $this->sendError('Card Switch Task not found');
        }

        $lastTask = $this->getPreviousCardSwitchTask($cardSwitchTask->merchant_id);

        $lastTask?->delete();

        $cardSwitchTask = $this->cardSwitchTaskRepository->update($input, $id);

        return $this->sendResponse($cardSwitchTask->toArray(), 'CardSwitchTask updated successfully');
    }

    /**
     * @OA\Put(
     *      path="/card-switch-tasks/{id}/markTaskFinished",
     *      summary="markTaskFinished",
     *      tags={"CardSwitchTask"},
     *      description="Update CardSwitchTask and Mark as Failed",
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
     *          description="successful operation",
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
     *      )
     * )
     */
    public function markTaskFinished($id): JsonResponse
    {
        $payload = [
            'status_id' => Status::where('uuid', Status::FINISHED_UUID)->first()->id,
            'status_uuid' => Status::FINISHED_UUID,
        ];

        return $this->update($id, $payload);
    }

    /**
     * @OA\Patch(
     *      path="/card-switch-tasks/{id}/markTaskFailed",
     *      summary="markTaskFailed",
     *      tags={"CardSwitchTask"},
     *      description="Update CardSwitchTask and Mark as Failed",
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
     *          description="successful operation",
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
     *      )
     * )
     */
    public function markTaskFailed($id): JsonResponse
    {
        $payload = [
            'status_id' => Status::where('uuid', Status::FAILED_UUID)->first()->id,
            'status_uuid' => Status::FAILED_UUID,
        ];

        return $this->update($id, $payload);
    }
}
