<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Create a new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Securely hash the password
            ]);

            // Log the user in
            Auth::login($user);

            // Generate an API token
            $userToken = $user->createToken('api-token')->plainTextToken;

            // Return a success response
            return response([
                'message' => "User created successfully",
                'user' => $user,
                'token' => $userToken,
                'status' => 'success'
            ], 201);

        } catch (ValidationException $e) {
            // Return validation error response
            return response([
                'message' => 'Validation error',
                'errors' => $e->errors(),
                'status' => 'error'
            ], 422);

        } catch (Exception $e) {
            // Return a general error response
            return response([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }
}
