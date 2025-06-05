@extends('layouts.master')
@section('title', 'Chỉnh sửa phòng ban')

@section('content')


<div class="d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="card shadow-lg" style="width: 100%; max-width: 600px;">
        <div class="card-header bg-warning text-dark text-center">
            <h3 class="mb-0">
                <i class="fas fa-edit me-2"></i>
                Chỉnh sửa phòng ban
            </h3>
            <small class="text-muted">ID: {{ $phongBan->id }}</small>
        </div>

        <div class="card-body p-4">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="/phongban/update/{{ $phongBan->id }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="ma_phong_ban" class="form-label fw-bold">
                        <i class="fas fa-code me-2 text-warning"></i>
                        Mã phòng ban
                    </label>
                    <input type="text"
                        name="ma_phong_ban"
                        id="ma_phong_ban"
                        class="form-control form-control-lg @error('ma_phong_ban') is-invalid @enderror"
                        value="{{ old('ma_phong_ban', $phongBan->ma_phong_ban) }}"
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
                        <i class="fas fa-tag me-2 text-warning"></i>
                        Tên phòng ban
                    </label>
                    <input type="text"
                        name="ten_phong_ban"
                        id="ten_phong_ban"
                        class="form-control form-control-lg @error('ten_phong_ban') is-invalid @enderror"
                        value="{{ old('ten_phong_ban', $phongBan->ten_phong_ban) }}"
                        placeholder="Nhập tên phòng ban">
                    @error('ten_phong_ban')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="mo_ta" class="form-label fw-bold">
                        <i class="fas fa-align-left me-2 text-warning"></i>
                        Mô tả
                    </label>
                    <textarea name="mo_ta"
                        id="mo_ta"
                        class="form-control @error('mo_ta') is-invalid @enderror"
                        rows="4"
                        placeholder="Nhập mô tả phòng ban">{{ old('mo_ta', $phongBan->mo_ta) }}</textarea>
                    @error('mo_ta')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="trang_thai" class="form-label fw-bold">
                        <i class="fas fa-toggle-on me-2 text-warning"></i>
                        Trạng thái
                    </label>
                    <select name="trang_thai"
                        id="trang_thai"
                        class="form-select form-select-lg @error('trang_thai') is-invalid @enderror">
                        <option value="1" {{ $phongBan->trang_thai == 1 ? 'selected' : '' }}>
                            <i class="fas fa-check"></i> Kích hoạt
                        </option>
                        <option value="0" {{ $phongBan->trang_thai == 0 ? 'selected' : '' }}>
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

                <!-- Thông tin thêm -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="info-box p-3 bg-light rounded">
                            <small class="text-muted">
                                <i class="fas fa-calendar-plus me-2"></i>
                                Ngày tạo: @if($phongBan->created_at)
                                {{ date('d/m/Y H:i:s', strtotime($phongBan->created_at)) }}
                                @endif
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box p-3 bg-light rounded">
                            <small class="text-muted">
                                <i class="fas fa-calendar-check me-2"></i>
                                Cập nhật: @if($phongBan->updated_at)
                                {{ date('d/m/Y H:i:s', strtotime($phongBan->updated_at)) }}
                                @endif
                            </small>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-warning btn-lg text-dark">
                        <i class="fas fa-save me-2"></i>
                        Cập nhật phòng ban
                    </button>
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="/phongban" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-arrow-left me-2"></i>
                                Quay lại
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="/phongban/show/{{$phongBan->id}}" class="btn btn-outline-info w-100">
                                <i class="fas fa-eye me-2"></i>
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
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
        background: linear-gradient(45deg, #ffc107, #ffcd39) !important;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }

    .btn {
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-warning {
        background: linear-gradient(45deg, #ffc107, #ffcd39);
        border: none;
        color: #000 !important;
    }

    .btn-warning:hover {
        background: linear-gradient(45deg, #e0a800, #e6b800);
        transform: translateY(-2px);
        color: #000 !important;
    }

    .btn-outline-secondary:hover,
    .btn-outline-info:hover {
        transform: translateY(-2px);
    }

    .alert {
        border-radius: 10px;
    }

    .shadow-lg {
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }

    .info-box {
        border-left: 4px solid #ffc107;
        background: #f8f9fa !important;
    }

    .text-warning {
        color: #e67e22 !important;
    }
</style>
@endsection