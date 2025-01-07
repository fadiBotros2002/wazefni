<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'location', 'type', 'experience_year', 'salary_min', 'salary_max']);
        $posts = Post::filter($filters)->get();
        return response()->json($posts);
    }



    public function store(Request $request)
    {
        try {
            Log::info('Request received:', $request->all());
            Log::info('Token from request:', ['token' => $request->header('Authorization')]);

            $validated = $request->validate([
                'title' => 'required|max:255',
                'type' => 'required',
                'description' => 'required',
                'requirement' => 'required',
                'location' => 'required',
                'time' => 'required',
                'salary' => 'required',
                'experience_year' => 'required|integer',
            ]);


            $user = auth('sanctum')->user();
            Log::info('Checking authenticated user with auth()->check():', ['check' => auth('sanctum')->check()]);
            Log::info('Authenticated User:', ['user_id' => optional($user)->id]); // استخدام optional لتجنب الأخطاء عند null

            if (!$user) {
                Log::error('User not authenticated.');
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            Log::info('User object:', ['user' => $user]);


            $userID = $user->getAuthIdentifier();
            Log::info('User ID:', ['id' => $userID]);
            Log::info('User Email:', ['email' => $user->email]);

            if (is_null($userID)) {
                Log::error('User ID is null, cannot create post.');
                return response()->json(['error' => 'User ID is null, cannot create post'], 500);
            }

            $post = Post::create([
                'user_id' => $userID,
                'title' => $validated['title'],
                'type' => $validated['type'],
                'description' => $validated['description'],
                'requirement' => $validated['requirement'],
                'location' => $validated['location'],
                'time' => $validated['time'],
                'salary' => $validated['salary'],
                'experience_year' => $validated['experience_year'],
                'test_id' => $request->input('test_id'),
                'posted_at' => now(),
            ]);

            Log::info('Post created successfully:', ['post_id' => $post->id]);
            return response()->json($post, 201);
        } catch (\Exception $e) {
            Log::error('Error creating post: ' . $e->getMessage());
            Log::error('Error Trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'An error occurred while creating the post'], 500);
        }
    }



    public function show($id)
    {
        try {
            $post = Post::findOrFail($id);
            return response()->json($post);
        } catch (\Exception $e) {
            Log::error('Error fetching post with ID ' . $id . ': ' . $e->getMessage());
            return response()->json(['error' => 'Post not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|max:255',
                'type' => 'required',
                'description' => 'required',
                'requirement' => 'required',
                'location' => 'required',
                'time' => 'required',
                'salary' => 'required',
                'experience_year' => 'required|integer',
            ]);

            $post = Post::findOrFail($id);
            $post->update($validated);

            return response()->json($post);
        } catch (\Exception $e) {
            Log::error('Error updating post with ID ' . $id . ': ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while updating the post'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->delete();

            return response()->json(['message' => 'Job deleted successfully'], 204);
        } catch (\Exception $e) {
            Log::error('Error deleting post with ID ' . $id . ': ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while deleting the post'], 500);
        }
    }
    //show posts of the authed employer
    public function getEmpPosts()
    {
        $user = Auth::user();
        $posts = $user->posts;
        return response()->json($posts);
    }
}
