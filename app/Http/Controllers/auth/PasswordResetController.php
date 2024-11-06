<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{

    /**
     * Send the password reset link email with verification code
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validate the email input
        $request->validate(
            ['email' => 'required|email']
        );

        Log::info('Requesting password reset link for email: ' . $request->email);

        // Generate verification code
        $user = \App\Models\User::where('email', $request->email)->first();
        if (!$user) {
            Log::warning('Email not found: ' . $request->email);
            throw ValidationException::withMessages([
                'email' => ['Email not found.'],
            ]);
        }

        // Generate a random 6-digit verification code
        $verificationCode = rand(100000, 999999);
        $user->verification_code = $verificationCode;
        $user->save();

        // Send the email with the verification code
        Mail::to($user->email)->send(new \App\Mail\ResetPasswordCodeMail($verificationCode));
        Log::info('Verification code sent successfully to email: ' . $user->email);
        return response()->json(['message' => 'Verification code sent successfully.']);
    }

    /**
     * Reset the password using the verification code
     */
    public function reset(Request $request)
    {
        try {
            // Validate the input data, including password confirmation
            $request->validate([
                'email' => 'required|email',
                'verification_code' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);
        } catch (ValidationException $e) {
            // Log validation errors
            Log::warning('Validation failed for password reset: ' . json_encode($e->errors()));
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        }

        Log::info('Attempting to reset password for email: ' . $request->email);

        // Verify the provided verification code
        $user = \App\Models\User::where('email', $request->email)
                                ->where('verification_code', $request->verification_code)
                                ->first();

        if (!$user) {
            Log::warning('Verification code does not match for email: ' . $request->email);
            return response()->json(['message' => 'Invalid verification code'], 400);
        }

        // Update the user's password and clear the verification code
        $user->forceFill([
            'password' => bcrypt($request->password),
            'verification_code' => null // Clear the verification code after successful reset
        ])->save();

        Log::info('Password reset successfully for user: ' . $user->email);

        return response()->json(['message' => 'Password reset successfully.']);
    }
}
