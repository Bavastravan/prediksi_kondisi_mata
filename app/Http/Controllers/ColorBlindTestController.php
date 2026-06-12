<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ColorBlindTest;

class ColorBlindTestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'score'          => 'required|integer|min:0|max:5',
            'status'         => 'required|string|max:255',
            'recommendation' => 'required|string',
            'confidence'     => 'required|integer|min:0|max:100',
        ]);

        ColorBlindTest::create([
            'user_id'        => auth()->id(),
            'score'          => $request->score,
            'status'         => $request->status,
            'recommendation' => $request->recommendation,
            'confidence'     => $request->confidence,
        ]);

        return response()->json(['status' => 'success']);
    }
}