<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiHealthController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return response()->json(['message' => 'everything ok']);
    
    }
}
