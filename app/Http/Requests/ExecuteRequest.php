<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ExecuteRequest extends FormRequest
{
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

    protected function failedValidation(Validator $validator)
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
