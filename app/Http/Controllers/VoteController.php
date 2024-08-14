<?php

namespace App\Http\Controllers;

use App\Http\Resources\VoteResource;
use App\Models\Category;
use App\Models\Mentor;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VoteController extends Controller
{
    public function index(Request $request) {
        $voter = getVoterFromRequest();

        return response()->json(VoteResource::collection(Vote::where('voter_id', $voter->id)->get()), 200);
    }

    public function store(Request $request) {
        $validation = Validator::make($request->all(), [
            'category_id' => [
                'required',
                Rule::exists((new Category())->getTable(), 'id')
            ],
            'mentor_id' => [
                'required',
                Rule::exists((new Mentor())->getTable(), 'id'),
                Rule::unique((new Vote())->getTable())->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->category_id)
                        ->where('mentor_id', $request->mentor_id)
                        ->where('voter_id', getVoterFromRequest()->id);
                })
            ]
        ], [
            'unique' => 'mentor already selected for this category',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'validation error',
                'errors' => $validation->errors(),
            ], 422);
        }

        $validated = $validation->validated();

        Vote::create([
            'voter_id' => getVoterFromRequest()->id,
            'category_id' => $validated['category_id'],
            'mentor_id' => $validated['mentor_id']
        ]);

        return response()->json([
            'message' => 'vote recorded successfully',
            // 'vote' => $vote,
        ], 201);
    }
}
