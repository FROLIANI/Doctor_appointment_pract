<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // make sure is login
    public function _construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'admin only');
        }

        $users = User::with('role')->latest()->get();
        return view('admin.index' ,compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'admin only');
        }

        return view('admin.add_doctor');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'admin only');
        }

        $data = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable',
            'last_name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|email|unique:users,email',
            'speciality' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::create([
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => Role::DOCTOR,
        ]);

        Doctor::create([
            'user_id'=>  $user->id,
            'speciality' => $data['speciality'],
        ]);

        return redirect()->route('admin_dashbord')->with('sucess', 'Doctor account added sucessful');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
