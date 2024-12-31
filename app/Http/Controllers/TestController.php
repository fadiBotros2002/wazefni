<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::all();
        return response()->json($tests);
    }

    public function show($id)
    {
        $test = Test::findOrFail($id);
        return response()->json($test);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'result' => 'nullable|numeric',
            'status' => 'required|in:incomplete,completed,failed',
        ]);

        $test = Test::create($request->all());
        return response()->json($test, 201);
    }

    public function update(Request $request, $id)
    {
        $test = Test::findOrFail($id);
        $test->update($request->all());

        return response()->json($test);
    }

    public function destroy($id)
    {
        $test = Test::findOrFail($id);
        $test->delete();

        return response()->json(['message' => 'Test deleted successfully']);
    }
}
