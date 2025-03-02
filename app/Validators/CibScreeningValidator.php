<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class CibScreeningValidator
{
    public static function rules(): array
    {
        return [
            "name" => "required|string",
            "PanNumber" => "required_without:citizenship|string",
            "citizenship" => "required_without:PanNumber|string",
        ];
    }

    public static function errorMessages(): array
    {
        return [
            "name.required" => "The name field is required",
            "name.string" => "The name field must be a string",
            "PanNumber.required_without" => "The PanNumber is required if citizenship is not provided.",
            "PanNumber.string" => "The PanNumber field must be a string",
            "citizenship.required_without" => "The citizenship is required if PAN number is not provided.",
            "citizenship.string" => "The citizenship field must be a string",
        ];
    }

    public static function validate(array $data): MessageBag
    {
        $validator = Validator::make($data, self::rules(), self::errorMessages());
        return $validator->errors();
    }
}
