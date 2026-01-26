@extends('layout.index')

@section('content')

<h4>Patient details</h4>

<p><strong>ID:</strong>{{$user->id}}</p>
<p><strong>Name:</strong>
    {{$user->first_name}}
    {{$user->middle_name}}
     {{$user->last_name}}
</p>

<p><strong>Username:</strong>{{$user->username}}</p>

<p><strong>Email:</strong>{{$user->email}}</p>


<a href="{{ route('all_patients') }}">Back</a>
@endsection
