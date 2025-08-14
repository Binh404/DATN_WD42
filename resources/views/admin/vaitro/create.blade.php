@extends('layoutsAdmin.master')
@section('title', 'Tạo vai trò')

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
                            <h2 class="fw-bold mb-1">Thêm Vai trò</h2>
                        </div>

                    </div>
                </div>
                <div class="card register-card mt-4">


                    <div class="card-body">
                        <form method="POST" action="{{ route('vaitro.store') }}">
                            @csrf
                            {{-- Tên vai trò --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-2"></i>Tên vai trò
                                </label>
                                <input type="text"
                                id="name"
                                name="name" {{-- ✅ Spatie yêu cầu key này --}}
                                value="{{ old('name') }}"
                                class="form-control"
                                placeholder="Nhập tên vai trò"
                                required>

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- Tên hiển thị --}}
                            <div class="mb-3">
                                <label for="ten_hien_thi" class="form-label">
                                    <i class="fas fa-user me-2"></i>Tên hiển thị
                                </label>
                                <input type="text"
                                        id="ten_hien_thi"
                                        name="ten_hien_thi"
                                        value="{{ old('ten_hien_thi') }}"
                                        class="form-control @error('ten_hien_thi') is-invalid @enderror"
                                        placeholder="Nhập tên hiển thị"
                                        required
                                        autofocus>
                                @error('ten_hien_thi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- Mô tả --}}
                            <div class="mb-3">
                                <label for="mo_ta" class="form-label">
                                    <i class="fas fa-info-circle me-2"></i>Mô tả
                                </label>
                                <textarea id="mo_ta"
                                          name="mo_ta"
                                          class="form-control @error('mo_ta') is-invalid @enderror"
                                          placeholder="Nhập mô tả"
                                          required>{{ old('mo_ta') }}</textarea>
                                @error('mo_ta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Buttons --}}
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <a href="{{ route('vaitro.index') }}" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-user-plus me-2"></i>Lưu
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
