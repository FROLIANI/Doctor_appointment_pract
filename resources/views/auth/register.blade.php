@extends('layout.index')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Make appointment</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('store.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="fname" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="fname" name="first_name" required>
                </div>

                <div class="mb-3">
                    <label for="mname" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" id="mname" name="middle_name">
                </div>

                <div class="mb-3">
                    <label for="lname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lname" name="last_name">
                </div>

                 <div class="mb-3">
                    <label for="username" class="form-label">UserName</label>
                    <input type="text" class="form-control" id="username" name="username">
                </div>

                 <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>

                   <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <button type="submit">Book Now</button>

            </form>
        </div>
    </div>
</div>


@endsection


