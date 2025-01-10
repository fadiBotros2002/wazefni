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

    //application for the job
    public function submitApplication(Request $request, $post_id)
    {
        $request->validate([
            'cv' => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        ]);

        $user = Auth::user();
        // validate user if apply to the same job for the job previous
        $existingApplication = Application::where('post_id', $post_id)
            ->where('user_id', $user->user_id)
            ->first();

        if ($existingApplication) {
            return response()->json(['message' => 'You have already applied for this job'], 400);
        }
        //to get the latest test result
        $test = Test::where('user_id', $user->user_id)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->first();
        //if there are no test put the res ==0
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

            //send the notification by email if accepted the app
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
