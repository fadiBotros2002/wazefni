<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;

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

/*
    public function getUserTestAnswers($userId)
    {
        // Fetch the test for the given user
        $test = Test::where('user_id', $userId)->first();

        // Check if the test exists for the user
        if (!$test) {
            return response()->json(['message' => 'No test found for this user'], 404);
        }

        // Fetch all answers related to the test
        $answers = Answer::where('test_id', $test->test_id)->get();
        $result = [];

        foreach ($answers as $answer) {
            // Generate public URL for audio file
            $audio_url = asset('storage/' . $answer->audio_path);

            // Fetch the question text based on question_id
            $question = Question::find($answer->question_id);

            $result[] = [
                'audio_url' => $audio_url,
                'question_id' => $answer->question_id,
                'question_text' => $question ? $question->question_text : null // Include question text
            ];
        }

        return response()->json(['test_id' => $test->test_id, 'results' => $result]);
    }
*/



public function getUserTestAnswers($userId)
{
    // Fetch the test for the given user
    $test = Test::where('user_id', $userId)->first();

    // Check if the test exists for the user
    if (!$test) {
        return response()->json(['message' => 'No test found for this user'], 404);
    }

    // Fetch all answers related to the test
    $answers = Answer::where('test_id', $test->test_id)->get();
    $result = [];

    foreach ($answers as $answer) {
        // Generate public URL for audio file
        $audio_url = asset($answer->audio_path);

        // Fetch the question text based on question_id
        $question = Question::find($answer->question_id);

        $result[] = [
            'audio_url' => $audio_url,
            'question_id' => $answer->question_id,
            'question_text' => $question ? $question->question_text : null // Include question text
        ];
    }

    return response()->json(['test_id' => $test->test_id, 'results' => $result]);
}

}
