<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class CorpCustInqValidator
{
    public static function rules(): array
    {
        return [
            "cust_id" => "required|string",
        ];
    }

    public static function errorMessages(): array
    {
        return [
            "cust_id.required" => "The cust_id field is required",
            "cust_id.string" => "The cust_id field must be a string",
        ];
    }

    public static function validate(array $data): MessageBag
    {
        $validator = Validator::make($data, self::rules(), self::errorMessages());
        return $validator->errors();
    }
}
