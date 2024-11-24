<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $cv = Cv::where('user_id', $user->user_id)->first();
        if (!$cv) {
            return response()->json(['error' => 'CV not found'], 404);
        }
        $languages = Language::where('cv_id', $cv->cv_id)->get();
        return response()->json($languages, 200);
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'language_name' => 'required|string|max:255',
            'proficiency_level' => 'required|in:Beginner,Intermediate,Advanced,Fluent',
        ]);

        $user = Auth::user();
        $cv = Cv::where('user_id', $user->user_id)->first();

        if (!$cv) {
            return response()->json(['error' => 'User does not have a CV.'], 404);
        }

        $validatedData['cv_id'] = $cv->cv_id;
        $language = Language::create($validatedData);
        return response()->json($language, 201);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $cv = Cv::where('user_id', $user->user_id)->first();
        if (!$cv) {
            return response()->json(['error' => 'User does not have a CV.'], 404);
        }
        $language = Language::where('cv_id', $cv->cv_id)->find($id);
        if (!$language) {
            return response()->json(['error' => 'Language not found'], 404);
        }
        $validatedData = $request->validate(
            [
                'language_name' => 'sometimes|string|max:255',
                'proficiency_level' => 'sometimes|in:Beginner,Intermediate,Advanced,Fluent',
            ]
        );
        $language->update($validatedData);
        return response()->json($language, 200);
    }



    public function destroy($id)
    {
        $user = Auth::user();
        $cv = Cv::where('user_id', $user->user_id)->first();
        if (!$cv) {
            return response()->json(['error' => 'CV not found'], 404);
        }
        $language = Language::where('cv_id', $cv->cv_id)->find($id);
        if (!$language) {
            return response()->json(['error' => 'Language not found'], 404);
        }
        $language->delete();
        return response()->json(['message' => 'language deleted successfully'], 200);
    }
}
