<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class AccountInquiryValidator
{
    public static function rules(): array
    {
        return [
            "acctNo" => "required|string",
        ];
    }

    public static function errorMessages(): array
    {
        return [
            "acctNo.required" => "The acctNo field is required",
            "acctNo.string" => "The acctNo field must be a string",
        ];
    }

    public static function validate(array $data): MessageBag
    {
        $validator = Validator::make($data, self::rules(), self::errorMessages());
        return $validator->errors();
    }
}
