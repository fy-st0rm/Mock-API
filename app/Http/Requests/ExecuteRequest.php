<?php

namespace App\Http\Requests;

use App\Validators\AccountInquiryValidator;

use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as ValidationContract;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ExecuteRequest extends FormRequest
{
    protected $functionValidators= [
        "AccountInquiry" => AccountInquiryValidator::class,
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "function" => "required|string",
            "data" => "required|array",
        ];
    }

    public function messages(): array
    {
        return [
            "function.required" => "The function name is required",
            "function.string" => "The function name must be a string",
            "data.required" => "Data for the function is required",
            "data.array" => "Data must be a JSON object",
        ];
    }

    public function getValidatedData(): array
    {
        return $this->input("data");
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $function = $this->input('function');
            $data = $this->input('data');

            $funcValidator = $this->functionValidators[$function] ?? null;

            if (!$funcValidator) {
                $validator->errors()->add('function', "Validator for specified $function is not available.");
                return;
            }

            $errors = $funcValidator::validate($data);

            if ($errors->isNotEmpty()) {
                foreach ($errors->all() as $error) {
                    $validator->errors()->add('data', $error);
                }
            }
        });
    }

    protected function failedValidation(ValidationContract $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
