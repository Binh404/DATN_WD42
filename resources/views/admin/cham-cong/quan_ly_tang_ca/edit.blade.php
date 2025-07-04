@extends('layoutsAdmin.master')

@section('title', 'Chỉnh sửa chấm công')

@section('style')

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Chỉnh sửa chấm công tăng ca</h2>
                {{-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.chamcong.index') }}">Chấm công</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa</li>
                    </ol>
                </nav> --}}
                <p class="mb-0 opacity-75">Chỉnh sửa thông tin bản ghi chấm công tăng ca</p>

            </div>
            <div>
                <a href="{{ route('admin.chamcong.tangCa.show', $thucHienTangCa->id) }}" class="btn btn-light">
                    <i class="mdi mdi-arrow-left me-2"></i>Quay lại
                </a>
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
            <!-- Thông tin nhân viên -->
                <div class="col-md-4 mb-4">
                    <div class="card stat-card h-120">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="mdi mdi-account me-2"></i>Thông tin nhân viên</h5>
                        </div>
                        <div class="card-body text-center">
                            @php
                                $avatar = $thucHienTangCa->dangKyTangCa->nguoiDung->hoSo->anh_dai_dien
                                    ? asset($dangKyTangCa->dangKyTangCa->nguoiDung->hoSo->anh_dai_dien)
                                    : asset('assets/images/default.png');
                            @endphp
                            <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle border border-3 border-primary mb-3"
                                width="100" height="100"
                                onerror="this.onerror=null; this.src='{{ asset('assets/images/default.png') }}';">

                            <h5 class="card-title mb-3">
                                {{ $dangKyTangCa->dangKyTangCa->nguoiDung->hoSo->ho ?? 'N/A' }}
                                {{ $thucHienTangCa->dangKyTangCa->nguoiDung->hoSo->ten ?? 'N/A' }}
                            </h5>

                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <div class="fw-bold">{{ $thucHienTangCa->dangKyTangCa->nguoiDung->hoSo->ma_nhan_vien ?? 'N/A' }}</div>
                                        <small class="opacity-75">Mã NV</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="fw-bold">{{ $thucHienTangCa->dangKyTangCa->nguoiDung->phongBan->ten_phong_ban ?? 'N/A' }}</div>
                                    <small class="opacity-75">Phòng ban</small>
                                </div>
                            </div>

                            <hr class="border-light opacity-75">
                            <div class="small">
                                <i class="mdi mdi-phone me-2"></i>{{ $thucHienTangCa->dangKyTangCa->nguoiDung->hoSo->so_dien_thoai ?? 'N/A' }}
                            </div>
                            <div class="small">
                                <i class="mdi mdi-email me-2"></i>{{ $thucHienTangCa->dangKyTangCa->nguoiDung->email }}
                            </div>

                        </div>
                    </div>

                    <div class="card stat-card h-120 mt-2">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="mdi mdi-calendar me-2"></i>Thông tin chi tiết</h5>
                        </div>
                        <div class="card-body">
                            <!-- Thông tin tính toán -->
                            <div class="mb-3 p-2  bg-body-secondary rounded">
                                <h6 class="mb-2"><i class="mdi mdi-file-document-outline me-2"></i>Thông tin đơn đăng ký</h6>
                                <div><strong>Giờ bắt đầu:</strong> <span id="soGioLam">{{ $thucHienTangCa->dangKyTangCa->gio_bat_dau->format('H:i') }} h</span></div>
                                <div><strong>Giờ kết thúc:</strong> <span id="soGioLam">{{ $thucHienTangCa->dangKyTangCa->gio_ket_thuc->format('H:i') }} h</span></div>
                                <div><strong>Số giờ làm:</strong> <span id="soGioLam">{{ number_format($thucHienTangCa->dangKyTangCa->so_gio_tang_ca, 1) }} h</span></div>
                                <div><strong>Loại tăng ca:</strong> <span id="soCong">{{ $thucHienTangCa->dangKyTangCa->loai_tang_ca_text }}</span></div>
                            </div>

                            <!-- Thông tin audit -->
                            <div class="mb-3 p-2  bg-body-secondary rounded">
                                <h6 class="mb-2"><i class="mdi mdi-history me-2"></i>Thông tin cập nhật</h6>
                                <div><strong>Tạo lúc:</strong> {{ $thucHienTangCa->created_at->format('d/m/Y H:i') }}</div>
                                <div><strong>Cập nhật:</strong> {{ $thucHienTangCa->updated_at->format('d/m/Y H:i') }}</div>
                            </div>

                            <!-- Hướng dẫn -->
                            <div class="mb-3 p-2 rounded " style="background-color: rgba(13, 202, 240, 0.25);">
                                <h6><i class="mdi mdi-lightbulb me-2"></i>Lưu ý:</h6>
                                <ul class="mb-0 small">
                                    <li>Phải làm đủ giời mới được là hoàn thành</li>
                                    <li>Số công được tính dựa trên số giờ làm thực tế</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Form chỉnh sửa -->
            <div class="col-md-8">
                <form method="POST" action="{{ route('admin.chamcong.tangCa.update', $thucHienTangCa->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="nguoi_dung_id" id="" value="{{ $thucHienTangCa->nguoi_dung_id }}">
                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            <h5 class="mb-0"><i class="mdi mdi-pencil me-2"></i>Thông tin chấm công</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Nhân viên -->

                                <div class="col-md-6 mb-3">
                                    <label for="nguoi_dung_id" class="form-label">
                                        <i class="mdi mdi-calendar text-primary me-2"></i>Nhân viên
                                    </label>
                                    <input type="text"
                                           class="form-control @error('nguoi_dung_id') is-invalid @enderror"
                                           id="nguoi_dung_id"
                                           name="nguoi_dung_id"
                                           value="{{ $thucHienTangCa->dangKyTangCa->nguoiDung->hoSo->ho ?? '' }} {{ $thucHienTangCa->dangKyTangCa->nguoiDung->hoSo->ten ?? '' }}"
                                           readonly>
                                     <!-- input hidden giữ giá trị id để gửi lên server -->
                                    <input type="hidden" name="nguoi_dung_id" value="{{ $thucHienTangCa->dangKyTangCa->nguoi_dung_id }}">
                                    @error('nguoi_dung_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Trạng thái -->
                                <div class="col-md-6 mb-3">
                                    <label for="trang_thai" class="form-label">
                                        <i class="mdi mdi-flag text-primary me-2"></i>Trạng thái
                                    </label>
                                    <select class="form-select @error('trang_thai') is-invalid @enderror"
                                            id="trang_thai"
                                            name="trang_thai"
                                            >
                                        @foreach($trangThaiList as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ old('trang_thai', $thucHienTangCa->trang_thai) == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('trang_thai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Giờ vào -->
                                <div class="col-md-6 mb-3">
                                    <label for="gio_vao" class="form-label">
                                        <i class="mdi mdi-clock-in text-success me-2"></i>Giờ vào
                                    </label>
                                    <input type="time"
                                           class="form-control time-input @error('gio_vao') is-invalid @enderror"
                                           id="gio_vao"
                                           name="gio_vao"
                                           value="{{ old('gio_vao', optional($thucHienTangCa->gio_bat_dau_thuc_te ? \Carbon\Carbon::parse($thucHienTangCa->gio_bat_dau_thuc_te) : null)->format('H:i')) }}"
                                           step="60">
                                    @error('gio_vao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Giờ ra -->
                                <div class="col-md-6 mb-3">
                                    <label for="gio_ra" class="form-label">
                                        <i class="mdi mdi-clock-out text-danger me-2"></i>Giờ ra
                                    </label>
                                    <input type="time"
                                           class="form-control time-input @error('gio_ra') is-invalid @enderror"
                                           id="gio_ra"
                                           name="gio_ra"
                                           value="{{ old('gio_ra', optional($thucHienTangCa->gio_ket_thuc_thuc_te ? \Carbon\Carbon::parse($thucHienTangCa->gio_ket_thuc_thuc_te) : null)->format('H:i')) }}"
                                           step="60">
                                    @error('gio_ra')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Ghi chú -->
                                <div class="col-12 mb-3">
                                    <label for="ghi_chu" class="form-label">
                                        <i class="mdi mdi-note-text text-secondary me-2"></i>Ghi chú
                                    </label>
                                    <textarea class="form-control @error('ghi_chu') is-invalid @enderror"
                                              id="ghi_chu"
                                              name="ghi_chu"
                                              rows="3"
                                              placeholder="Nhập ghi chú (tùy chọn)">{{ old('ghi_chu', $thucHienTangCa->ghi_chu) }}</textarea>
                                    @error('ghi_chu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <!-- Thông tin tính toán -->
                    <div class="card mt-4 calculation-card">
                        <div class="card-body">
                            <h6 class="card-title mb-3">
                                <i class="mdi mdi-calculator text-primary me-2"></i>Tính toán tự động
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <div class="fw-bold text-primary" id="calculated-hours">0.0</div>
                                        <small class="text-muted">Giờ làm (tự động)</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <div class="fw-bold text-success" id="calculated-work">0.0</div>
                                        <small class="text-muted">Công (tự động)</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <div class="fw-bold text-info" id="status-preview">-</div>
                                        <small class="text-muted">Trạng thái dự kiến</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Buttons -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.chamcong.tangCa.index') }}" class="btn btn-secondary">
                                    <i class="mdi mdi-arrow-left me-2"></i>Hủy
                                </a>
                                <div>
                                    <button type="button" class="btn btn-info me-2" onclick="autoCalculate()">
                                        <i class="mdi mdi-calculator me-2"></i>Tính toán tự động
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="mdi mdi-content-save me-2"></i>Cập nhật
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

</script>
@endsection
