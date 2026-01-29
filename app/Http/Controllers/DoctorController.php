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
    if (!Auth::user()->isPatient()) abort(403, 'patient only');

    $appointment = Appointment::with('doctor.user')
        ->where('patient_id', Auth::id())
        ->findOrFail($id);

    if ($appointment->status !== 'Pending') {
        return back()->with('error', 'You can only edit pending appointments.');
    }

    return view('patient.edit_appointment', compact('appointment'));
}


    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
{
    if (!Auth::user()->isPatient()) abort(403, 'patient only');

    $appointment = Appointment::where('patient_id', Auth::id())->findOrFail($id);

    if ($appointment->status !== 'Pending') {
        return back()->with('error', 'You can only update pending appointments.');
    }

    $data = $request->validate([
        'appointment_date' => 'required|date|after_or_equal:today',
        'appointment_time' => 'required',
    ]);

    $appointment->update([
        'appointment_date' => $data['appointment_date'],
        'appointment_time' => $data['appointment_time'],
    ]);

    return redirect()->route('patient_dashbord')->with('message', 'Appointment updated successfully.');
}
    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
{
    if (!Auth::user()->isPatient()) {
        abort(403, 'patient only');
    }

    $appointment = Appointment::where('patient_id', Auth::id())
        ->findOrFail($id);

    if ($appointment->status !== 'Pending') {
        return back()->with('error', 'You can only cancel pending appointments.');
    }

    $appointment->delete();

    return redirect()
        ->route('patient_dashbord')
        ->with('message', 'Appointment cancelled successfully.');
}
}
