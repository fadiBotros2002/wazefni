<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Answer;

class AnswerController extends Controller
{
    public function index()
    {
        $answers = Answer::all();
        return response()->json($answers);
    }

    public function show($id)
    {
        $answer = Answer::findOrFail($id);
        return response()->json($answer);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'test_id' => 'required|exists:tests,test_id',
            'question_id' => 'required|exists:questions,question_id',
            'audio' => 'required|file|mimes:mp3,wav|max:2048',
        ]);

        // store audio in path
        $path = $request->file('audio')->store('audio', 'public'); // path : public/audio

       // store audio in db
        $answer = Answer::create([
            'user_id' => $request->user_id,
            'test_id' => $request->test_id,
            'question_id' => $request->question_id,
            'audio_path' => $path,
        ]);

        return response()->json(['message' => 'File uploaded successfully', 'answer' => $answer], 201);
    }

    public function update(Request $request, $id)
    {
        $answer = Answer::findOrFail($id);
        $answer->update($request->all());

        return response()->json($answer);
    }

    public function destroy($id)
    {
        $answer = Answer::findOrFail($id);
        $answer->delete();

        return response()->json(['message' => 'Answer deleted successfully']);
    }
}
