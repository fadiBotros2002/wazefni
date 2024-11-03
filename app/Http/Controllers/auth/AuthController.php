<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function sendVerificationCode(Request $request)
    {
        Log::info('Attempting to send verification code.', ['request' => $request->all()]);

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|string|email|max:255|unique:users',
            ]
        );
        if ($validator->fails()) {
            Log::warning('Validation failed for sending verification code.', ['errors' => $validator->errors()]);

            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 401);
        }

        $verificationCode = rand(100000, 999999);
        Log::info('Generated verification code.', ['code' => $verificationCode]);

        $request->session()->put('verification_code', $verificationCode);
        $request->session()->put('email', $request->email);
        Log::info('Verification code and email stored in session.');

        try {
            Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));
            Log::info('Verification code sent to email.');
        } catch (\Exception $e) {
            Log::error('Error occurred while sending verification code.', ['exception' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to send verification code'], 500);
        }

        return response()->json(['message' => 'Verification code sent to email'], 200);
    }

    public function register(Request $request)
    {
        Log::info('Attempting to register a user.', ['request' => $request->all()]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'in:admin,user,employer',
            'userstatus' => 'in:active,inactive,pending',
            'verification_code' => 'required|integer'
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed for registering user.', ['errors' => $validator->errors()]);

            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 401);
        }

        if ($request->verification_code != $request->session()->get('verification_code')) {
            Log::warning('Invalid verification code provided.', ['provided_code' => $request->verification_code]);

            return response()->json([
                'status' => false,
                'message' => 'Invalid verification code'
            ], 401);
        }

        if ($request->email != $request->session()->get('email')) {
            Log::warning('Email mismatch.', ['session_email' => $request->session()->get('email'), 'provided_email' => $request->email]);

            return response()->json([
                'status' => false,
                'message' => 'Email mismatch'
            ], 401);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role ?? 'user',
                'userstatus' => $request->userstatus ?? 'active',
                'email_verified_at' => now(),
            ]);

            event(new Registered($user));

            Log::info('User registered successfully.', ['user' => $user]);

            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error occurred while registering user.', ['exception' => $th]);

            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }



    public function login(Request $request)
    {
        try {
            Log::info('Attempting to log in a user.', ['request' => $request->all()]);

            $validateUser = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validateUser->fails()) {
                Log::warning('Validation failed for login.', ['errors' => $validateUser->errors()]);

                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                Log::warning('Authentication failed. Email and password do not match.', ['email' => $request->email]);
                return response()->json([
                    'status' => false,
                    'message' => 'email and password do not match our records'
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            Log::info('User logged in successfully.', ['user' => $user]);
            return response()->json([
                'status' => true,
                'message' => 'user logged in successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error occurred while logging in user.', ['exception' => $th]);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }


    ############################################################################################

    public function logout()
    {
        try {
            Log::info('Attempting to log out a user.', ['user' => Auth::user()]);

            $user = Auth::user();
            if (!$user) {

                Log::warning('No authenticated user found for logout.');
                return response()->json(['status' => false, 'message' => 'No authenticated user found'], 401);
            }


            $user->tokens()->delete();
            Log::info('User logged out successfully.', ['user' => $user]);
            return response()->json(
                [
                    'status' => true,
                    'message' => 'user logged out',
                    'data' => [],
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error('Error occurred while logging out user.', ['exception' => $th]);
            return response()->json(['status' => false, 'message' => $th->getMessage(),], 500);
        }
    }
}
