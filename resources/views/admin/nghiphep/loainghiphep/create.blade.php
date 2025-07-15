@extends('layoutsAdmin.master')
@section('title', 'Thêm Loại Nghỉ Phép')

@section('content')
    <style>
        .header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            padding: 20px;
            text-align: center;
            color: white;
        }

        .header h1 {
            font-size: 25px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            font-size: 17px;
            opacity: 0.9;
        }

        .form-container {
            padding: 40px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .form-section {
            background: #f8f9ff;
            padding: 25px;
            border-radius: 15px;
            border-left: 4px solid #4facfe;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: #4facfe;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2d3748;
        }

        .required {
            color: #e53e3e;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #4facfe;
            box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
            transform: translateY(-1px);
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin: 0;
        }

        .skills-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .skill-tag {
            background: #4facfe;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .skill-tag button {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        .add-skill {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .add-skill input {
            flex: 1;
        }

        .add-skill button {
            background: #48bb78;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-skill button:hover {
            background: #38a169;
            transform: translateY(-1px);
        }

        .status-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .status-btn {
            padding: 10px 20px;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-btn.active {
            background: #4facfe;
            color: white;
            border-color: #4facfe;
        }

        .submit-section {
            text-align: center;
            padding: 30px;
            background: #f7fafc;
            margin: 0 -40px -40px -40px;
        }

        .submit-btn {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(79, 172, 254, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(79, 172, 254, 0.4);
        }

        .draft-btn {
            background: #718096;
            margin-right: 15px;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 4px;
        }

        .preview-btn {
            background: #805ad5;
            margin-left: 15px;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 2rem;
            }

            .form-container {
                padding: 20px;
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="container-fluid px-4">
        <div class="col-md-4">
            <h2 class="fw-bold text-primary mb-2">
                Loại nghỉ phép
            </h2>
        </div>

    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">
                    Tạo loại nghỉ phép
                </h5>
            </div>
        </div>
        <div class="card-body">

            <form class="forms-sample ml-5 row g-3" id="leaveTypeForm" action="{{ route('hr.loainghiphep.store') }}"
                method="POST" class="form-container" onsubmit="return validateForm(event)">
                @csrf

                <div class="form-group col-md-4">
                    <label for="inputEmail4" class="form-label">Mã LNP<span class="required">*</span></label>
                    <input type="text" class="form-control" id="ma" name="ma" value="{{ old('ma') }}"
                        placeholder="VD: NPN" maxlength="10">
                    @error('ma')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4" class="form-label">Tên<span class="required">*</span></label>
                    <input type="text" class="form-control" id="ten" name="ten" value="{{ old('ten') }}"
                        placeholder="VD: Nghỉ phép năm">
                    @error('ten')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="exampleInputEmail1">Giới tính áp dụng<span class="required">*</span></label>
                    <select class="form-select" id="gioi_tinh_ap_dung" name="gioi_tinh_ap_dung"
                        class="{{ $errors->has('gioi_tinh_ap_dung') ? 'error' : '' }} form-control">
                        <option value="">Chọn Giới tính áp dụng</option>
                        <option value="tat_ca" {{ old('gioi_tinh_ap_dung') == 'tat_ca' ? 'selected' : '' }}>Tất cả
                        </option>
                        <option value="nam" {{ old('gioi_tinh_ap_dung') == 'nam' ? 'selected' : '' }}>Nam
                        </option>
                        <option value="nu" {{ old('gioi_tinh_ap_dung') == 'nu' ? 'selected' : '' }}>Nữ
                        </option>
                    </select>
                    @error('gioi_tinh_ap_dung')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail4" class="form-label">Số ngày trên năm<span class="required">*</span></label>
                    <input type="number" id="so_ngay_nam" name="so_ngay_nam" value="{{ old('so_ngay_nam') }}"
                        placeholder="12" class="form-control">
                    @error('so_ngay_nam')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail4" class="form-label">Tối đa ngày liên tiếp<span class="required">*</span></label>
                    <input type="number" id="toi_da_ngay_lien_tiep" name="toi_da_ngay_lien_tiep"
                        value="{{ old('toi_da_ngay_lien_tiep') }}" placeholder="5" value="{{ old('ma') }}"
                        class="form-control">
                    <span id="error_toi_da_ngay_lien_tiep" class="error-message text-danger" style="display:none;"></span>

                    @error('toi_da_ngay_lien_tiep')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail4" class="form-label">Số ngày báo trước<span class="required">*</span></label>
                    <input type="number" id="so_ngay_bao_truoc" name="so_ngay_bao_truoc"
                        value="{{ old('so_ngay_bao_truoc') }}" min="0" max="30" placeholder="3"
                        class="form-control">
                    @error('so_ngay_bao_truoc')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                {{-- 
                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Cho phép chuyển năm</label>
                    <input type="hidden" name="cho_phep_chuyen_nam" value="0">

                    <input type="checkbox" id="cho_phep_chuyen_nam" name="cho_phep_chuyen_nam" value="1"
                        {{ old('cho_phep_chuyen_nam') ? 'checked' : '' }}>
                    @error('cho_phep_chuyen_nam')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                    <input type="hidden" name="cho_phep_chuyen_nam" value="0">

                </div> --}}

                <div class="form-group col-md-3">
                    <label class="form-label">Cho phép chuyển năm</label>
                    <input type="hidden" name="cho_phep_chuyen_nam" value="0">
                    <input type="checkbox" id="cho_phep_chuyen_nam" name="cho_phep_chuyen_nam" value="1"
                        {{ old('cho_phep_chuyen_nam') ? 'checked' : '' }}>
                    @error('cho_phep_chuyen_nam')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Yêu cầu giấy tờ</label>
                    <input type="hidden" name="yeu_cau_giay_to" value="0">

                    <input type="checkbox" id="yeu_cau_giay_to" name="yeu_cau_giay_to" value="1"
                        {{ old('yeu_cau_giay_to') ? 'checked' : '' }}>
                    @error('yeu_cau_giay_to')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                    <input type="hidden" name="yeu_cau_giay_to" value="0">

                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Có lương</label>
                    <input type="hidden" name="co_luong" value="0">

                    <input type="checkbox" id="co_luong" name="co_luong" value="1"
                        {{ old('co_luong') ? 'checked' : '' }}>

                    @error('co_luong')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Trạng thái hoạt động</label>
                    <input type="hidden" name="trang_thai" value="0">
                    <input type="checkbox" id="trang_thai" name="trang_thai" value="1"
                        {{ old('trang_thai') ? 'checked' : '' }}>
                    @error('trang_thai')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group col-md-3" id="group_toi_da_ngay_chuyen" style="display: none;">
                    <label class="form-label">Tối đa ngày chuyển</label>
                    <input type="number" id="toi_da_ngay_chuyen" name="toi_da_ngay_chuyen"
                        value="{{ old('toi_da_ngay_chuyen') }}" min="0" max="365" placeholder="5"
                        class="form-control">
                    @error('toi_da_ngay_chuyen')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-12">
                    <label for="inputEmail4" class="form-label">Mô tả</label>
                    <textarea class="form-textarea" id="mo_ta" name="mo_ta" value="{{ old('mo_ta') }}"
                        placeholder="Mô tả chi tiết về loại nghỉ phép này..."></textarea>

                    @error('mo_ta')
                        <span class="error-message">{{ $message }}</span>
                    @enderror


                </div>

                <button type="submit" class="btn btn-primary me-2">Thêm mới</button>
                <button class="btn btn-light">Hủy</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('cho_phep_chuyen_nam');
            const groupInput = document.getElementById('group_toi_da_ngay_chuyen');
            const form = document.getElementById('leaveTypeForm');
            const soNgayNamInput = document.getElementById('so_ngay_nam');
            const toiDaNgayInput = document.getElementById('toi_da_ngay_lien_tiep');
            const errorElement = document.getElementById('error_toi_da_ngay_lien_tiep');

            form.addEventListener('submit', function(e) {
                const soNgayNam = parseInt(soNgayNamInput.value);
                const toiDaNgay = parseInt(toiDaNgayInput.value);

                // Reset lỗi
                errorElement.style.display = 'none';
                errorElement.textContent = '';

                // Kiểm tra nếu cả hai ô đều có giá trị hợp lệ
                if (!isNaN(soNgayNam) && !isNaN(toiDaNgay)) {
                    if (toiDaNgay > soNgayNam) {
                        e.preventDefault();
                        errorElement.textContent =
                            'Tối đa ngày liên tiếp phải nhỏ hơn hoặc bằng số ngày trên năm.';
                        errorElement.style.display = 'block';
                        toiDaNgayInput.focus();
                    }
                }
            });

            function toggleInput() {
                groupInput.style.display = checkbox.checked ? 'block' : 'none';
            }

            // Gọi ngay lúc load để đảm bảo đúng trạng thái khi old('cho_phep_chuyen_nam') có giá trị
            toggleInput();

            checkbox.addEventListener('change', toggleInput);
        });
    </script>


@endsection
