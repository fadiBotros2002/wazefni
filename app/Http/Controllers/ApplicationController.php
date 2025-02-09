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
use App\Notifications\ApplicationRejected;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{

    public function submitApplication(Request $request, $post_id)
    {
        $user = Auth::user();
        // Check if the user has already applied for the same job
        $existingApplication = Application::where('post_id', $post_id)
            ->where('user_id', $user->user_id)
            ->first();

        if ($existingApplication) {
            return response()->json(['message' => 'You have already applied for this job'], 400);
        }
        // Get the latest test result for the user
        $test = Test::where('user_id', $user->user_id)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->first();

        $testResult = $test ? $test->result : 0;

        // Retrieve the user's CV from the database
        $cv = DB::table('cvs')
            ->where('user_id', $user->user_id)
            ->value('pdf');

        $application = new Application();
        $application->post_id = $post_id;
        $application->user_id = $user->user_id;
        $application->cv = $cv; // Even if this is null, the application will still be submitted
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

            // send the notification by email if the application is accepted
            if ($request->status == 'accepted') {
                $user = User::find($application->user_id);
                Notification::send($user, new ApplicationAccepted($application));
            }

            // send the notification by email if the application is rejected
            if ($request->status == 'rejected') {
                $user = User::find($application->user_id);
                Notification::send($user, new ApplicationRejected($application));
            }

            return response()->json(['message' => 'Application status updated successfully!'], 200);
        } else {
            return response()->json(['message' => 'Application not found!'], 404);
        }
    }


    public function getAllApplicationsByEmployer()
    {
        // Get the currently authenticated user
        $employer = Auth::user();

        // Retrieve all applications for all posts by the authenticated employer
        $applications = [];
        foreach ($employer->posts as $post) {
            $postApplications = $post->applications;
            $applications = array_merge($applications, $postApplications->toArray());
        }

        return response()->json(['applications' => $applications], 200);
    }


//to get all applications of post
    public function getApplicationsByPostId($post_id)
    {
        $applications = Application::where('post_id', $post_id)->get();
        $jobDescription = Post::where('post_id', $post_id)->value('description');

        return response()->json(['applications' => $applications, 'job_description' => $jobDescription]);
    }


}
