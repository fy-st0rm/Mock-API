<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

Route::get("/", function() {
    return "Hello from the api";
});

Route::middleware(["auth:api"])->group(function() {
    Route::get("/users/", [UserController::class, "index"]);
});

Route::post("/token/generate", [AuthController::class, "generate"]);
Route::get("login", function() { return "Unauthorizied"; })->name("login");
