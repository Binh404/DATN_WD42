@extends('layoutsAdmin.master')
@section('title', 'Đăng ký tài khoản')

@section('content')

        <style>
            select#vai_tro_id {
            color: black;
        }
        select#phong_ban_id {
            color: black
        }
        select#chuc_vu_id {
            color: black
        }
        </style>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">Thêm tài khoản người dùng</h2>
                            <p class="mb-0 opacity-75">Thêm bản ghi tài khoản</p>
                        </div>

                    </div>
                </div>
                <div class="card register-card mt-4">


                    <div class="card-body">
                        <form method="POST" action="{{ route('register.store') }}">
                            @csrf
                            {{-- Tên đăng nhập --}}
                            <div class="mb-3">
                                <label for="ten_dang_nhap" class="form-label">
                                    <i class="fas fa-user me-2"></i>Họ và tên
                                </label>
                                <input type="text"
                                        id="ten_dang_nhap"
                                        name="ten_dang_nhap"
                                        value="{{ old('ten_dang_nhap') }}"
                                        class="form-control @error('ten_dang_nhap') is-invalid @enderror"
                                        placeholder="Nhập họ và tên"
                                        required
                                        autofocus>
                                @error('ten_dang_nhap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </label>
                                <input type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Nhập địa chỉ email"
                                        required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Mật khẩu --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Mật khẩu
                                </label>
                                <input type="password"
                                        id="password"
                                        name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Nhập mật khẩu"
                                        required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Xác nhận mật khẩu --}}
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Xác nhận mật khẩu
                                </label>
                                <input type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        class="form-control"
                                        placeholder="Nhập lại mật khẩu"
                                        required>
                            </div>

                            <div class="row">
                                {{-- Vai trò --}}
                                <div class="col-md-4 mb-3">
                                    <label for="vai_tro_id" class="form-label">
                                        <i class="fas fa-user-tag me-2"></i>Quyền
                                    </label>
                                    <select name="vai_tro_id"
                                            id="vai_tro_id"
                                            class="form-select"
                                            required>
                                        <option value="" disabled selected>-- Chọn quyền --</option>
                                        @foreach ($vaitro as $vaitros)
                                            <option value="{{ $vaitros->id }}" {{ old('vai_tro_id') == $vaitros->id ? 'selected' : '' }}>
                                                {{ $vaitros->ten }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vai_tro_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Phòng ban --}}
                                <div class="col-md-4 mb-3">
                                    <label for="phong_ban_id" class="form-label">
                                        <i class="fas fa-building me-2"></i>Phòng ban
                                    </label>
                                    <select name="phong_ban_id"
                                            id="phong_ban_id"
                                            class="form-select"
                                            required>
                                        <option value="" disabled selected>-- Chọn phòng ban --</option>
                                        @foreach ($phongban as $phongBan)
                                            <option value="{{ $phongBan->id }}" {{ old('phong_ban_id') == $phongBan->id ? 'selected' : '' }}>
                                                {{ $phongBan->ten_phong_ban }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('phong_ban_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Chức vụ --}}
                                <div class="col-md-4 mb-3">
                                    <label for="chuc_vu_id" class="form-label">
                                        <i class="fas fa-id-badge me-2"></i>Chức vụ
                                    </label>
                                    <select name="chuc_vu_id"
                                            id="chuc_vu_id"
                                            class="form-select"
                                            required>
                                        <option value="" disabled selected>-- Chọn chức vụ --</option>
                                        {{-- Chức vụ sẽ được load tự động bằng JavaScript --}}
                                    </select>
                                    @error('chuc_vu_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Buttons --}}
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <a href="{{ route('tkall') }}" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-user-plus me-2"></i>Đăng ký
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        {{-- Script xử lý chức vụ theo phòng ban --}}
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const phongBanSelect = document.getElementById('phong_ban_id');
            const chucVuSelect = document.getElementById('chuc_vu_id');

            // Khôi phục chức vụ nếu có old data
            const oldPhongBanId = "{{ old('phong_ban_id') }}";
            const oldChucVuId = "{{ old('chuc_vu_id') }}";

            if (oldPhongBanId) {
                loadChucVu(oldPhongBanId, oldChucVuId);
            }

            phongBanSelect.addEventListener('change', function() {
                const phongBanId = this.value;
                loadChucVu(phongBanId);
            });

            function loadChucVu(phongBanId, selectedId = null) {
                // Reset chức vụ select
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
                            chucVuSelect.innerHTML = '<option value="" disabled selected>-- Chọn chức vụ --</option>';

                            data.forEach(chucVu => {
                                const option = document.createElement('option');
                                option.value = chucVu.id;
                                option.textContent = chucVu.ten;

                                // Khôi phục selected nếu có
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

                            // Hiển thị thông báo lỗi cho người dùng
                            alert('Có lỗi xảy ra khi tải danh sách chức vụ. Vui lòng thử lại!');
                        });
                } else {
                    chucVuSelect.innerHTML = '<option value="" disabled selected>-- Chọn chức vụ --</option>';
                    chucVuSelect.disabled = false;
                }
            }
        });
        </script>

@endsection
