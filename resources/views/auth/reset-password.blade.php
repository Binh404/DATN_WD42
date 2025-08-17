<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .reset-container {
            width: 40%;
            max-width: 500px;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 14px;
            color: #444;
            margin-bottom: 6px;
        }

        input[type="email"],
        input[type="password"] {
            width: 94%;
            padding: 10px 14px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            transition: border-color 0.2s;
        }

        input:focus {
            border-color: #4f46e5;
            /* màu xanh nhạt */
        }

        .error {
            font-size: 13px;
            color: red;
            margin-top: 5px;
        }

        .form-button {
            text-align: center;
            margin-top: 25px;
        }

        .form-button button {
            width: 100%;
            padding: 12px;
            font-size: 15px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            background-color: #000;
            color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-button button:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .reset-container {
                width: 90%;
            }
        }
    </style>
</head>

<body>

    <div class="reset-container">
        <h2>Đặt lại mật khẩu</h2>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required
                    autofocus>
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Mật khẩu mới</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">
                @error('password')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Xác nhận mật khẩu</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password">
                @error('password_confirmation')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Button -->
            <div class="form-button">
                <button type="submit">Đặt lại mật khẩu</button>
            </div>
        </form>
    </div>

</body>

</html>
