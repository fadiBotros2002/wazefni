<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class PasswordResetController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        Log::info('Requesting password reset link for email: ' . $request->email);

        // Generate verification code
        $user = \App\Models\User::where('email', $request->email)->first();
        if (!$user) {
            Log::warning('Email not found: ' . $request->email);
            throw ValidationException::withMessages([
                'email' => ['Email not found.'],
            ]);
        }

        $verificationCode = rand(100000, 999999);
        $user->verification_code = $verificationCode;
        $user->save();

        // Send the email with verification code
        Mail::to($user->email)->send(new \App\Mail\ResetPasswordCodeMail($verificationCode));
        Log::info('Verification code sent successfully to email: ' . $user->email);
        return response()->json(['message' => 'Verification code sent successfully.']);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        Log::info('Attempting to reset password for email: ' . $request->email);

        $user = \App\Models\User::where('email', $request->email)
                                ->where('verification_code', $request->verification_code)
                                ->first();

        if (!$user) {
            Log::warning('Verification code does not match for email: ' . $request->email);
            throw ValidationException::withMessages([
                'verification_code' => ['The verification code is invalid.'],
            ]);
        }

        $user->forceFill([
            'password' => bcrypt($request->password),
            'verification_code' => null // Clear the verification code after successful reset
        ])->save();

        Log::info('Password reset successfully for user: ' . $user->email);

        return response()->json(['message' => 'Password reset successfully.']);
    }
}
