<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Test;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function getAllQuestions()
    {
        $questions = Question::all();
        return response()->json($questions);
    }

    public function getQuestionsById($id)
    {
        $question = Question::findOrFail($id);
        return response()->json($question);
    }






    public function storeAnswers(Request $request)
    {
        // Check if answers are uploaded
        if (!$request->hasFile('answers')) {
            return response()->json(['message' => 'No answers uploaded'], 400);
        }

        // Check if there is an incomplete test for the user
        $test = Test::where('user_id', auth()->id())->where('status', 'incomplete')->first();
        if (!$test) {
            // Create a new test record if none exists
            $test = Test::create([
                'user_id' => auth()->id(),
                'status' => 'incomplete',
            ]);
        }


        // Loop through each answer file
        foreach ($request->file('answers') as $question_id => $audio_file) {
            $question = Question::find($question_id);
            if (!$question) {
                return response()->json(['message' => 'Question not found'], 404);
            }

            // Store the audio file
            $audio_path = $audio_file->store('audio_answers', 'public');

            // Create an answer record
            Answer::create([
                'user_id' => auth()->id(),
                'test_id' => $test->test_id,
                'question_id' => $question_id,
                'audio_path' => $audio_path,
            ]);
        }

        // Check if all answers for the test are received (optional logic)
        // Update test status if needed
        // $test->update(['status' => 'completed']);

        return response()->json(['message' => 'Answer submitted successfully!', 'test_id' => $test->test_id]);
    }






    // update results and state of test
    public function updateTestResult(Request $request, $user_id)
    {

        $test = Test::where('user_id', $user_id)->first();
        if (!$test) {
            return response()->json(['message' => 'No test found for this user'], 404);
        }

        // update result
        $test->result = $request->input('result');

        // update status
        $test->status = 'completed';

        $test->save();

        return response()->json(['message' => 'Test result updated successfully!', 'test' => $test]);
    }
}


