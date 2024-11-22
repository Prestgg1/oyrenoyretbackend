<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // Find the user by email
            $user = User::where('email', $request->email)->first();

            // Check if user exists and password is correct
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => 'The provided credentials are incorrect.',
                    'status' => 'error'
                ], 401); // Unauthorized
            }

            // Generate an API token
            $userToken = $user->createToken('api-token')->plainTextToken;

            // Return a success response
            return response([
                'message' => 'Login successful',
                'token' => $userToken,
                'status' => 'success'
            ], 200);

        } catch (ValidationException $e) {
            // Handle validation errors
            return response([
                'message' => 'Validation error',
                'errors' => $e->errors(),
                'status' => 'error'
            ], 422); // Unprocessable Entity

        } catch (Exception $e) {
            // Handle general exceptions
            return response([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
                'status' => 'error'
            ], 500); // Internal Server Error
        }
    }
}
