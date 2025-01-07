<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $validatedData = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:cvs,email',
            'phone_number' => 'nullable|string|max:15',
            'domain' => 'nullable|string|max:255',
            'education' => 'nullable|string',
            'skills' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'portfolio' => 'nullable|string',
            'pdf' => 'nullable|mimes:pdf|max:2048', // Validate PDF
        ]);

        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('pdfs', $filename, 'public');
            $validatedData['pdf'] = $filePath;
        }

        // تحقق من وجود CV للمستخدم
        $cv = Cv::where('user_id', $user_id)->first();

        if ($cv) {
            // تحديث CV الحالي
            $cv->update($validatedData);
            return response()->json($cv, 200);
        } else {
            // إنشاء CV جديد
            $validatedData['user_id'] = $user_id;
            $cv = Cv::create($validatedData);
            return response()->json($cv, 201);
        }
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
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:cvs,email,' . $cv->cv_id . ',cv_id',
            'phone_number' => 'nullable|string|max:15',
            'domain' => 'nullable|string|max:255',
            'education' => 'nullable|string',
            'skills' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'portfolio' => 'nullable|string',
            'pdf' => 'nullable|mimes:pdf|max:2048', // Validate PDF
        ]);

        if ($request->hasFile('pdf')) {
            // Delete old PDF if exists
            if ($cv->pdf) {
                Storage::disk('public')->delete($cv->pdf);
            }

            $file = $request->file('pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('pdfs', $filename, 'public');
            $validatedData['pdf'] = $filePath;
        }

        $cv->update($validatedData);
        return response()->json($cv, 200);
    }

    public function destroy($id)
    {
        $cv = Cv::find($id);
        if (!$cv) {
            return response()->json(['error' => 'CV not found'], 404);
        }

        // Delete PDF if exists
        if ($cv->pdf) {
            Storage::disk('public')->delete($cv->pdf);
        }

        $cv->delete();
        return response()->json(['message' => 'CV deleted successfully'], 200);
    }

    public function getUserPdf()
    {
        $user_id = auth()->user()->user_id;
        $cv = Cv::where('user_id', $user_id)->first();
        if (!$cv || !$cv->pdf) {
            return response()->json(['error' => 'PDF not found'], 404);
        }
        $pdfPath = Storage::disk('public')->path($cv->pdf);
        return response()->download($pdfPath);
    }
}
