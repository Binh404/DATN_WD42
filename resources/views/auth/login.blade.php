{{-- cnmxnc --}}
<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-9/assets/css/login-9.css">
<!-- Login 9 - Bootstrap Brain Component -->
@if ($errors->has('message'))
    <div class="alert alert-danger">
        {{ $errors->first('message') }}
    </div>
@endif
<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<style>
    body {
        background: linear-gradient(135deg, #4e73df, #1cc88a);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-container {
        max-width: 1000px;
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .login-left {
        background: #f8f9fc;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
    }

    .login-left img {
        max-width: 200px;
        margin-bottom: 20px;
    }

    .login-left h4 {
        font-weight: 700;
        margin-bottom: 15px;
    }

    .login-left p {
        color: #6c757d;
    }

    .login-right {
        padding: 40px;
    }

    .btn-primary {
        border-radius: 30px;
        padding: 12px;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .form-control {
        border-radius: 10px;
    }

    .form-floating label {
        color: #6c757d;
    }
</style>

<div class="container login-container">
    <div class="row g-0">
        <div class="col-md-6 login-left">
            <img src="./assets/images/dvlogo.png" alt="Logo" style="margin-left: 100px">
            <h4>DV Tech</h4>
            <p>Chúng tôi kết hợp công nghệ, sáng tạo và AI để biến ý tưởng của bạn thành sản phẩm số ấn tượng.</p>
        </div>
        <div class="col-md-6 login-right">
            <h3 class="mb-4">Đăng nhập</h3>

            @if ($errors->has('message'))
                <div class="alert alert-danger">
                    {{ $errors->first('message') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                        placeholder="name@example.com" required>
                    <label for="email">Email</label>
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu"
                        required>
                    <label for="password">Mật khẩu</label>
                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">Đăng nhập ngay</button>
            </form>
            <div class="row">
                <div class="col-12">
                    <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-4">

                        <a href="{{ route('password.request') }}">Quên mật khẩu?</a>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
