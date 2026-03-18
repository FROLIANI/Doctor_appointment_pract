
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
            background: #38c172;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #2f9e5f;
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

        .link {
            text-align: center;
            margin-top: 10px;
        }

        .link a {
            text-decoration: none;
            color: #3490dc;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Forgot Password</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        {{-- Email --}}
        <input
            type="email"
            name="email"
            placeholder="Enter your email"
            value="{{ old('email') }}"
            required
        >

        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">Send Reset Link</button>
    </form>

    <div class="link">
        <a href="{{ route('login') }}">Back to Login</a>
    </div>
</div>

</body>
</html>
