@extends('layoutsAdmin.master')

<style>
    select#trang_thai {
        color: black;
    }
    select#vai_tro_id {
        color: black;
    }
    select#phong_ban_id {
        color: black;
    }
    select#chuc_vu_id {
        color: black;
    }
</style>
@section('content')
            <div class="row">
                <div class="col-12">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="fw-bold mb-1">Chỉnh sửa tài khoản</h2>
                            {{-- <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.chamcong.index') }}">tài khoản</a></li>
                                    <li class="breadcrumb-item active">Chỉnh sửa</li>
                                </ol>
                            </nav> --}}
                            <p class="mb-0 opacity-75">Chỉnh sửa thông tin bản ghi tài khoản</p>

                        </div>
                        <div>
                            <a href="{{ route('tkall') }}" class="btn btn-light">
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
$avatar = optional($taikhoan->hoSo)->anh_dai_dien
    ? asset($taikhoan->hoSo->anh_dai_dien)
    : asset('assets/images/default.png');
                                    @endphp

                                    <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle border border-3 border-primary mb-3"
                                        width="100" height="100"
                                        onerror="this.onerror=null; this.src='{{ asset('assets/images/default.png') }}';">

                                    <h5 class="card-title mb-3">
                                        {{ $taikhoan->hoSo->ho ?? 'N/A' }}
                                        {{ $taikhoan->hoSo->ten ?? 'N/A' }}
                                    </h5>

                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="border-end">
                                                <div class="fw-bold">{{ $taikhoan->hoSo->ma_nhan_vien ?? 'N/A' }}</div>
                                                <small class="opacity-75">Mã NV</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="fw-bold">{{ $taikhoan->phongBan->ten_phong_ban ?? 'N/A' }}</div>
                                            <small class="opacity-75">Phòng ban</small>
                                        </div>
                                    </div>

                                    <hr class="border-light opacity-75">
                                    <div class="small">
                                        <i class="mdi mdi-phone me-2"></i>{{ $taikhoan->hoSo->so_dien_thoai ?? 'N/A' }}
                                    </div>
                                    <div class="small">
                                        <i class="mdi mdi-email me-2"></i>{{ $taikhoan->email }}
                                    </div>

                                </div>
                            </div>


                        </div>

                        <!-- Form chỉnh sửa -->
                        <div class="col-md-8">
                            <form action="{{ route('tkupdate', $taikhoan->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                 <div class="card">
                                    <div class="card-header bg-warning text-white">
                                        <h5 class="mb-0"><i class="mdi mdi-pencil me-2"></i>Thông tin tài khoản</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="ten_dang_nhap" class="form-label fw-bold">Tên đăng nhập</label>
                                        <input type="text" name="ten_dang_nhap" id="ten_dang_nhap" class="form-control"
                                            value="{{ $taikhoan->ten_dang_nhap ?? null}}" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label fw-bold">Email</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            value="{{ $taikhoan->email ?? null}}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="trang_thai" class="form-label fw-bold">Trạng thái</label>
                                        <select name="trang_thai" id="trang_thai" class="form-select" required>
                                            <option value="1" {{ $taikhoan->trang_thai == 1 ? 'selected' : '' }}>Hoạt động</option>
                                            <option value="0" {{ $taikhoan->trang_thai == 0 ? 'selected' : '' }}>Ngưng hoạt động
                                            </option>
                                        </select>
                                    </div>

                                    {{-- <div class="col-md-6 mb-3">
                                        <label for="trang_thai_cong_viec" class="form-label fw-bold">Trạng thái công việc</label>
                                        <select name="trang_thai_cong_viec" id="trang_thai_cong_viec" class="form-select" required>
                                            <option value="dang_lam" {{ $taikhoan->trang_thai_cong_viec == 'dang_lam' ? 'selected' : '' }}>Đang
                                                làm</option>
                                            <option value="da_nghi" {{ $taikhoan->trang_thai_cong_viec == 'da_nghi' ? 'selected' : '' }}>Đã nghỉ
                                            </option>
                                        </select>
                                    </div> --}}

                                    <div class="col-md-6 mb-3">
                                        <label for="vai_tro_id" class="form-label fw-bold">Quyền</label>
                                        <select name="vai_tro_id" id="vai_tro_id" class="form-select" required>
                                            <option value="">-- Chọn vai trò --</option>
                                            @foreach ($ds_vaitro as $vaitro)
                                                <option value="{{ $vaitro->id }}" {{ $taikhoan->vai_tro_id == $vaitro->id ? 'selected' : '' }}>
                                                    {{ $vaitro->ten }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phong_ban_id" class="form-label fw-bold">Phòng ban</label>
                                    <select name="phong_ban_id" id="phong_ban_id" class="form-select" required>
                                        <option value="">-- Chọn phòng ban --</option>
                                        @foreach ($ds_phongban as $phongban)
                                            <option value="{{ $phongban->id }}" {{ $taikhoan->phong_ban_id == $phongban->id ? 'selected' : '' }}>
                                                {{ $phongban->ten_phong_ban }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="chuc_vu_id" class="form-label fw-bold">Chức vụ</label>
                                    <select name="chuc_vu_id" id="chuc_vu_id" class="form-select" required>
                                        <option value="">-- Chọn chức vụ --</option>
                                        @foreach ($ds_chucvu as $chucvu)
                                            <option value="{{ $chucvu->id }}" {{ $taikhoan->chuc_vu_id == $chucvu->id ? 'selected' : '' }}>
                                                {{ $chucvu->ten }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                </div>
                                    </div>
                                </div>




                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary me-2">Cập nhật</button>
                                    {{-- <a href="{{ route('tkall') }}" class="btn btn-secondary">Quay lại</a> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const phongBanSelect = document.getElementById('phong_ban_id');
        const chucVuSelect = document.getElementById('chuc_vu_id');

        const oldPhongBanId = "{{ old('phong_ban_id', $taikhoan->phong_ban_id ?? '') }}";
        const oldChucVuId = "{{ old('chuc_vu_id', $taikhoan->chuc_vu_id ?? '') }}";

        if (oldPhongBanId) {
            loadChucVu(oldPhongBanId, oldChucVuId);
        }

        phongBanSelect.addEventListener('change', function () {
            const phongBanId = this.value;
            loadChucVu(phongBanId);
        });

        function loadChucVu(phongBanId, selectedId = null) {
            chucVuSelect.innerHTML = '<option value="" disabled selected>-- Đang tải... --</option>';
            chucVuSelect.disabled = true;

            if (phongBanId) {
                fetch(`/chuc-vus/${phongBanId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        chucVuSelect.innerHTML = '<option value="">-- Chọn chức vụ --</option>';

                        data.forEach(chucVu => {
                            const option = document.createElement('option');
                            option.value = chucVu.id;
                            option.textContent = chucVu.ten;

                            if (selectedId && selectedId == chucVu.id) {
                                option.selected = true;
                            }

                            chucVuSelect.appendChild(option);
                        });

                        chucVuSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Lỗi khi tải danh sách chức vụ:', error);
                        chucVuSelect.innerHTML = '<option value="" disabled selected>-- Lỗi tải dữ liệu --</option>';
                        chucVuSelect.disabled = false;
                        alert('Có lỗi xảy ra khi tải danh sách chức vụ. Vui lòng thử lại!');
                    });
            } else {
                chucVuSelect.innerHTML = '<option value="">-- Chọn chức vụ --</option>';
                chucVuSelect.disabled = false;
            }
        }
    });
</script>
