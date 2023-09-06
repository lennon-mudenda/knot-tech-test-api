<?php

namespace App\Http\Requests\API;

use DateTime;
use Exception;
use App\Models\Card;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
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
     * @throws Exception
     */
    public function rules(): array
    {
        $expiryDate = $this->getParsedExpiryDate();

        return [
            ...Card::$rules,
            'expiry' => [
                'required',
                'size:5',
                function ($attribute, $value, $fail) use ($expiryDate) {
                    if (!$expiryDate) {
                        $fail("Invalid {$attribute} date format. Correct format is m/y where m is the month and y is the last two digits of the year.");
                    }

                    if ($expiryDate < now()) {
                        $fail("Invalid {$attribute} date. Please enter a future date.");
                    }
                },
            ],
        ];
    }

    /**
     * @throws Exception
     */
    public function getParsedExpiryDate(): bool|DateTime
    {
        $date = DateTime::createFromFormat('m/y', $this->input('expiry'));

        if (!$date) {
            return false;
        }

        return new DateTime($date->format('Y-m-t'));
    }
}
