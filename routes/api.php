<?php

use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\RecordVoterIP;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::middleware([
    ForceJsonResponse::class,
    RecordVoterIP::class,
])->group(function () {
    Route::get("health", function () {
        return response()->json(['message' => 'everything ok']);
    });

    Route::prefix("categories")->group(function () {
        Route::get("/", function () {
            $categories = Category::with(['votes' => function($query) {
                $query->select('category_id', 'mentor_id', DB::raw('count(*) as total_votes'))
                    ->groupBy('category_id', 'mentor_id');
            }])->get();

            return CategoryResource::collection($categories);
        });
        Route::get("/{category}", function ($category) {
            $category = Category::where('id', $category)
                ->orwhere('slug', $category)
                ->first();

            if ($category) {
                return new CategoryResource($category);
            }

            return response()->json(["message" => "not found"], 404);
        });
    });
});