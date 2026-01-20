@extends('layout.index')


@section('content')

<div class="container">
    <h3>Patient DashBoard
    </h3>

    <form method="POST" action="{{route('logout')  }}">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>

    </form>
    <p>Hi , welcome {{Auth::user()->username}}</p>
</div>

@endsection
