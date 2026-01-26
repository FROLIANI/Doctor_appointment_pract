<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
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
        if (! Auth::user()->isDoctor()) {
            abort(403, 'admin only');
        }

        $doctor = Auth::user()->doctor;
        $appointments = Appointment::with('patient')->where('doctor_id', $doctor->id)->latest()->get();

        return view('doctor.index', compact('appointments'));
    }

    public function approve(Appointment $appointment)
    {
        if (! Auth::user()->isDoctor()) {
            abort(403, 'doctor only');
        }

        $doctor = Auth::user()->doctor;
        if ($appointment->doctor_id !== $doctor->id) {
            abort(403, 'not your appointment');
        }

        $appointment->update(['status' => 'Approved']);

        return back()->with('success', 'Appointment approved');
    }
    

    public function cancel(Appointment $appointment)
    {
        if (! Auth::user()->isDoctor()) {
            abort(403, 'doctor only');
        }

        $doctor = Auth::user()->doctor;
        if ($appointment->doctor_id !== $doctor->id) {
            abort(403, 'not your appointment');
        }

        $appointment->update(['status' => 'Rejected']);

        return back()->with('success', 'Appointment cancelled');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
