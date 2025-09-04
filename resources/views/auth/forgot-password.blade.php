<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: #fff;
            width: 40%;
            max-width: 450px;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 8px;
        }

        p {
            font-size: 14px;
            color: #666;
            text-align: center;
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

        input {
            width: 94%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .error {
            font-size: 13px;
            color: red;
            margin-top: 4px;
        }

        button {
            width: 100%;
            padding: 12px;
            font-size: 15px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            background-color: #080808;
            color: white;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color: #454545;
        }

        .status {
            background: #dcfce7;
            color: #166534;
            padding: 10px;
            font-size: 14px;
            border-radius: 6px;
            margin-bottom: 16px;
            text-align: center;
        }

        .back-link {
            margin-top: 18px;
            text-align: center;
        }

        .back-link a {
            font-size: 14px;
            color: #4f46e5;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Title -->
        <h2>Quên mật khẩu?</h2>
        <p>Nhập email của bạn và chúng tôi sẽ gửi liên kết để đặt lại mật khẩu.</p>

        <!-- Session status -->
        @if (session('status'))
            <div class="status">{{ session('status') }}</div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit">Gửi liên kết đặt lại mật khẩu</button>
        </form>

        <!-- Back to login -->
        <div class="back-link">
            <a href="{{ route('login') }}">← Quay lại đăng nhập</a>
        </div>
    </div>
</body>

</html>
