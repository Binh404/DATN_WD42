@extends('layoutsAdmin.master')
@section('title', 'Tạo Yêu Cầu Tuyển Dụng')

@section('content')

    <div class="container-fluid px-4">
        <div class="col-md-4">
            <h2 class="fw-bold text-primary mb-2">
                Yêu cầu tuyển dụng
            </h2>
        </div>

    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">
                    Tạo đơn
                </h5>
            </div>
        </div>
        <div class="card-body">
            <form class="forms-sample ml-5 row g-3" id="recruitmentForm"
                action="{{ route('department.yeucautuyendung.store') }}" method="POST"
                onsubmit="return validateForm(event)">
                @csrf

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Mã yêu cầu<span class="required">*</span></label>
                    <input type="text" id="ma" name="ma" placeholder="VD: YC001" value="{{ old('ma') }}"
                        class="form-control">
                    @error('ma')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="inputPassword4" class="form-label">Số lượng cần tuyển<span class="required">*</span></label>
                    <input type="text" id="so_luong" name="so_luong" value="{{ old('so_luong') }}" class="form-control">
                    @error('so_luong')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Chức vụ<span class="required">*</span></label>
                    <select class="form-select" id="chuc_vu_id" name="chuc_vu_id">
                        <option value="">-- Chọn Chức Vụ --</option>
                        @foreach ($chucVus as $chucVu)
                            <option value="{{ $chucVu->id }}" {{ old('chuc_vu_id') == $chucVu->id ? 'selected' : '' }}>
                                {{ $chucVu->ten }}</option>
                        @endforeach
                    </select>
                    @error('chuc_vu_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="inputPassword4" class="form-label">Loại hợp đồng<span class="required">*</span></label>
                    <select class="form-select" id="loai_hop_dong" name="loai_hop_dong">
                        <option value="">-- Chọn Loại Hợp Đồng --</option>
                        <option value="thu_viec" {{ old('loai_hop_dong') == 'thu_viec' ? 'selected' : '' }}>Thử Việc
                        </option>
                        <option value="xac_dinh_thoi_han"
                            {{ old('loai_hop_dong') == 'xac_dinh_thoi_han' ? 'selected' : '' }}>Xác Định Thời Hạn</option>
                        <option value="khong_xac_dinh_thoi_han"
                            {{ old('loai_hop_dong') == 'khong_xac_dinh_thoi_han' ? 'selected' : '' }}>Không Xác Định Thời
                            Hạn</option>

                    </select>
                    @error('loai_hop_dong')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Lương tối thiểu<span class="required">*</span></label>
                    <input type="number" id="luong_toi_thieu" name="luong_toi_thieu" value="{{ old('luong_toi_thieu') }}"
                        min="0" class="form-control">
                    @error('luong_toi_thieu')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>
                <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Lương tối đa<span class="required">*</span></label>
                    <input type="number" id="luong_toi_da" name="luong_toi_da" value="{{ old('luong_toi_da') }}"
                        min="0" class="form-control">
                    @error('luong_toi_da')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Kinh nghiệm tối thiểu<span class="required">*</span></label>
                    <input type="number" id="kinh_nghiem_toi_thieu" name="kinh_nghiem_toi_thieu"
                        value="{{ old('kinh_nghiem_toi_thieu') }}" min="0" class="form-control">
                    @error('kinh_nghiem_toi_thieu')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>
                <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Kinh nghiệm tối đa<span class="required">*</span></label>
                    <input type="number" id="kinh_nghiem_toi_da" name="kinh_nghiem_toi_da"
                        value="{{ old('kinh_nghiem_toi_da') }}" min="0" class="form-control">
                    @error('kinh_nghiem_toi_da')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="inputPassword4" class="form-label">Trình độ học vấn<span class="required">*</span></label>
                    <select class="form-select" id="trinh_do_hoc_van" name="trinh_do_hoc_van">
                        <option value="">-- Chọn học vấn --</option>
                        <option value="Trung cấp" {{ old('trinh_do_hoc_van') == 'Trung cấp' ? 'selected' : '' }}>Trung cấp
                        </option>
                        <option value="Cao đẳng" {{ old('trinh_do_hoc_van') == 'Cao đẳng' ? 'selected' : '' }}>Cao đẳng
                        </option>
                        <option value="Đại học" {{ old('trinh_do_hoc_van') == 'Đại học' ? 'selected' : '' }}>Đại học
                        </option>
                    </select>
                    @error('trinh_do_hoc_van')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Yêu cầu ứng viên<span class="required">*</span></label>
                    <textarea class="form-control" id="yeu_cau" name="yeu_cau" value="{{ old('yeu_cau') }}" cols="30"
                        rows="30">1</textarea>
                    @error('yeu_cau')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="inputEmail4" class="form-label">Kỹ năng yêu cầu<span class="required">*</span></label>
                    <input type="text" class="form-control" id="ky_nang_yeu_cau" name="ky_nang_yeu_cau"
                        value="{{ old('ky_nang_yeu_cau') }}">
                    @error('ky_nang_yeu_cau')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Ghi chú</label>
                    <input type="texty" class="form-control" id="ghi_chu" name="ghi_chu"
                        value="{{ old('ghi_chu') }}">
                    @error('ghi_chu')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="inputEmail4" class="form-label">Mô tả công việc<span class="required">*</span></label>
                    <textarea id="mo_ta_cong_viec" name="mo_ta_cong_viec" value="{{ old('mo_ta_cong_viec') }}" class="form-control"
                        cols="30" rows="30"></textarea>
                    @error('mo_ta_cong_viec')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary me-2">Tạo yêu cầu</button>
                <button class="btn btn-light">Hủy</button>
            </form>
        </div>
    </div>


    <script>
        function validateForm(event) {
            const ma = document.getElementById('ma').value.trim();
            const soLuong = document.getElementById('so_luong').value.trim();
            const chucVu = document.getElementById('chuc_vu_id').value.trim();
            const loaiHopDong = document.getElementById('loai_hop_dong').value.trim();
            const trinhDoHocVan = document.getElementById('trinh_do_hoc_van').value.trim();
            const luongToiThieu = document.getElementById('luong_toi_thieu').value.trim();
            const luongToiDa = document.getElementById('luong_toi_da').value.trim();
            const kinhNghiemToiThieu = document.getElementById('kinh_nghiem_toi_thieu').value.trim();
            const kinhNghiemToiDa = document.getElementById('kinh_nghiem_toi_da').value.trim();
            const moTa = document.getElementById('mo_ta_cong_viec').value.trim();
            const yeuCau = document.getElementById('yeu_cau').value.trim();
            const kyNangYeuCau = document.getElementById('ky_nang_yeu_cau').value.trim();

            // Xóa lỗi cũ
            document.querySelectorAll('.validation-error').forEach(e => e.remove());
            document.querySelectorAll('input, select, textarea').forEach(field => {
                field.style.border = '';
            });

            let isValid = true;

            // Validate mã (bắt buộc, ít nhất 3 ký tự)
            if (ma === '') {
                showValidationError('ma', 'Mã yêu cầu không được để trống');
                isValid = false;
            } else if (ma.length < 3) {
                showValidationError('ma', 'Mã yêu cầu phải có ít nhất 3 ký tự');
                isValid = false;
            }

            // Validate số lượng (bắt buộc, số nguyên > 0)
            if (soLuong === '') {
                showValidationError('so_luong', 'Số lượng không được để trống');
                isValid = false;
            } else if (isNaN(soLuong) || parseInt(soLuong) <= 0) {
                showValidationError('so_luong', 'Số lượng phải là số nguyên lớn hơn 0');
                isValid = false;
            }

            // Validate loại hợp đồng (bắt buộc)
            if (loaiHopDong === '') {
                showValidationError('loai_hop_dong', 'Vui lòng chọn loại hợp đồng');
                isValid = false;
            }

            if (chucVu === '') {
                showValidationError('chuc_vu_id', 'Vui lòng chọn chức vụ');
                isValid = false;
            }

            if (trinhDoHocVan === '') {
                showValidationError('trinh_do_hoc_van', 'Vui lòng chọn trình độ học vấn');
                isValid = false;
            }

            // Validate lương (nếu có nhập thì phải hợp lệ)
            if (luongToiThieu !== '' && (isNaN(luongToiThieu) || parseFloat(luongToiThieu) < 0)) {
                showValidationError('luong_toi_thieu', 'Lương tối thiểu phải là số không âm');
                isValid = false;
            } else if (luongToiThieu === '') {
                showValidationError('luong_toi_thieu', 'Vui lòng điền lương tối thiểu');
                isValid = false;
            }

            if (luongToiDa !== '' && (isNaN(luongToiDa) || parseFloat(luongToiDa) < 0)) {
                showValidationError('luong_toi_da', 'Lương tối đa phải là số không âm');
                isValid = false;
            } else if (luongToiDa === '') {
                showValidationError('luong_toi_thieu', 'Vui lòng điền lương tối đa');
                isValid = false;
            }

            // Validate range lương (nếu cả 2 đều có giá trị)
            if (luongToiThieu !== '' && luongToiDa !== '' &&
                !isNaN(luongToiThieu) && !isNaN(luongToiDa) &&
                parseFloat(luongToiThieu) >= parseFloat(luongToiDa)) {
                showValidationError('luong_toi_da', 'Lương tối đa phải lớn hơn lương tối thiểu');
                isValid = false;
            }

            // Validate kinh nghiệm (nếu có nhập thì phải hợp lệ)
            if (kinhNghiemToiThieu !== '' && (isNaN(kinhNghiemToiThieu) || parseFloat(kinhNghiemToiThieu) < 0)) {
                showValidationError('kinh_nghiem_toi_thieu', 'Kinh nghiệm tối thiểu phải là số không âm');
                isValid = false;
            } else if (kinhNghiemToiThieu === '') {
                showValidationError('kinh_nghiem_toi_thieu', 'Vui lòng điền kinh nghiệm tối thiểu');
                isValid = false;
            }

            if (kinhNghiemToiDa !== '' && (isNaN(kinhNghiemToiDa) || parseFloat(kinhNghiemToiDa) < 0)) {
                showValidationError('kinh_nghiem_toi_da', 'Kinh nghiệm tối đa phải là số không âm');
                isValid = false;
            } else if (kinhNghiemToiDa === '') {
                showValidationError('kinh_nghiem_toi_da', 'Vui lòng điền kinh nghiệm tối đa');
                isValid = false;
            }

            // Validate range kinh nghiệm (nếu cả 2 đều có giá trị)
            if (kinhNghiemToiThieu !== '' && kinhNghiemToiDa !== '' &&
                !isNaN(kinhNghiemToiThieu) && !isNaN(kinhNghiemToiDa) &&
                parseFloat(kinhNghiemToiThieu) >= parseFloat(kinhNghiemToiDa)) {
                showValidationError('kinh_nghiem_toi_da', 'Kinh nghiệm tối đa phải lớn hơn kinh nghiệm tối thiểu');
                isValid = false;
            }

            if (moTa === '') {
                showValidationError('mo_ta_cong_viec', 'Vui lòng điền mô tả công việc');
                isValid = false;
            }

            if (yeuCau === '') {
                showValidationError('yeu_cau', 'Vui lòng điền yêu cầu');
                isValid = false;
            }

            if (kyNangYeuCau === '') {
                showValidationError('ky_nang_yeu_cau', 'Vui lòng điền kỹ năng yêu cầu');
                isValid = false;
            }

            // Scroll to first error if any
            if (!isValid) {
                event.preventDefault();
                const firstError = document.querySelector('.validation-error');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }

            return isValid;
        }

        function showValidationError(fieldId, message) {
            const field = document.getElementById(fieldId);
            if (!field) return;

            const error = document.createElement('div');
            error.className = 'validation-error';
            error.style.color = '#dc3545';
            error.style.fontSize = '0.875rem';
            error.style.marginTop = '0.25rem';
            error.style.display = 'block';
            error.textContent = message;

            field.parentNode.appendChild(error);
            field.style.border = '1px solid #dc3545';
        }

        // Thêm event listener để xóa lỗi khi user nhập lại
        document.addEventListener('DOMContentLoaded', function() {
            const fields = ['ma', 'so_luong', 'chuc_vu_id', 'loai_hop_dong', 'trinh_do_hoc_van',
                'luong_toi_thieu', 'luong_toi_da', 'kinh_nghiem_toi_thieu', 'kinh_nghiem_toi_da',
                'mo_ta_cong_viec', 'yeu_cau', 'ky_nang_yeu_cau'
            ];

            fields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.addEventListener('input', function() {
                        // Xóa lỗi của field hiện tại
                        const error = this.parentNode.querySelector('.validation-error');
                        if (error) {
                            error.remove();
                            this.style.border = '';
                        }
                    });
                }
            });
        });
    </script>

    <style>
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 4px;
        }

        .header {
            background-color: rgb(56, 160, 212);
            color: white;
            padding: 10px;
            text-align: center;
        }

        .required {
            color: #e74c3c;
        }
    </style>
@endsection
