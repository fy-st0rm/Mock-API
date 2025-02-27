<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExecuteRequest;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * )
     */
    public function execute(ExecuteRequest $request)
    {
        $function = $request->input("function");
        $data = $request->input("data");

        if (method_exists($this, $function)) {
           return $this->$function();
        }
        return "wrong function name";
    }

    public function test() {
        return "From test function";
    }
}
