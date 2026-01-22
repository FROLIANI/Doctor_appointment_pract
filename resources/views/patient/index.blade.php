@extends('layout.index')


@section('content')
    <div class="container">
        <h3>Patient DashBoard
        </h3>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>

        </form>
        <p>Hi , welcome <span class="fw-bold">{{ Auth::user()->username }}</span></p>

        <p>All available Doctors</p>
        <table class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Speciality</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($doctors as $doctor)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $doctor->user->first_name }}
                            {{ $doctor->user->last_name }}
                        </td>

                        <td>{{ $doctor->user->email ?? '-' }}</td>

                        <td>{{ $doctor->speciality }}</td>

                        <td>
                            <a href="{{ route('make_appointment', $doctor->id) }}" class="btn btn-sm btn-primary">Make
                                appointment</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No doctors found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

         <p>All Your Appointments</p>
        <table class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Doctor Name</th>
                    <th>Specilaity</th>
                    <th>Date</th>
                     <th>Time</th>
                    <th>Satus</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($appointments  as $appointment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                           Dr.{{ $appointment->doctor->user->first_name }}
                           {{ $appointment->doctor->user->last_name }}
                        </td>

                        <td>{{ $appointment->doctor->speciality }}</td>

                        <td>{{ $appointment->appointment_date }}</td>

                        <td>{{ $appointment->appointment_time }}</td>

                        <td>
                            <span class="badge"
                            {{ $appointment->status ==='Pending'? 'bg-warning':'bg-success' }}
                            >
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            You have no Appointments
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection
