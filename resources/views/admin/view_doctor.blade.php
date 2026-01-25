@extends('layout.index')

@section('content')
<div class="max-w-xl mx-auto mt-6 p-4 border rounded">
    <h3 class="text-xl font-semibold mb-4">Doctor Details</h3>

    <p><strong>Full Name:</strong>
        {{ $doctor->user->first_name }}
        {{ $doctor->user->last_name }}
    </p>

    <p><strong>Username:</strong> {{ $doctor->user->username }}</p>

    <p><strong>Email:</strong> {{ $doctor->user->email ?? '-' }}</p>

    <p><strong>Speciality:</strong> {{ $doctor->speciality }}</p>

    <p><strong>Status:</strong>
        <span class="px-2 py-1 rounded text-sm
            {{ $doctor->status === 'active' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
            {{ ucfirst($doctor->status) }}
        </span>
    </p>

    <div class="mt-4">
        <a href="{{ route('all_doctors') }}"
           class="text-blue-600 hover:underline">
            ← Back to Doctors
        </a>
    </div>
</div>
@endsection
