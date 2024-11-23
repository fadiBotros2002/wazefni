<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use Illuminate\Http\Request;

class CvController extends Controller
{

    public function index()
    {
        $cvs = Cv::with(['user', 'languages', 'experiences'])->get();
        return response()->json($cvs, 200);
    }

    public function show(Request $request, $id = null)
    {
        if ($id) {

            $cv = Cv::with(['user', 'languages', 'experiences'])->find($id);
            if (!$cv) {
                return response()->json(['error' => 'CV not found'], 404);
            }
        } else {
            $user_id = auth()->user()->user_id;
            $cv = Cv::where('user_id', $user_id)->with(['user', 'languages', 'experiences'])->first();
            if (!$cv) {
                return response()->json(['error' => 'CV not found'], 404);
            }
        }

        return response()->json($cv, 200);
    }

    public function store(Request $request)
    {
        $user_id = auth()->user()->user_id;

        // Check if the user already has a CV
        if (Cv::where('user_id', $user_id)->exists()) {
            return response()->json(['error' => 'User already has a CV'], 400);
        }

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:cvs,email',
            'phone_number' => 'required|string|max:15',
            'domain' => 'required|string|max:255',
            'education' => 'nullable|string',
            'skills' => 'nullable|string',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'portfolio' => 'nullable|string',
        ]);

        $validatedData['user_id'] = $user_id;
        $cv = Cv::create($validatedData);
        return response()->json($cv, 201);
    }

    public function update(Request $request, $id = null)
    {
        if ($id) {

            $cv = Cv::find($id);
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


        $validatedData = $request->validate([
            'user_id' => 'sometimes|exists:users,user_id',
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:cvs,email,' . $cv->cv_id . ',cv_id',
            'phone_number' => 'sometimes|string|max:15',
            'domain' => 'sometimes|string|max:255',
            'education' => 'nullable|string',
            'skills' => 'nullable|string',
            'city' => 'sometimes|string|max:255',
            'address' => 'sometimes|string',
            'portfolio' => 'nullable|string',
        ]);


        $cv->update($validatedData);
        return response()->json($cv, 200);
    }


    public function destroy($id)
    {
        $cv = Cv::find($id);
        if (!$cv) {
            return response()->json(['error' => 'CV not found'], 404);
        }
        $cv->delete();
        return response()->json(['message' => 'CV deleted successfully'], 200);
    }
}
