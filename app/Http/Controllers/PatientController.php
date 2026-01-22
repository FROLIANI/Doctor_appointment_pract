<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function _construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Auth::user()->isPatient()) {
            abort(403, 'patient only');
        }
        $doctors = Doctor::with('user')->latest()->get();
        $appointments = Appointment::with('doctor.user')->where('patient_id',Auth::id())->latest()->get();

        return view('patient.index', compact('doctors','appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($doctor)
    {
        if (! Auth::user()->isPatient()) {
            abort(403, 'patient only');
        }

        $doctor = Doctor::with('user')->findOrFail($doctor);

        return view('patient.create_appointment', compact('doctor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $doctor)
    {
        if (! Auth::user()->isPatient()) {
            abort(403, 'patient only');
        }

        $doctor = Doctor::findOrFail($doctor);

        $data = $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
        ]);

        Appointment::create([
            'patient_id' => Auth::id(),
            'doctor_id' => $doctor->id,
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'status' => 'Pending',
        ]);

        return redirect()->route('patient_dashbord')->with('message', 'Appointment created sucessful');

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
