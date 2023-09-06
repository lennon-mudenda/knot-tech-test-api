<?php

namespace App\Http\Requests\API;

use App\Models\Card;
use InfyOm\Generator\Request\APIRequest;

class CreateCardAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return Card::$rules;
    }
}
