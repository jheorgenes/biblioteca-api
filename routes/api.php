<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return response()->json([
        'status' => 'ok'
    ]);
});

Route::apiResource('users', UserController::class);
Route::apiResource('genres', GenreController::class);
Route::apiResource('books', BookController::class);
Route::apiResource('loans', LoanController::class);
Route::put('loans/{id}/status', [LoanController::class, 'updateStatus']);

