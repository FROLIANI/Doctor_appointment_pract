@extends('layout.index')


@section('content')
    <div class="container">
        <h3>Admin DashBoard</h3>
        <p>Hi , welcome {{ Auth::user()->username }}</p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>

        <a class="gap-2" href="{{ route('add_doctor') }}">Add Doctor</a>
        <a href="{{ route('all_doctors') }}">All Doctors</a>
        <a href="{{ route('all_patients') }}">All Patients</a>
    </div>

    <h5>All Users</h5>

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">

            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined</th>
            </tr>

            <tboday>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->username }}</td>
                        <td>
                            {{ $user->first_name }}
                            {{ $user->middle_name }}
                            {{ $user->last_name }}
                        </td>
                        <td>{{ $user->email ?? '-' }}</td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $user->role->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No users found
                        </td>
                    </tr>
                @endforelse
            </tboday>

        </thead>
    </table>

    <h5>All Appointments made</h5>
    <table class="w-full border border-gray-300 mt-4">
        <thead class="bg-gray-800 text-white">
            <tr class="border-b">
                <td>Appointment Id</td>
                <td>Patient Id</td>
                <td>Doctor Id</td>
                <td>Appointment Date</td>
                <td>Appointment Time</td>
                <td>Status</td>
            </tr>
        </thead>

        <tbody>
            @forelse ($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->id }}</td>
                    <td>{{ $appointment->patient_id }}</td>
                    <td>{{ $appointment->doctor_id }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>{{ $appointment->appointment_time }}</td>
                    <td>{{ $appointment->status }}</td>
                </tr>

            @empty
                <tr>
                    <td>No appointments Found</td>
                </tr>
            @endforelse
        </tbody>

    </table>
@endsection
