<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class SignatureInqValidator
{
    public static function rules(): array
    {
        return [
            "accountNo" => "required|string",
        ];
    }

    public static function errorMessages(): array
    {
        return [
            "accountNo.required" => "The accountNo field is required",
            "accountNo.string" => "The accountNo field must be a string",
        ];
    }

    public static function validate(array $data): MessageBag
    {
        $validator = Validator::make($data, self::rules(), self::errorMessages());
        return $validator->errors();
    }
}
