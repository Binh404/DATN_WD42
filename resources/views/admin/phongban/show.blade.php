@extends('layoutsAdmin.master')

@section('content')

    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="info-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-1">Chi tiết phòng ban</h2>
                        <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi phòng ban</p>

                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('phongban.index') }}" class="btn btn-light">
                            <i class="mdi mdi-arrow-left me-1"></i> Quay lại
                        </a>
                        <a href="{{ route('phongban.edit', $phongBan->id) }}" class="btn btn-warning text-white">
                            <i class="mdi mdi-pencil me-1"></i> Chỉnh sửa
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
                <!-- Thông Chi tiết phòng ban -->
                <div class="col-lg-12 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-3">
                        <div class="card-header bg-primary text-white py-3 px-4">
                            <h4 class="mb-0 d-flex align-items-center">
                                <i class="mdi mdi-office-building me-2"></i>Chi tiết phòng ban
                            </h4>
                        </div>
                        {{-- <div class="card-body text-center p-4 ">
                            @php
                            $avatar = $chamCong->nguoiDung->hoSo->anh_dai_dien
                            ? asset($chamCong->nguoiDung->hoSo->anh_dai_dien)
                            : asset('assets/images/default.png');
                            @endphp

                            <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle border border-3 border-primary mb-3"
                                width="120" height="120"
                                onerror="this.onerror=null; this.src='{{ asset('assets/images/default.png') }}';"
                                style="object-fit: cover;">

                            <h4 class="fw-bold text-primary mb-3">
                                {{ $chamCong->nguoiDung->hoSo->ho ?? 'N/A' }} {{ $chamCong->nguoiDung->hoSo->ten ?? 'N/A' }}
                            </h4>

                            <div class="text-start">
                                <div
                                    class="detail-row d-flex justify-content-between align-items-center p-2 rounded hover-bg-light transition">
                                    <strong class="text-dark"><i class="mdi mdi-badge-account me-2 text-primary"></i>Mã nhân
                                        viên:</strong>
                                    <span class="badge bg-primary rounded-pill px-2 py-1">{{
                                        $chamCong->nguoiDung->hoSo->ma_nhan_vien ?? 'N/A' }}</span>
                                </div>
                                <div
                                    class="detail-row d-flex justify-content-between align-items-center p-2 rounded hover-bg-light transition">
                                    <strong class="text-dark"><i class="mdi mdi-email me-2 text-primary"></i>Email:</strong>
                                    <span class="badge bg-primary rounded-pill px-2 py-1">{{ $chamCong->nguoiDung->email
                                        }}</span>
                                </div>
                                <div
                                    class="detail-row d-flex justify-content-between align-items-center p-2 rounded hover-bg-light transition">
                                    <strong class="text-dark"><i class="mdi mdi-office-building me-2 text-primary"></i>Phòng
                                        ban:</strong>
                                    <span class="badge bg-primary rounded-pill px-2 py-1">{{
                                        $chamCong->nguoiDung->phongBan->ten_phong_ban ?? 'N/A' }}</span>
                                </div>
                                <div
                                    class="detail-row d-flex justify-content-between align-items-center p-2 rounded hover-bg-light transition">
                                    <strong class="text-dark"><i class="mdi mdi-phone me-2 text-primary"></i>Số điện
                                        thoại:</strong>
                                    <span class="badge bg-primary rounded-pill px-2 py-1">{{
                                        $chamCong->nguoiDung->hoSo->so_dien_thoai ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div> --}}
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <tbody>
                                        <tr>
                                            <th class="text-muted fw-semibold">
                                                <i class="fas fa-code me-2"></i>Mã phòng ban
                                            </th>
                                            <td>
                                                <span class="badge bg-light text-dark border px-3 py-2">
                                                    {{ $phongBan->ma_phong_ban }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted fw-semibold" style="width: 30%;">
                                                <i class="fas fa-tag me-2"></i>Tên phòng ban
                                            </th>
                                            <td class="fw-bold text-dark">{{ $phongBan->ten_phong_ban }}</td>
                                        </tr>

                                        <tr>
                                            <th class="text-muted fw-semibold">
                                                <i class="fas fa-file-alt me-2"></i>Mô tả
                                            </th>
                                            <td>{{ $phongBan->mo_ta ?: 'Chưa có mô tả' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted fw-semibold">
                                                <i class="fas fa-power-off me-2"></i>Trạng thái
                                            </th>
                                            <td>
                                                @if ($phongBan->trang_thai == 1)
                                                    <span class="badge bg-success px-3 py-2 fs-6">
                                                        <i class="fas fa-check-circle me-1"></i>Hoạt động
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger px-3 py-2 fs-6">
                                                        <i class="fas fa-times-circle me-1"></i>Ngừng hoạt động
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted fw-semibold">
                                                <i class="fas fa-calendar-plus me-2"></i>Ngày tạo
                                            </th>
                                            <td>
                                                @if($phongBan->created_at)
                                                    <span class="text-info">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ date('d/m/Y H:i:s', strtotime($phongBan->created_at)) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">Chưa xác định</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted fw-semibold">
                                                <i class="fas fa-calendar-check me-2"></i>Ngày cập nhật
                                            </th>
                                            <td>
                                                @if($phongBan->updated_at)
                                                    <span class="text-warning">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ date('d/m/Y H:i:s', strtotime($phongBan->updated_at)) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">Chưa cập nhật</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="row">
                <div class="col-12">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center gap-3">
                                <a href="{{ route('phongban.index') }}" class="btn btn-secondary">
                                    <i class="mdi mdi-arrow-left me-1"></i> Quay lại danh sách
                                </a>
                                <a href="{{ route('phongban.edit', $phongBan->id) }}" class="btn btn-warning">
                                    <i class="mdi mdi-pencil me-1"></i> Chỉnh sửa
                                </a>

                                <button class="btn btn-info" onclick="window.print()">
                                    <i class="mdi mdi-printer me-1"></i> In
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
