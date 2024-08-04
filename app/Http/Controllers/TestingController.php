<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertItemNoteRequest;
use App\Models\Testing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestingController extends Controller
{
    public function test(Request $request)
    {
        return response()->json(["message" => "pong"], 200);
    }

    public function testMultiImage(Request $request)
    {
        $file = $request->file('image');
        return $file[0];
    }
}
