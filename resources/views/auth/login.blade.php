@extends('layout.index')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Login</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('store.post') }}" method="POST">
                @csrf

                 <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>

                   <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <button type="submit">Login Now</button>

            </form>
        </div>
    </div>
</div>


@endsection


