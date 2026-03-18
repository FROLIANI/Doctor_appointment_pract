
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Simple styling (you can replace with Tailwind/Bootstrap) --}}
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            width: 350px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #3490dc;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #2779bd;
        }

        .error {
            color: red;
            font-size: 13px;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Reset Password</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        {{-- Token --}}
        <input type="hidden" name="token" value="{{ $token }}">

        {{-- Email --}}
        <input
            type="email"
            name="email"
            placeholder="Enter your email"
            value="{{ old('email', request()->email) }}"
            required
        >
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- Password --}}
        <input
            type="password"
            name="password"
            placeholder="New Password"
            required
        >
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- Confirm Password --}}
        <input
            type="password"
            name="password_confirmation"
            placeholder="Confirm Password"
            required
        >

        <button type="submit">Reset Password</button>
    </form>
</div>

</body>
</html>
