<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::get('/', function() {
    return "Hello from the api";
});

Route::get('/users/', [UserController::class, 'index']);
