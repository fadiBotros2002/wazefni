<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{

    public function index(Request $request, $id = null)
    {
        if ($id) {

            $cv = Cv::with(['user', 'languages', 'experiences'])->find($id);
            if (!$cv) {
                return response()->json(['error' => 'CV not found'], 404);
            }
        } else {

            $user_id = auth()->user()->user_id;
            $cv = Cv::where('user_id', $user_id)->first();
            if (!$cv) {
                return response()->json(['error' => 'CV not found'], 404);
            }
        }


        $experiences = Experience::where('cv_id', $cv->cv_id)->get();
        return response()->json($experiences, 200);
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'domain' => 'required|string|max:255',
            'job_description' => 'required|string',
            'start_date' => 'date',
            'end_date' => 'date',
        ]);

        $user = Auth::user();
        $cv = Cv::where('user_id', $user->user_id)->first();

        if (!$cv) {
            return response()->json(['error' => 'User does not have a CV.'], 404);
        }

        $validatedData['cv_id'] = $cv->cv_id;
        $experience = Experience::create($validatedData);

        return response()->json($experience, 201);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $cv = Cv::where('user_id', $user->user_id)->first();

        if (!$cv) {
            return response()->json(['error' => 'User does not have a CV.'], 404);
        }

        $experience = Experience::where('cv_id', $cv->cv_id)->find($id);

        if (!$experience) {
            return response()->json(['error' => 'Experience not found'], 404);
        }

        $validatedData = $request->validate([
            'company_name' => 'sometimes|string|max:255',
            'domain' => 'sometimes|string|max:255',
            'job_description' => 'sometimes|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date',
        ]);

        $experience->update($validatedData);

        return response()->json($experience, 200);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $cv = Cv::where('user_id', $user->user_id)->first();

        if (!$cv) {
            return response()->json(['error' => 'CV not found'], 404);
        }

        $experience = Experience::where('cv_id', $cv->cv_id)->find($id);

        if (!$experience) {
            return response()->json(['error' => 'Experience not found'], 404);
        }

        $experience->delete();

        return response()->json(['message' => 'Experience deleted successfully'], 200);
    }
}
