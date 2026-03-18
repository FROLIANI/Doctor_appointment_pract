<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use  Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        $data = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable',
            'last_name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string',
        ]);


       $user =  User::create([
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id'=>Role::PATIENT,
        ]);

        Auth::login($user);

        return redirect()->route('login')->with('success', 'Booking sucessfuly, please login');

    }

    public  function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username'=>'required',
            'password'=>'required|string',

        ]);

        if(!Auth::attempt($credentials, $request->boolean('remember')))
            {
                return back()->with('error','Invalid credentails');
            }
            $user = User::where('username', $credentials['username'])->first();

            if($user->isAdmin()){
                return redirect()->route('admin_dashbord');
            }
            if($user->isDoctor()){
                return redirect()->route('doctor_dashbord');
            }
            elseif($user->isPatient()){
                return redirect()->route('patient_dashbord');
            }

            return redirect()->route('register')->with('error', 'account doesnt exist');
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
    public function update(Request $request, string $id):RedirectResponse
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

    public function logout(Request $request):RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('sucess','Logout');
    }
}
