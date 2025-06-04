<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .login-container {
            max-width: 400px;
            margin: 80px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 24px;
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #333;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
        }

        .form-check input {
            margin-right: 8px;
        }

        .form-check label {
            font-size: 14px;
            color: #555;
        }

        .form-error {
            color: #e63946;
            font-size: 13px;
            margin-top: 4px;
        }

        .login-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .login-footer a {
            font-size: 14px;
            color: #1d4ed8;
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        button {
            padding: 10px 20px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            padding: 10px 15px;
            margin-bottom: 20px;
            border: 1px solid #10b981;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>

        @if (session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>


            <div class="login-footer">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                @endif

                <button type="submit">Log in</button>
            </div>
        </form>
    </div>

</body>

</html>



