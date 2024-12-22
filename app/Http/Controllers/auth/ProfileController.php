<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;

class ProfileController extends Controller
{
    public function updateUserInfo(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();

        if (isset($input['name'])) {
            $request->validate(['name' => 'required|string|max:255']);
            $user->name = $input['name'];
        }

        if (isset($input['email'])) {
            $request->validate(['email' => 'required|email|unique:users,email']);
            $user->email = $input['email'];
           /*   //this code if i need to verify  email if i need edit profile email of user//
            $verificationCode = rand(100000, 999999);
            $user->email_temp = $input['email'];
            $user->verification_code = $verificationCode;
            Mail::to($input['email'])->send(new VerificationCodeMail($verificationCode));
           */
        }


        if (isset($input['new_password'])) {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]);

            if (!Hash::check($input['current_password'], $user->password)) {
                return response()->json(['message' => 'Current password is incorrect'], 400);
            }

            $user->password = bcrypt($input['new_password']);
        }

        $user->save();

        return response()->json(['message' => 'User info updated successfully'], 200);
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'verification_code' => 'required'
        ]);

        $user = Auth::user();

        if ($user->verification_code === $request->verification_code) {
            $user->email = $user->email_temp;
            $user->email_temp = null;
            $user->verification_code = null;
            $user->save();

            return response()->json(['message' => 'Email verified successfully'], 200);
        }

        return response()->json(['message' => 'Invalid verification code'], 400);
    }
}
