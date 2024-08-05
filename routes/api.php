<?php

use App\Http\Middleware\ForceJsonResponse;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::middleware([ForceJsonResponse::class])->group(function () {
    Route::get("/categories", function () {
        // $categories = Category::with(['votes' => function($query) {
        //     $query->select('category_id', 'mentor_id', DB::raw('count(*) as total_votes'))
        //           ->groupBy('category_id', 'mentor_id');
        // }])->get();
        // return CategoryResource::collection($categories);
        return CategoryResource::collection(Category::get());  
    });
    Route::get("/categories/{id}", function ($id) {
        $category = Category::find((int) $id);
        if ($category) {
            return new CategoryResource($category);
        }

        return response()->json(["message" => "not found"], 404);
    });
});