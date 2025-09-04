@extends('layoutsAdmin.master')@section('title', 'Chỉnh sửa phòng ban')

@section('content')
  <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Chỉnh sửa phòng ban</h2>
                    {{-- <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.chamcong.index') }}"></a></li>
                            <li class="breadcrumb-item active">Thêm phòng ban</li>
                        </ol>
                    </nav> --}}
                    <p class="mb-0 opacity-75">Chỉnh sửa thông tin bản ghi phòng ban</p>

                </div>
                <div>
                    <a href="{{ route('phongban.index') }}" class="btn btn-light">
                        <i class="mdi mdi-arrow-left me-2"></i>Quay lại
                    </a>
                    <a href="{{ route('phongban.show', $phongBan->id) }}" class="btn btn-secondary">
                        <i class="mdi mdi-eye me-2"></i>Xem chi tiết
                    </a>
                </div>
            </div>
        </div>
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <div>
                    <strong>Có lỗi xảy ra:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('phongban.update', $phongBan->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header bg-warning text-white mb-3">
                            <h3 class="mb-0">
                                <i class="mdi mdi-pencil me-2"></i>Thông tin phòng ban
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!-- Tên phòng ban -->
                                <div class="col-md-12 mb-3">
                                    <label for="ma_phong_ban" class="form-label">
                                        <i class="mdi mdi-identifier text-primary me-2"></i>Mã phòng ban
                                    </label>
                                    <input type="text" class="form-control @error('ma_phong_ban') is-invalid @enderror"
                                        id="ma_phong_ban" name="ma_phong_ban" placeholder="Nhập tên phòng ban..."
                                        value="{{ old('ma_phong_ban', $phongBan->ma_phong_ban) }}" >
                                    @error('ten_phong_ban')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Tên phòng ban -->
                                <div class="col-md-12 mb-3">
                                    <label for="ten_phong_ban" class="form-label">
                                        <i class="mdi mdi-domain text-primary me-2"></i>Tên phòng ban
                                    </label>
                                    <input type="text" class="form-control @error('ten_phong_ban') is-invalid @enderror"
                                        id="ten_phong_ban" name="ten_phong_ban" placeholder="Nhập tên phòng ban..."
                                        value="{{ old('ten_phong_ban', $phongBan->ten_phong_ban) }}" >
                                    @error('ten_phong_ban')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Trạng thái -->
                                <div class="col-md-12 mb-3">
                                    <label for="trang_thai" class="form-label">
                                        <i class="mdi mdi-flag text-primary me-2"></i>Trạng thái
                                    </label>
                                    <select class="form-select @error('trang_thai') is-invalid @enderror" id="trang_thai"
                                        name="trang_thai" >
                                        <option value="">-- Chọn trạng thái --</option>
                                        <option value="1" {{ old('trang_thai', $phongBan->trang_thai) == '1' ? 'selected' : '' }}>
                                            Kích hoạt
                                        </option>
                                        <option value="0" {{ old('trang_thai', $phongBan->trang_thai) == '0' ? 'selected' : '' }}>
                                            Tạm ngưng
                                        </option>
                                    </select>
                                    @error('trang_thai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Ghi chú -->
                                <div class="col-12 mb-3">
                                    <label for="mo_ta" class="form-label">
                                        <i class="mdi mdi-note-text-outline text-secondary me-2"></i>Ghi chú
                                    </label>
                                    <textarea class="form-control @error('mo_ta') is-invalid @enderror" id="mo_ta"
                                        name="mo_ta" rows="3"
                                        placeholder="Nhập mô tả phòng ban...">{{ old('mo_ta', $phongBan->mo_ta) }}</textarea>
                                    @error('mo_ta')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="card mt-4">
                        <div class="card-body d-flex justify-content-between">
                            <a href="{{ route('phongban.index') }}" class="btn btn-secondary">
                                <i class="mdi mdi-arrow-left me-2"></i>Hủy
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save me-2"></i>Cập nhật
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>




@endsection
