<?php

use App\Http\Controllers\ApiHealthController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\RecordVoterIP;
use Illuminate\Support\Facades\Route;

Route::middleware([
    ForceJsonResponse::class,
    RecordVoterIP::class,
])->group(function () {
    Route::get("health",  ApiHealthController::class);

    Route::get("categories", [CategoryController::class, 'index']);
    Route::get("categories/{category}", [CategoryController::class, 'show']);
});