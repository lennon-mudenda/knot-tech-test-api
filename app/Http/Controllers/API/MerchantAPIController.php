<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMerchantAPIRequest;
use App\Http\Requests\API\UpdateMerchantAPIRequest;
use App\Models\Merchant;
use App\Repositories\MerchantRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class MerchantController
 */

class MerchantAPIController extends AppBaseController
{
    private MerchantRepository $merchantRepository;

    public function __construct(MerchantRepository $merchantRepo)
    {
        $this->merchantRepository = $merchantRepo;
    }

    /**
     * @OA\Get(
     *      path="/merchants",
     *      summary="getMerchantList",
     *      tags={"Merchant"},
     *      description="Get all Merchants",
     *      security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Merchants retrieved successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Merchant")
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
        $merchants = $this->merchantRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($merchants->toArray(), 'Merchants retrieved successfully');
    }
}
