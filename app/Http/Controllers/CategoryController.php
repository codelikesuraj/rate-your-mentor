<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['votes' => function($query) {
            $query->select('category_id', 'mentor_id', DB::raw('count(*) as total_votes'))
                ->groupBy('category_id', 'mentor_id');
        }])->get();

        return CategoryResource::collection($categories);
    }

    public function show($category)
    {
        $category = Category::where('id', $category)
            ->orwhere('slug', $category)
            ->first();

        if ($category) {
            return new CategoryResource($category);
        }

        return response()->json(["message" => "not found"], 404);
    }
}
