@extends('layout.index')


@section('content')
    <div class="container">
        <h3>Doctor DashBoard</h3>
        <p>Hi , welcome {{ Auth::user()->username }}</p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>

        </form>

        <h4>Received Appointments</h4>

        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                     <th>#</th>
                     <th>patient</th>
                     <th>Date</th>
                     <th>Time</th>
                     <th>status</th>
                      <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($appointments as $appointment)

                <tr>
                    <td>{{$appointment->id}}</td>
                    <td>{{$appointment->patient->first_name}}
                        {{$appointment->patient->middle_name}}
                         {{$appointment->patient->last_name}}
                    </td>
                     <td>{{$appointment->appointment_date}}</td>

                     <td>{{$appointment->appointment_time}}</td>

                      <td>{{$appointment->status}}</td>

                      <td>
                        <form method="POST" action="{{ route('doctor.appointment.approve', $appointment->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                        </form>

                        <form method="POST" action="{{ route('doctor.appointment.cancel', $appointment->id) }}">
                            @csrf
                             <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                        </form>
                      </td>
                </tr>

                @empty
                <tr>
                    <td>You have no appointment yet</td>
                </tr>

                @endforelse
            </tbody>
        </table>
    </div>
@endsection
