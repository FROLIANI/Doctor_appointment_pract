<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name'  => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'username'    => ['required', 'string', 'max:255', 'unique:users,username'],
            'email'       => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'    => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'first_name'  => $data['first_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'last_name'   => $data['last_name'],
            'username'    => $data['username'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'role_id'     => Role::PATIENT,
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success'    => true,
            'message'    => 'Registered successfully',
            'token'      => $token,
            'token_type' => 'Bearer',
            'user'       => [
                'id'       => $user->id,
                'username' => $user->username,
                'email'    => $user->email,
            ],
        ], 201);
    }

    public function login(Request $request)
{
    $data = $request->validate([
        'username' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    $user = User::where('username', $data['username'])->first();

    if (!$user || !Hash::check($data['password'], $user->password)) {
        return response()->json([
            'status'  => false,
            'code'    => 401,
            'message' => 'Invalid credentials',
        ], 401);
    }

    $user->tokens()->delete();

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'status'  => true,
        'code'    => 200,
        'message' => 'Login successful',
        'token'   => $token,
        'token_type' => 'Bearer',
        'user'    => [
            'id'       => $user->id,
            'username' => $user->username,
            'email'    => $user->email,
            'role_id'  => $user->role_id,
        ],
    ], 200);
}

}
