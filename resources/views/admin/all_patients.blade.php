@extends('layout.index')

@section('content')
    <h4>All Patients</h4>

    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
            </tr>

        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->first_name }}
                        {{ $user->middle_name }}
                        {{ $user->last_name }}
                    </td>

                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                     <td>
                        <a href="{{ route('view_patient', $user->id) }}">View</a>

                        <form action="{{ route('admin.patient.destroy_patient',$user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="Submit">Delete</button>
                        </form>
                     </td>
                </tr>

            @empty
                <tr>
                    <td>No Patient record found</td>
                </tr>
            @endforelse
        </tbody>
        </thead>
    </table>
@endsection
