<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class ComplienceScreeningAPIValidator
{
    public static function rules(): array
    {
        return [
            "name" => "required|string",
        ];
    }

    public static function errorMessages(): array
    {
        return [
            "name.required" => "The name field is required",
            "name.string" => "The name field must be a string",
        ];
    }

    public static function validate(array $data): MessageBag
    {
        $validator = Validator::make($data, self::rules(), self::errorMessages());
        return $validator->errors();
    }
}
