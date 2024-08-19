<?php

namespace App\Http\Controllers;

use App\Http\Resources\MentorResourceBasic;
use App\Http\Resources\MentorResourceExtended;
use App\Models\Mentor;

class MentorController extends Controller
{
    public function index() {
        return MentorResourceBasic::collection(Mentor::latest()->get());
    }
    
    public function show($mentor) {
        if ($mentor = Mentor::find($mentor)) {
            return new MentorResourceExtended($mentor);
        }

        return response()->json(["message" => "not found"], 404);
    }
}
