<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest\changePasswordAuthRequest;
use App\Http\Requests\AuthRequest\loginAuthRequest;
use App\Http\Requests\AuthRequest\updateAuthRequest;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;

class AuthController extends Controller
{
    public function credentialsLogin(loginAuthRequest $request)
    {
        $request->validated();

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('Laravel')->accessToken;

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token
            ]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function updateUser(updateAuthRequest $request)
    {
        $request->validated();

        $user = $request->user();
        
        if ($request->has('name')) {
            $user->name = $request->input('name');
        }
        if ($request->has('email')) {
            $user->email = $request->input('email');
        }
    
        $user->save();

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user,
        ], 201);
    }

    public function changePassword(changePasswordAuthRequest $request)
    {
        $request->validated();

        $user = Auth::user();

        if(!Hash::check($request->current_password, $user->password)){
            return response()->json([
                'error' => 'Current password does not match.'
            ], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        
        return response()->json([
            'message' => 'Password changed successfully.',
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
