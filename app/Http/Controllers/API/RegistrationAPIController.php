<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Actions\RegAPI\RegisterAction;

class RegistrationAPIController extends Controller
{
    /**
     * @OA\Post(
     *      path="/users/register",
     *      summary="registerUser",
     *      tags={"Users"},
     *      description="Register User",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="email",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="password_confirmation",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="name",
     *                  type="string"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User Registered Successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="errors",
     *                  type="array",
     *                  @OA\Items(type="string")
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/ApiUser"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Invalid Registration Data"
     *     )
     * )
     */
    public function register(RegisterRequest $request, RegisterAction $registerAction): JsonResponse
    {
        return $registerAction->execute($request)
            ->getResponse();
    }
}
