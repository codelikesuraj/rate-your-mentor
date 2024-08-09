<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Mentor;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoteController extends Controller
{
    public function store(Request $request) {
        $validation = Validator::make($request->all(), [
            'category_id' => 'required|exists:'.(new Category())->getTable().',id',
            'mentor_id' => 'required|exists:'.(new Mentor())->getTable().',id',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'validation error',
                'errors' => $validation->errors(),
            ], 422);
        }

        $validated = $validation->validate();

        $vote = Vote::create([
            'voter_id' => getVoterFromRequest()->id,
            'category_id' => $validated['category_id'],
            'mentor_id' => $validated['mentor_id']
        ]);

        return response()->json([
            'message' => 'vote recorded successfully',
            'vote' => $vote,
        ], 201);
    }
}
