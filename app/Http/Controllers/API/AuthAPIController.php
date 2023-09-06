<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\API\LoginRequest;
use App\Http\Actions\AuthAPI\UserAction;
use App\Http\Actions\AuthAPI\LoginAction;
use App\Http\Actions\AuthAPI\LogoutAction;
use App\Http\Controllers\AppBaseController;
use App\Http\Actions\AuthAPI\RefreshAction;

class AuthAPIController extends AppBaseController
{
    /**
     * @OA\Post(
     *      path="/users/auth/login",
     *      summary="loginUser",
     *      tags={"Auth"},
     *      description="Login user on API and receive token for subsequent requests.",
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
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
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
     *          description="Invalid Input"
     *     )
     * )
     */
    public function login(LoginAction $loginAction, LoginRequest $request): JsonResponse
    {
        return $loginAction->execute($request)
            ->getResponse();
    }

    /**
     * @OA\Get(
     *      path="/users/auth/logout",
     *      summary="logoutUser",
     *      tags={"Auth"},
     *      description="Logs out authenticated user.",
     *        security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="errors",
     *                  type="array",
     *                  @OA\Items(type="string")
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/ApiUser")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Not Authorized"
     *     )
     * )
     */
    public function logout(LogoutAction $logoutAction): JsonResponse
    {
        return $logoutAction->execute()
            ->getResponse();
    }

    /**
     * @OA\Get(
     *      path="/users/auth/refresh",
     *      summary="refreshUserToken",
     *      tags={"Auth"},
     *      description="Refreshes the authenticated user's token",
     *        security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="errors",
     *                  type="array",
     *                  @OA\Items(type="string")
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/ApiUser")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Not Authorized"
     *     )
     * )
     */
    public function refresh(RefreshAction $refreshAction): JsonResponse
    {
        return $refreshAction->execute()
            ->getResponse();
    }

    /**
     * @OA\Get(
     *      path="/users/auth/user",
     *      summary="loggedInUser",
     *      tags={"Auth"},
     *      description="Get data on the currently logged in user.",
     *        security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="errors",
     *                  type="array",
     *                  @OA\Items(type="string")
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/ApiUser")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Not Authorized"
     *     )
     * )
     */
    public function user(UserAction $userAction): JsonResponse
    {
        return $userAction->execute()
            ->getResponse();
    }
}
