@extends('layout.index')


@section('content')

<div class="container">
    <h3>Admin DashBoard</h3>
    <p>Hi , welcome {{Auth::user()->username}}</p>

    <form method="POST" action="{{route('logout')  }}">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>

    </form>
</div>

@endsection
