<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\CardRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateCardAPIRequest;

/**
 * Class CardController
 */

class CardAPIController extends AppBaseController
{
    private CardRepository $cardRepository;

    public function __construct(CardRepository $cardRepo)
    {
        $this->cardRepository = $cardRepo;
    }

    /**
     * @OA\Get(
     *      path="/cards",
     *      summary="getCardList",
     *      tags={"Card"},
     *      description="Get all Cards",
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
     *                  @OA\Items(ref="#/components/schemas/Card")
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
        $cards = $this->cardRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($cards->toArray(), 'Cards retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/cards",
     *      summary="createCard",
     *      tags={"Card"},
     *      description="Create Card",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Card")
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
     *                  ref="#/components/schemas/Card"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCardAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $card = $this->cardRepository->create($input);

        return $this->sendResponse($card->toArray(), 'Card saved successfully');
    }
}
