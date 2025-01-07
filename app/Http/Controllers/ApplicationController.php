<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\User;
use App\Models\Post;
use App\Models\Test;
use App\Mail\ApplicationAcceptedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ApplicationAccepted;
use Illuminate\Support\Facades\Notification;

class ApplicationController extends Controller
{


    public function submitApplication(Request $request, $post_id)
    {
        $request->validate([
            'cv' => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        ]);

        $user = Auth::user();

        // تحقق مما إذا كان المستخدم قد قدم طلبًا لنفس الوظيفة من قبل
        $existingApplication = Application::where('post_id', $post_id)
                                ->where('user_id', $user->user_id)
                                ->first();

        if ($existingApplication) {
            return response()->json(['message' => 'You have already applied for this job'], 400);
        }

        // حاول الحصول على نتيجة الاختبار المكتملة
        $test = Test::where('user_id', $user->user_id)
                    ->where('status', 'completed')
                    ->orderBy('created_at', 'desc')
                    ->first();

        // إذا لم يكن هناك اختبار مكتمل، اجعل نتيجة الاختبار صفر
        $testResult = $test ? $test->result : 0;

        $application = new Application();
        $application->post_id = $post_id;
        $application->user_id = $user->user_id;
        $application->cv = $request->file('cv') ? $request->file('cv')->store('cvs') : null;
        $application->test_result = $testResult;
        $application->application_date = now();
        $application->save();

        return response()->json(['message' => 'Application submitted successfully!'], 200);
    }




    public function getAllApplications()
    {
        $applications = Application::all();
        return response()->json($applications, 200);
    }

    public function deleteApplication($id)
    {
        $application = Application::find($id);
        if ($application) {
            $application->delete();
            return response()->json(['message' => 'Application deleted successfully!'], 200);
        } else {
            return response()->json(['message' => 'Application not found!'], 404);
        }
    }

    public function getApplication($id)
    {
        $application = Application::find($id);
        if ($application) {
            return response()->json($application, 200);
        } else {
            return response()->json(['message' => 'Application not found!'], 404);
        }
    }



    public function updateApplicationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected'
        ]);

        $application = Application::find($id);
        if ($application) {
            $application->status = $request->status;
            $application->save();

            // إرسال إشعار بريد إلكتروني عند قبول الطلب
            if ($request->status == 'accepted') {
                $user = User::find($application->user_id);
                Notification::send($user, new ApplicationAccepted($application));
            }

            return response()->json(['message' => 'Application status updated successfully!'], 200);
        } else {
            return response()->json(['message' => 'Application not found!'], 404);
        }
    }

}
