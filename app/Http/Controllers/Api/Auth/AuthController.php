<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => Role::PATIENT,
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registered successfully',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
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

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json([
                'status' => false,
                'code' => 401,
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Login successful',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role_id' => $user->role_id,
            ],
        ], 200);
    }

    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Profile fetched successfuly',
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'middle_name' => $user->middle_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'email' => $user->email,
                'role_id' => $user->role_id,
            ],
        ]);
    }

    public function edit(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            'middle_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'last_name' => ['sometimes', 'required', 'string', 'max:255'],

            'username' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            // optional password change
            'password' => ['sometimes', 'nullable', 'string', 'min:8'],
        ]);

        if (array_key_exists('password', $data)) {
            if ($data['password']) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
        }

        $user->update($data);

        return response()->json([
            'id' => $user->id,
            'first_name' => $user->first_name,
            'middle_name' => $user->middle_name,
            'last_name' => $user->last_name,
            'username' => $user->username,
            'email' => $user->email,
            'role_id' => $user->role_id,
        ]);

    }

    public function destroy(Request $request){
        $user = $request->user();

        $user->tokens()->delete();

        $user->delete();

        return response()->json([
            'status'=>true,
            'code'=> 200,
            'message'=>'User deleted successful',
        ]);
    }

    public function index(){
        $users = User::latest()->paginate(10);

        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'Data Fetched succesful',
            'data'=> $user,
        ]);
    }

    public function showUser(User $user){
        return response()->json([
            'status'=>true,
            'code'=>200,
            'data'=> $user,
        ]);
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'first_name'  => ['sometimes', 'required', 'string', 'max:255'],
            'middle_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'last_name'   => ['sometimes', 'required', 'string', 'max:255'],

            'username' => [
                'sometimes', 'required', 'string', 'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'sometimes', 'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            // optional password change
            'password' => ['sometimes', 'nullable', 'string', 'min:8'],
        ]);

        if (array_key_exists('password', $data)) {
            if ($data['password']) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
        }

        $user->update($data);

        return response()->json([
            'status'  => true,
            'code'    => 200,
            'message' => 'User updated successfully',
            'data'    => $user,
        ]);
    }

    public function destroyUser(User $user){
        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'User deleted successful',
        ]);
    }


    //Another way to write
    public function destroyuser2(string $id)
{
    $user = User::findOrFail($id);

    $user->tokens()->delete();
    $user->delete();

    return response()->json([
        'status'  => true,
        'code'    => 200,
        'message' => 'User deleted successfully',
    ]);
}

public function logout(Request $request){
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'status'=>true,
        'code'=>200,
        'message'=>'Logout successfuly',
    ]);
}

}
