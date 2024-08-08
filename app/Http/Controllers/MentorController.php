<?php

namespace App\Http\Controllers;

use App\Http\Resources\MentorResource;
use App\Models\Mentor;

class MentorController extends Controller
{
    public function index() {
        return MentorResource::collection(Mentor::get());
    }
    
    public function show($mentor) {
        if ($mentor = Mentor::find($mentor)) {
            return new MentorResource($mentor);
        }

        return response()->json(["message" => "not found"], 404);
    }
}
