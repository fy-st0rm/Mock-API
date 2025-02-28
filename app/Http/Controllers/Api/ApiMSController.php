<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExecuteRequest;
use App\Models\ResponseFormat;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class ApiMSController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/apims/execute",
     *     summary="Executes the api",
     *     tags={"APIMS"},
     *     security={{ "bearer": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"function"},
     *             @OA\Property(
     *                 property="function",
     *                 type="string",
     *                 example="Name of function to execute",
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example={"key": "value"},
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Unauthenticated",
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="error",
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Validation failed.",
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={"function": "The function name must be a string"},
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Invalid function name",
     *             ),
     *         ),
     *     ),
     * )
     */
    public function execute(ExecuteRequest $request)
    {
        $function = $request->input("function");
        $data = $request->input("data");

        if (!method_exists($this, $function)) {
            return response()->json(["message" => "Invalid function name"], 500);
        }

        $responseFormat = ResponseFormat::where("function", $function)->first();
        if (!$responseFormat) {
            return response()->json(["message" => "Response format for $function not found."], 500);
        }

        return $this->$function($data, $responseFormat->response);
    }

    function AccountInquiry(array $data, string $responseFormat): JsonResponse
    {
        $responseFormat = str_replace('[[ACCT_SHORT_NAME]]', fake()->name(), $responseFormat);
        $responseFormat = str_replace('[[SOL_ID]]', fake()->numberBetween(1000, 9999), $responseFormat);
        $responseFormat = str_replace('[[ACCT_NAME]]', fake()->name(), $responseFormat);
        $responseFormat = str_replace('[[CUST_ID]]', fake()->randomNumber(9, true), $responseFormat);
        $responseFormat = str_replace('[[SCHM_CODE]]', fake()->word(), $responseFormat);
        $responseFormat = str_replace('[[GL_SUB_HEAD_CODE]]', fake()->word(), $responseFormat);
        $responseFormat = str_replace('[[ACCT_CLS_FLG]]', fake()->randomElement(['Y', 'N']), $responseFormat);
        $responseFormat = str_replace('[[ACCT_CRNCY_CODE]]', fake()->currencyCode(), $responseFormat);
        $responseFormat = str_replace('[[SCHM_TYPE]]', fake()->word(), $responseFormat);
        $responseFormat = str_replace('[[ACCT_OPN_DATE]]', fake()->dateTimeThisDecade()->format('d/m/Y H:i:s'), $responseFormat);
        $responseFormat = str_replace('[[ACCT_CLS_DATE]]', fake()->dateTimeThisDecade()->format('d/m/Y H:i:s'), $responseFormat);
        $responseFormat = str_replace('[[FREZ_CODE]]', fake()->randomLetter(), $responseFormat);
        $responseFormat = str_replace('[[FREZ_REASON_CODE]]', fake()->word(), $responseFormat);
        $responseFormat = str_replace('[[NRB_DEPOSIT_LOAN_DETAIL]]', fake()->randomLetter(), $responseFormat);
        $responseFormat = str_replace('[[NRB_DEPOSIT_DETAIL]]', fake()->randomLetter(), $responseFormat);
        $responseFormat = str_replace('[[ACCT_POA_AS_REC_TYPE]]', fake()->randomLetter(), $responseFormat);
        $responseFormat = str_replace('[[ACCT_POA_AS_NAME]]', fake()->name(), $responseFormat);

        $jsonData = json_decode($responseFormat);
        return response()->json($jsonData, 200);
    }
}
