<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;

/**
 * @OA\Info(title="User Api", version="1.0")
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get all users",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="ID of the user",
     *         required=false,
     *         @OA\Schema(type="integer", example=1),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="User not found"
     *             )
     *         )
     *     ),
     * )
     */
    public function index(Request $request): JsonResponse {
        if ($request->has('id')) {
            $users = User::where('id', $request->query('id'))->get();
            if (!$users) {
                return response()->json([
                    "error" => "User not found"
                ], 404);
            }
        } else {
            $users = User::all();
        }
        return response()->json($users);
    }
}
