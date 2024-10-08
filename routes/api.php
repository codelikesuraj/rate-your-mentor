<?php

use App\Http\Controllers\ApiHealthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\VoteController;
use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\RecordVoterIP;
use Illuminate\Support\Facades\Route;
use Treblle\Middlewares\TreblleMiddleware;

Route::middleware([
    ForceJsonResponse::class,
    RecordVoterIP::class,
    TreblleMiddleware::class
])->group(function () {
    Route::get("health",  ApiHealthController::class);

    Route::get("categories", [CategoryController::class, "index"]);
    Route::get("categories/{category}", [CategoryController::class, "show"]);

    Route::get("mentors", [MentorController::class, "index"]);
    Route::get("mentors/{mentor}", [MentorController::class, "show"]);

    Route::post("votes", [VoteController::class, 
    "store"]);
    Route::get("votes", [VoteController::class,
    "index"]);
});