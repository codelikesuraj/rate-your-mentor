<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResourceBasic;
use App\Http\Resources\CategoryResourceExtended;
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

        return CategoryResourceBasic::collection($categories);
    }

    public function show(int|string $category)
    {
        $category = Category::where('id', (int) $category)
            ->orwhere('slug', (string) $category)
            ->first();

        if ($category) {
            return new CategoryResourceExtended($category);
        }

        return response()->json(["message" => "not found"], 404);
    }
}
