@extends('layouts.master')
@section('title', 'Thêm phòng ban mới')

@section('content')


<div class="d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="card shadow-lg" style="width: 100%; max-width: 600px;">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">
                <i class="fas fa-building me-2"></i>
                Thêm phòng ban mới
            </h3>
        </div>

        <div class="card-body p-4">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="/phongban/store" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="ma_phong_ban" class="form-label fw-bold">
                        <i class="fas fa-code me-2 text-primary"></i>
                        Mã phòng ban
                    </label>
                    <input type="text"
                        name="ma_phong_ban"
                        id="ma_phong_ban"
                        class="form-control form-control-lg @error('ma_phong_ban') is-invalid @enderror"
                        value="{{ old('ma_phong_ban') }}"
                        placeholder="Nhập mã phòng ban">
                    @error('ma_phong_ban')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="ten_phong_ban" class="form-label fw-bold">
                        <i class="fas fa-tag me-2 text-primary"></i>
                        Tên phòng ban
                    </label>
                    <input type="text"
                        name="ten_phong_ban"
                        id="ten_phong_ban"
                        class="form-control form-control-lg @error('ten_phong_ban') is-invalid @enderror"
                        value="{{ old('ten_phong_ban') }}"
                        placeholder="Nhập tên phòng ban">
                    @error('ten_phong_ban')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="ten_phong_ban" class="form-label fw-bold">
                        <i class="fas fa-money-bill-wave me-2 text-primary"></i>
                        Ngân sách
                    </label>
                    <input type="number"
                        name="ngan_sach"
                        id="ngan_sach"
                        class="form-control form-control-lg @error('ngan_sach') is-invalid @enderror"
                        value="{{ old('ngan_sach') }}"
                        placeholder="Nhập ngân sách phòng ban">
                    @error('ngan_sach')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                    @enderror
                </div>


                <div class="mb-4">
                    <label for="mo_ta" class="form-label fw-bold">
                        <i class="fas fa-align-left me-2 text-primary"></i>
                        Mô tả
                    </label>
                    <textarea name="mo_ta"
                        id="mo_ta"
                        class="form-control @error('mo_ta') is-invalid @enderror"
                        rows="4"
                        placeholder="Nhập mô tả phòng ban">{{ old('mo_ta') }}</textarea>
                    @error('mo_ta')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                    @enderror
                </div>


                <div class="mb-4">
                    <label for="trang_thai" class="form-label fw-bold">
                        <i class="fas fa-toggle-on me-2 text-primary"></i>
                        Trạng thái
                    </label>
                    <select name="trang_thai"
                        id="trang_thai"
                        class="form-select form-select-lg @error('trang_thai') is-invalid @enderror">
                        <option value="1" {{ old('trang_thai') == '1' ? 'selected' : '' }}>
                            <i class="fas fa-check"></i> Kích hoạt
                        </option>
                        <option value="0" {{ old('trang_thai') == '0' ? 'selected' : '' }}>
                            <i class="fas fa-pause"></i> Tạm ngưng
                        </option>
                    </select>
                    @error('trang_thai')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus-circle me-2"></i>
                        Thêm phòng ban
                    </button>
                    <a href="/phongban" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Quay lại danh sách
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .min-vh-100 {
        min-height: 100vh;
    }

    .card {
        border: none;
        border-radius: 15px;
    }

    .card-header {
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .btn {
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(45deg, #0d6efd, #6610f2);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(45deg, #0b5ed7, #520dc2);
        transform: translateY(-2px);
    }

    .alert {
        border-radius: 10px;
    }

    .shadow-lg {
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }
</style>
@endsection