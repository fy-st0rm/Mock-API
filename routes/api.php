<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApiMSController;

Route::get("/", function() {
    return "Hello from the api";
});

Route::middleware(["auth:api"])->group(function() {
    Route::post("/apims/execute", [ApiMSController::class, "execute"]);
});


Route::post("/token/generate", [AuthController::class, "generate"]);
