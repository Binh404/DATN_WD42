@extends('layouts.master')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title text-primary mb-4">Thông tin ứng viên</h3>
            
            <div class="row">
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
                        <a href="/ungvien" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </a>
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
            <div class="modal-body p-0">
                @php
                    $extension = pathinfo(storage_path('app/public/' . $ungVien->tai_cv), PATHINFO_EXTENSION);
                @endphp

                @if(in_array(strtolower($extension), ['pdf', 'doc', 'docx']))
                    <div class="cv-container">
                        @if(strtolower($extension) === 'pdf')
                            <iframe 
                                src="{{ asset('storage/' . $ungVien->tai_cv) }}" 
                                width="100%" 
                                height="100%" 
                                class="border-0"
                                style="height: 80vh;">
                            </iframe>
                        @else
                            <div class="alert alert-info m-3">
                                <i class="fas fa-info-circle me-2"></i>
                                File CV là định dạng {{ strtoupper($extension) }}. 
                                <a href="{{ asset('storage/' . $ungVien->tai_cv) }}" 
                                   class="btn btn-primary btn-sm ms-3" 
                                   target="_blank">
                                    <i class="fas fa-download me-2"></i>Tải xuống
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="alert alert-warning m-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Định dạng file không được hỗ trợ
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <!-- <a href="{{ asset('storage/' . $ungVien->tai_cv) }}" class="btn btn-primary" target="_blank">
                    <i class="fas fa-download me-2"></i>Tải xuống
                </a> -->
            </div>
        </div>
    </div>
</div>
@endif

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
    font-weight: bold;
}

.modal-xl {
    max-width: 90%;
}

@media (max-width: 992px) {
    .modal-fullscreen-lg-down {
        max-width: 100%;
        margin: 0;
    }
    
    .modal-fullscreen-lg-down .modal-content {
        height: 100vh;
        border: 0;
        border-radius: 0;
    }
}
</style>
@endsection