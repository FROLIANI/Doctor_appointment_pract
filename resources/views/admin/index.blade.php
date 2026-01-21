@extends('layout.index')


@section('content')
    <div class="container">
        <h3>Admin DashBoard</h3>
        <p>Hi , welcome {{ Auth::user()->username }}</p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>

        <a href="{{ route('add_doctor') }}">Add Doctor</a>
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
@endsection
