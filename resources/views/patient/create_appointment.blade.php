@extends('layout.index')

@section('content')
<div class="mt-2">
    <h5>Make appointment</h5>

    <p>You are about to make appoint with Dr. {{ $doctor->user->first_name }} {{ $doctor->user->last_name }} </p>
     <p>Speciality:  {{ $doctor->speciality }}  </p>
</div>

<form action="{{ route('patient.store.appointment', $doctor->id) }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Date</label>
        <input type="date" name="appointment_date" class="form-control" required/>
        @error('appointment_date')
        <small class="text-danger">{{$message}}</small>
        @enderror
    </div>

       <div class="mb-3">
        <label>Time</label>
        <input type="time" name="appointment_time" class="form-control" required/>
        @error('appointment_time')
        <small class="text-danger">{{$message}}</small>
        @enderror
    </div>

    <button type="submit" class="mt-3 btn btn-primary">Confirm Payment</button>

</form>
@endsection
