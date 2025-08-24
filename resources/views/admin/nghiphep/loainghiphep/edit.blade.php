@extends('layoutsAdmin.master')
@section('title', 'Sửa Loại Nghỉ Phép')

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
                    Cập nhật loại nghỉ phép
                </h5>
            </div>
        </div>
        <div class="card-body">

            <form class="forms-sample ml-5 row g-3" id="leaveTypeForm"
                action="{{ route('hr.loainghiphep.update', $loaiNghiPhep->id) }}" method="POST" class="form-container">
                @csrf
                @method('PUT')

                <div class="form-group col-md-6">
                    <label for="inputPassword4" class="form-label">Tên<span class="required">*</span></label>
                    <input type="text" class="form-control" id="ten" name="ten"
                        value="{{ $loaiNghiPhep->ten }}" placeholder="VD: Nghỉ phép năm">
                    @error('ten')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Giới tính áp dụng<span class="required">*</span></label>
                    <select class="form-select" id="gioi_tinh_ap_dung" name="gioi_tinh_ap_dung"
                        class="{{ $errors->has('gioi_tinh_ap_dung') ? 'error' : '' }} form-control">
                        <option {{ $loaiNghiPhep->ten === 'tat_ca' ? 'selected' : '' }} value="tat_ca">Tất cả
                        </option>
                        <option {{ $loaiNghiPhep->ten === 'nam' ? 'selected' : '' }} value="nam">Nam</option>
                        <option {{ $loaiNghiPhep->ten === 'nu' ? 'selected' : '' }} value="nu">Nữ</option>
                    </select>
                    @error('gioi_tinh_ap_dung')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Số ngày trên năm<span class="required">*</span></label>
                    <input type="number" id="so_ngay_nam" name="so_ngay_nam" value="{{ $loaiNghiPhep->so_ngay_nam }}"
                        min="0" max="365" placeholder="12" class="form-control">
                    @error('so_ngay_nam')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Tối đa ngày liên tiếp<span class="required">*</span></label>
                    <input type="number" id="toi_da_ngay_lien_tiep" name="toi_da_ngay_lien_tiep"
                        value="{{ $loaiNghiPhep->toi_da_ngay_lien_tiep }}" min="0" max="365" placeholder="5"
                        class="form-control">

                    @error('toi_da_ngay_lien_tiep')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Số ngày báo trước<span class="required">*</span></label>
                    <input type="number" id="so_ngay_bao_truoc" name="so_ngay_bao_truoc"
                        value="{{ $loaiNghiPhep->so_ngay_bao_truoc }}" min="0" max="30" placeholder="3"
                        class="form-control">
                    @error('so_ngay_bao_truoc')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Tối đa ngày chuyển</label>
                    <input type="number" id="toi_da_ngay_chuyen" name="toi_da_ngay_chuyen"
                        value="{{ $loaiNghiPhep->toi_da_ngay_chuyen }}" min="0" max="365" placeholder="5"
                        class="form-control">
                    @error('toi_da_ngay_chuyen')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail4" class="form-label">Cho phép chuyển năm</label>
                    <input type="hidden" name="cho_phep_chuyen_nam" value="0">

                    <input type="checkbox" id="cho_phep_chuyen_nam" name="cho_phep_chuyen_nam" value="1"
                        {{ $loaiNghiPhep->cho_phep_chuyen_nam == 1 ? 'checked' : '' }}>
                    @error('cho_phep_chuyen_nam')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail4" class="form-label">Yêu cầu giấy tờ</label>
                    <input type="hidden" name="yeu_cau_giay_to" value="0">

                    <input type="checkbox" id="yeu_cau_giay_to" name="yeu_cau_giay_to" value="1"
                        {{ $loaiNghiPhep->yeu_cau_giay_to == 1 ? 'checked' : '' }}>
                    @error('yeu_cau_giay_to')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail4" class="form-label">Có lương</label>
                    <input type="hidden" name="co_luong" value="0">

                    <input type="checkbox" id="co_luong" name="co_luong" value="1"
                        {{ $loaiNghiPhep->co_luong == 1 ? 'checked' : '' }}>

                    @error('co_luong')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail4" class="form-label">Trạng thái hoạt động</label>
                    <input type="hidden" name="trang_thai" value="0">
                    <input type="checkbox" id="trang_thai" name="trang_thai" value="1"
                        {{ $loaiNghiPhep->trang_thai == 1 ? 'checked' : '' }}>
                    @error('trang_thai')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail4" class="form-label">Nghỉ chế độ</label>
                    <input type="hidden" name="nghi_che_do" value="0">
                    <input type="checkbox" id="nghi_che_do" name="nghi_che_do" value="1"
                        {{ $loaiNghiPhep->nghi_che_do == 1 ? 'checked' : '' }}>
                    @error('nghi_che_do')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail4" class="form-label">Tính theo tỷ lệ</label>
                    <input type="hidden" name="tinh_theo_ty_le" value="0">
                    <input type="checkbox" id="tinh_theo_ty_le" name="tinh_theo_ty_le" value="1"
                        {{ $loaiNghiPhep->tinh_theo_ty_le == 1 ? 'checked' : '' }}>
                    @error('tinh_theo_ty_le')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group col-md-12">
                    <label for="inputEmail4" class="form-label">Mô tả</label>
                    <textarea class="form-textarea" id="mo_ta" name="mo_ta" value="{{ old('mo_ta') }}"
                        placeholder="Mô tả chi tiết về loại nghỉ phép này...">{{ $loaiNghiPhep->mo_ta }}</textarea>

                    @error('mo_ta')
                        <span class="error-message">{{ $message }}</span>
                    @enderror


                </div>

                <button type="submit" class="btn btn-primary me-2">Cập nhật</button>
                <button class="btn btn-light">Hủy</button>
            </form>
        </div>
    </div>

@endsection
