<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class AccountInquiryValidator
{
    public static function rules(): array
    {
        return [
            "acctNo" => "required_without:accountNo|string",
            "accountNo" => "required_without:acctNo|string",
        ];
    }

    public static function errorMessages(): array
    {
        return [
            "acctNo.required_without" => "The acctNo field is required if accountNo is not present",
            "accountNo.required_without" => "The accountNo field is required if acctNo is not present",
            "acctNo.string" => "The acctNo field must be a string",
            "accountNo.string" => "The accountNo field must be a string",
        ];
    }

    public static function validate(array $data): MessageBag
    {
        $validator = Validator::make($data, self::rules(), self::errorMessages());
        return $validator->errors();
    }
}
