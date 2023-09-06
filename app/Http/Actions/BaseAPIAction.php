<?php

namespace App\Http\Actions;

use Illuminate\Http\JsonResponse;

abstract class BaseAPIAction
{
    /**
     * @var array $result
     */
    protected array $result = [
        'success' => true,
        'data' => [],
        'message' => '',
        'errors' => [],
    ];

    /**
     * @var int $code
     */
    protected int $code = 200;

    /**
     * Returns the response from executing the action
     *
     * @return JsonResponse
     */
    public function getResponse(): JsonResponse
    {
        return response()->json($this->result, $this->code);
    }
}
