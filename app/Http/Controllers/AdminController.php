<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        $appointments = Appointment::with('patient','doctor.user')->latest()->get();
        return view('admin.index' ,compact('users','appointments'));
    }

    public function show_doctors(){

        if (!Auth::user()->isAdmin()) {
            abort(403, 'admin only');
        }

        $doctors = Doctor::with('user')->latest()->get();
        return view('admin.all_doctors',compact('doctors'));
    }

      public function show_patients(){

        if (!Auth::user()->isAdmin()) {
            abort(403, 'admin only');
        }
        $users = User::where('role_id', Role::PATIENT)->latest()->get();
        return view('admin.all_patients',compact('users'));
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
        if (!Auth::user()->isAdmin()) {
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
      if (!Auth::user()->isAdmin()) {
            abort(403, 'admin only');
        }

        $doctor = Doctor::with('user')->findorFail($id);
        return view('admin.view_doctor', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'admin only');
        }

          $doctor = Doctor::with('user')->findorFail($id);
            return view('admin.edit_doctor', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
          if (!Auth::user()->isAdmin()) abort(403, 'admin only');

           $doctor = Doctor::with('user')->findOrFail($id);
    $user = $doctor->user;

    $data = $request->validate([
        'first_name'  => ['required','string','max:100'],
        'middle_name' => ['nullable','string','max:100'],
        'last_name'   => ['required','string','max:100'],

        'username' => ['required','string','max:50', Rule::unique('users','username')->ignore($user->id)],
        'email'    => ['nullable','email','max:150', Rule::unique('users','email')->ignore($user->id)],

        'speciality' => ['required','string','max:150'],
        'status'     => ['required', Rule::in(['active','inactive'])],


        'password'   => ['nullable','string','min:6'],
    ]);

       $user->update([
        'first_name'  => $data['first_name'],
        'middle_name' => $data['middle_name'] ?? null,
        'last_name'   => $data['last_name'],
        'username'    => $data['username'],
        'email'       => $data['email'] ?? null,
    ]);

     if (!empty($data['password'])) {
        $user->update([
            'password' => Hash::make($data['password']),
        ]);
    }

    // update doctor profile
    $doctor->update([
        'speciality' => $data['speciality'],
        'status'     => $data['status'],
    ]);

    return redirect()
        ->route('all_doctors')
        ->with('success', 'Doctor updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         if (!Auth::user()->isAdmin()) {
        abort(403, 'admin only');
    }

       $doctor = Doctor::with('user')->findOrFail($id);
        $doctor->user->delete();

        return redirect()
        ->route('all_doctors')
        ->with('success', 'Doctor deleted successfully');

    }

    public function view_patient(string $id){
        if(!Auth::user()->isAdmin()){
            abort(403,'Admin only');
        }

        $user = User::findOrFail($id);
        return view('admin.view_patient',compact('user'));
    }

    public function destroy_patient(string $id){
         if(!Auth::user()->isAdmin()){
            abort(403,'Admin only');
        }

        $user = User::where('id',$id)->where('role_id',Role::PATIENT)->findOrFail($id);
        $user->delete();

        return redirect()->route('all_patients')->with('message','Deleted sucesssful');

    }
}
