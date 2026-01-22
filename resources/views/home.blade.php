@extends('layout.index')

@section('content')
<div class="container mt-5 text-center">
    <h1>Welcome</h1>
    <p>Create an Account/Login to continue</p>

    <a href="{{ route('register') }}" class="btn btn-primary">
        Register
    </a>

    <h6>OR</h6>

    <a href="{{ route('login') }}" class="btn btn-outline-secondary ms-2">
        Login
    </a>
</div>
@endsection
