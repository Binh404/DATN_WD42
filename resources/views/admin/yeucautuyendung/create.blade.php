@extends('layouts.master')
@section('title', 'Tạo Yêu Cầu Tuyển Dụng')

@section('content')

    <div class="container">
        <div class="header">
            <h1>Tạo Yêu Cầu Tuyển Dụng</h1>
        </div>

        <div class="form-container">
            <form id="recruitmentForm" action="{{ route('department.yeucautuyendung.store') }}" method="POST"
                onsubmit="return validateForm(event)">
                @csrf
                <div class="section-title">Thông Tin Cơ Bản</div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="ma">Mã Yêu Cầu <span class="required">*</span></label>
                        <input type="text" id="ma" name="ma" placeholder="VD: YC001">
                        @error('ma')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="so_luong">Số Lượng Cần Tuyển <span class="required">*</span></label>
                        <input type="text" id="so_luong" name="so_luong" placeholder="1">
                        @error('so_luong')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>



                    <div class="form-group">
                        <label for="chuc_vu_id">Chức Vụ</label>
                        <select id="chuc_vu_id" name="chuc_vu_id">
                            <option value="">-- Chọn Chức Vụ --</option>
                            @foreach ($chucVus as $chucVu)
                                <option value="{{ $chucVu->id }}">{{ $chucVu->ten }}</option>
                            @endforeach
                        </select>
                        @error('chuc_vu_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="loai_hop_dong">Loại Hợp Đồng <span class="required">*</span></label>
                        <select id="loai_hop_dong" name="loai_hop_dong">
                            <option value="">-- Chọn Loại Hợp Đồng --</option>
                            <option value="thu_viec">Thử Việc</option>
                            <option value="xac_dinh_thoi_han">Xác Định Thời Hạn</option>
                            <option value="khong_xac_dinh_thoi_han">Không Xác Định Thời Hạn</option>
                        </select>
                        @error('loai_hop_dong')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="trinh_do_hoc_van">Trình Độ Học Vấn</label>
                        <select id="trinh_do_hoc_van" name="trinh_do_hoc_van">
                            <option value="">-- Chọn Trình Độ --</option>
                            <option value="Trung cấp">Trung cấp</option>
                            <option value="Cao đẳng">Cao đẳng</option>
                            <option value="Đại học">Đại học</option>
                        </select>
                        @error('trinh_do_hoc_van')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="section-title">Mức Lương & Kinh Nghiệm</div>

                <div class="card">
                    <div class="form-group">
                        <label>Mức Lương (VNĐ)</label>
                        <div class="salary-range">
                            <input type="number" id="luong_toi_thieu" name="luong_toi_thieu" placeholder="Lương tối thiểu"
                                min="0">

                            <span>đến</span>
                            <input type="number" id="luong_toi_da" name="luong_toi_da" placeholder="Lương tối đa"
                                min="0">

                        </div>
                        @error('luong_toi_thieu')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        @error('luong_toi_da')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Kinh Nghiệm (năm)</label>
                        <div class="experience-range">
                            <input type="number" id="kinh_nghiem_toi_thieu" name="kinh_nghiem_toi_thieu"
                                placeholder="Tối thiểu" min="0">

                            <span>đến</span>
                            <input type="number" id="kinh_nghiem_toi_da" name="kinh_nghiem_toi_da" placeholder="Tối đa"
                                min="0">

                        </div>
                        @error('kinh_nghiem_toi_thieu')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        @error('kinh_nghiem_toi_da')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="section-title">Mô Tả Chi Tiết</div>

                <div class="form-group full-width">
                    <label for="mo_ta_cong_viec">Mô Tả Công Việc</label>
                    <textarea id="mo_ta_cong_viec" name="mo_ta_cong_viec"
                        placeholder="Mô tả chi tiết về công việc, trách nhiệm và quyền hạn..."></textarea>
                    @error('mo_ta_cong_viec')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="yeu_cau">Yêu Cầu Ứng Viên</label>
                    <textarea id="yeu_cau" name="yeu_cau" placeholder="Các yêu cầu về trình độ, kinh nghiệm, kỹ năng..."></textarea>
                    @error('yeu_cau')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="ky_nang_yeu_cau">Kỹ Năng Yêu Cầu</label>
                    <textarea id="ky_nang_yeu_cau" name="ky_nang_yeu_cau" placeholder="Các kỹ năng chuyên môn, kỹ năng mềm cần thiết..."></textarea>
                    @error('ky_nang_yeu_cau')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="ghi_chu">Ghi Chú</label>
                    <textarea id="ghi_chu" name="ghi_chu" placeholder="Các thông tin bổ sung khác..."></textarea>
                    @error('ghi_chu')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="btn-container">
                    <button type="button" class="btn btn-secondary">Hủy Bỏ</button>
                    <button type="submit" class="btn btn-primary">Tạo Yêu Cầu</button>
                </div>
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
            }else if(luongToiThieu === ''){
                showValidationError('luong_toi_thieu', 'Vui lòng điền lương tối thiểu');
                isValid = false;
            }

            if (luongToiDa !== '' && (isNaN(luongToiDa) || parseFloat(luongToiDa) < 0)) {
                showValidationError('luong_toi_da', 'Lương tối đa phải là số không âm');
                isValid = false;
            }else if(luongToiDa === ''){
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
            }else if(kinhNghiemToiThieu === ''){
                showValidationError('kinh_nghiem_toi_thieu', 'Vui lòng điền kinh nghiệm tối thiểu');
                isValid = false;
            }

            if (kinhNghiemToiDa !== '' && (isNaN(kinhNghiemToiDa) || parseFloat(kinhNghiemToiDa) < 0)) {
                showValidationError('kinh_nghiem_toi_da', 'Kinh nghiệm tối đa phải là số không âm');
                isValid = false;
            }else if(kinhNghiemToiDa === ''){
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
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

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

        .header h1 {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .form-container {
            padding: 40px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 12px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .salary-range {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 15px;
            align-items: center;
        }

        .salary-range span {
            text-align: center;
            font-weight: 600;
            color: #667eea;
        }

        .experience-range {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 15px;
            align-items: center;
        }

        .experience-range span {
            text-align: center;
            font-weight: 600;
            color: #667eea;
        }

        .section-title {
            font-size: 19px;
            font-weight: 600;
            color: #333;
            margin: 40px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #e1e5e9;
        }

        .section-title:first-child {
            margin-top: 0;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #e1e5e9;
        }

        .btn {
            padding: 15px 40px;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-primary {

            background-color: #667eea
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #dd0d0d;
            border: 2px solid #e1e5e9;
        }

        .btn-secondary:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        .required {
            color: #e74c3c;
        }

        .card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid #e1e5e9;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .salary-range,
            .experience-range {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .salary-range span,
            .experience-range span {
                display: none;
            }

            .container {
                margin: 10px;
            }

            .form-container {
                padding: 20px;
            }

            .header {
                padding: 20px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .btn-container {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 1.2rem;
        }
    </style>
@endsection
