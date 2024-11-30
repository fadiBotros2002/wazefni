<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EmployerController extends Controller
{

    //show all employer pending requests
    public function index()
    {
        $pendingEmployers = Employer::whereHas('users', function ($query) {
            $query->where('userstatus', 'pending');
        })->with('users')->get();

        Log::info('Fetched all pending employer requests.', ['pendingEmployers' => $pendingEmployers]);

        return response()->json(['pendingEmployers' => $pendingEmployers]);
    }


    //to uply request from user role into empployer role :
    public function apply(Request $request)
    {

        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_description' => 'required|string',
            'verification_documents' => 'nullable|file|mimes:jpg,jpeg,png,pdf,zip,rar|max:2048',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        //show if the user has applied previous request to upgrade
        $existingEmployer = Employer::where('user_id', $user->user_id)->first();
        if ($existingEmployer) {
            Log::warning('User has already applied to be an employer.', ['user_id' => $user->user_id]);
            return response()->json(['error' => 'You have already applied to be an employer and your request is pending.'], 400);
        }

        //
        Log::info('Authenticated user.', ['user_id' => $user->user_id, 'user' => $user]);

        $employer = new Employer();
        $employer->user_id = $user->user_id;
        $employer->company_name = $request->company_name;
        $employer->company_description = $request->company_description;
        //add verifiacation docs into db
        if ($request->hasFile('verification_documents')) {
            $filePath = $request->file('verification_documents')->store('verification_documents');
            $employer->verification_documents = $filePath;
            Log::info('Verification document uploaded.', ['file_path' => $filePath]);
        }

        try {
            $employer->save();
            Log::info('Employer saved successfully.', ['employer' => $employer]);
        } catch (\Exception $e) {
            Log::error('Error saving employer.', ['error' => $e->getMessage()]);
        }
        ///update user status to pending
        $user->update(['userstatus' => 'pending']);

        Log::info('User application submitted and pending approval.', ['user_id' => $user->user_id]);

        return response()->json(['message' => 'Your application has been submitted and is pending approval.']);
    }

    //for handle requests the users need to be employers ;;;reject or approve}
    public function handleRequest(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $employer = Employer::where('user_id', $user_id)->first();

        // action approve or rject
        $action = $request->input('action');

        if ($action === 'approve') {
            $user->update(['role' => 'employer']);
            $user->update(['userstatus' => 'active']);

            Log::info('User approved as an employer.', ['user_id' => $user_id]);
            return response()->json(['message' => 'User has been approved as an employer.']);
        } elseif ($action === 'reject') {
            //delete the verification docs
            if ($employer && $employer->verification_documents) {
                Storage::delete($employer->verification_documents);
            }

            //delete employer data fron db
            if ($employer) {
                $employer->delete();
            }
            // update user status and role
            $user->update(['role' => 'user']);
            $user->update(['userstatus' => 'active']);
            return response()->json(['message' => 'User has been rejected as an employer and the record has been deleted.']);
        } else {
            Log::warning('Invalid action provided.', ['action' => $action, 'user_id' => $user_id]);
            return response()->json(['error' => 'Invalid action.'], 400);
        }
    }
}
