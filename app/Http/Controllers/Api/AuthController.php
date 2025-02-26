<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
    * @OA\Post(
    *     path="/api/token/generate",
    *     summary="Generate JWT token",
    *     tags={"Authentication"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"email", "password"},
    *             @OA\Property(property="email", type="string", example="user@example.com"),
    *             @OA\Property(property="password", type="string", example="password123")
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="JWT Token Generated",
    *         @OA\JsonContent(
    *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1...")
    *         )
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="Unauthorized",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Invalid credentials")
    *         )
    *     )
    * )
    */
    public function generate(Request $request): JsonResponse {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(['token' => $token]);
    }
}
