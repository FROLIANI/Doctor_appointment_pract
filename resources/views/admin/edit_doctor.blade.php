@extends('layout.index')

@section('content')
    <h2 class="text-xl font-semibold mb-4">Edit Doctor</h2>

    <form method="POST" action="{{ route('admin.doctor.update', $doctor->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>First Name</label>
            <input name="first_name" value="{{ old('first_name', $doctor->user->first_name) }}" />
        </div>

        <div class="mb-3">
            <label>Middle Name</label>
            <input name="middle_name" value="{{ old('middle_name', $doctor->user->middle_name) }}" />
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input name="last_name" value="{{ old('last_name', $doctor->user->last_name) }}" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Username</label>
            <input name="username" class="w-full border rounded px-3 py-2"
                value="{{ old('username', $doctor->user->username) }}">
            @error('username')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input name="email" type="email" class="w-full border rounded px-3 py-2"
                value="{{ old('email', $doctor->user->email) }}">
            @error('email')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Speciality</label>
            <input name="speciality" class="w-full border rounded px-3 py-2"
                value="{{ old('speciality', $doctor->speciality) }}">
            @error('speciality')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

         <div>
            <label class="block text-sm font-medium mb-1">New Password (optional)</label>
            <input name="password" type="password" class="w-full border rounded px-3 py-2"
                   placeholder="Leave empty to keep current password">
            @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

         <div class="flex gap-3">
            <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
                Save Changes
            </button>
    </form>
@endsection
