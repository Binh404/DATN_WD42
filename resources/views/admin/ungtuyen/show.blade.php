@extends('layouts.master')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title text-primary mb-4">Thông tin ứng viên</h3>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-muted fw-bold">Mã ứng viên</label>
                    <p class="form-control-plaintext">{{ $ungVien->ma_ung_tuyen }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-muted fw-bold">Tên ứng viên</label>
                    <p class="form-control-plaintext">{{ $ungVien->ten_ung_vien }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-muted fw-bold">Email</label>
                    <p class="form-control-plaintext">{{ $ungVien->email }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-muted fw-bold">Số điện thoại</label>
                    <p class="form-control-plaintext">{{ $ungVien->so_dien_thoai }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-muted fw-bold">Kinh nghiệm</label>
                    <p class="form-control-plaintext">{{ $ungVien->kinh_nghiem }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-muted fw-bold">Kỹ năng</label>
                    <p class="form-control-plaintext">{{ $ungVien->ky_nang }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-muted fw-bold">Vị trí ứng tuyển</label>
                    <p class="form-control-plaintext">{{ $ungVien->tinTuyenDung->tieu_de }}</p>
                </div>

                <div class="col-12 mb-3">
                    <label class="text-muted fw-bold">Thư giới thiệu</label>
                    <p class="form-control-plaintext">{{ $ungVien->thu_gioi_thieu }}</p>
                </div>

                <div class="col-12">
                    <div class="d-flex gap-2">
                        <!-- <a href="/ungvien" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </a> -->
                        @if($ungVien->tai_cv)
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cvModal">
                            <i class="fas fa-file-alt me-2"></i>Xem CV
                        </button>
                        @else
                        <button type="button" class="btn btn-primary" disabled>
                            <i class="fas fa-file-alt me-2"></i>Chưa có CV
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(request('from') !== 'trung-tuyen' && request('from') !== 'phong-van')
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title">Đánh giá ứng viên</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('ungvien.luudiemdanhgia', $ungVien->id) }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="diem_phong_van">Điều chỉnh điểm đánh giá (nếu cần)</label>
                    <input type="number" class="form-control" id="diem_danh_gia" name="diem_danh_gia"
                        min="0" max="100" step="1" value="{{ old('diem_danh_gia', $ungVien->diem_danh_gia) }}" required>
                    <small class="text-muted">Nhập điểm từ 0 đến 100</small>
                </div>
                <div class="form-group mb-3">
                    <label for="ghi_chu_phong_van">Ghi chú đánh giá bổ sung</label>
                    <textarea class="form-control" id="ghi_chu_phong_van" name="ghi_chu_phong_van"
                        rows="3">{{ old('ghi_chu_danh_gia_cv', $ungVien->ghi_chu_danh_gia_cv) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật đánh giá</button>
            </form>
        </div>
    </div>
    @endif
</div>

<!-- Modal hiển thị CV -->
@if($ungVien->tai_cv)
<div class="modal fade" id="cvModal" tabindex="-1" aria-labelledby="cvModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cvModalLabel">
                    <i class="fas fa-file-alt me-2"></i>CV của {{ $ungVien->ten_ung_vien }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @php
            $cvPath = storage_path('app/public/' . $ungVien->tai_cv);
            $extension = pathinfo($cvPath, PATHINFO_EXTENSION);
            $publicPath = asset('storage/' . $ungVien->tai_cv);
            @endphp
            <div class="modal-body p-0">
                @if(file_exists($cvPath) && in_array(strtolower($extension), ['pdf', 'doc', 'docx']))
                <div class="cv-container">
                    @if(strtolower($extension) === 'pdf')
                    <iframe
                        src="{{ $publicPath }}"
                        width="100%"
                        height="100%"
                        class="border-0"
                        style="height: 80vh;">
                    </iframe>
                    @else
                    <div class="alert alert-info m-3">
                        <i class="fas fa-info-circle me-2"></i>
                        File CV là định dạng {{ strtoupper($extension) }}.
                        <a href="{{ $publicPath }}"
                            class="btn btn-primary btn-sm ms-3"
                            download>
                            <i class="fas fa-download me-2"></i>Tải xuống
                        </a>
                    </div>
                    @endif
                </div>
                @else
                <div class="alert alert-warning m-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Không thể tải file CV. File không tồn tại hoặc định dạng không được hỗ trợ.
                    @if(!file_exists($cvPath))
                    <br>Lỗi: File không tồn tại tại đường dẫn chỉ định.
                    @endif
                    @if(!in_array(strtolower($extension), ['pdf', 'doc', 'docx']))
                    <br>Lỗi: Định dạng file không được hỗ trợ ({{ $extension }}).
                    @endif
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                @if(file_exists($cvPath))
                <a href="{{ $publicPath }}" class="btn btn-primary" download>
                    <i class="fas fa-download me-2"></i>Tải xuống
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

<style>
    .modal-xl {
        max-width: 90%;
    }

    .cv-container {
        min-height: 600px;
        background: #f8f9fa;
    }

    @media (max-width: 992px) {
        .modal-fullscreen-lg-down {
            max-width: 100%;
            margin: 0;
        }

        .modal-fullscreen-lg-down .modal-content {
            min-height: 100vh;
            border: 0;
            border-radius: 0;
        }
    }
</style>

<style>
    .form-control-plaintext {
        font-size: 1rem;
        padding: 0.5rem;
        background-color: #f8f9fa;
        border-radius: 0.25rem;
        margin-top: 0.25rem;
    }

    .card {
        border: none;
        border-radius: 0.5rem;
    }

    .card-title {
        font-size: 1.25rem;
    }
</style>
@endsection