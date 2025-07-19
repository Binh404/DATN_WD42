@extends('layoutsAdmin.master')

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
                Đơn xin nghỉ phép
            </h2>
        </div>

    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">
                    Tạo đơn nghỉ phép
                </h5>
            </div>
        </div>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="card-body">

            <form class="forms-sample ml-5 row g-3" id="leaveRequestForm" action="{{ route('nghiphep.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Loại nghỉ phép<span class="required">*</span></label>
                    <select class="form-select" id="loai_nghi_phep_id" name="loai_nghi_phep_id">
                        <option value="">Chọn loại nghỉ phép</option>
                        @foreach ($soDus as $key => $soDu)
                            <option value="{{ $soDu->loaiNghiPhep->id }}">{{ $soDu->loaiNghiPhep->ten }}</option>
                        @endforeach

                    </select>
                    @error('loai_nghi_phep_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Ngày bắt đầu<span class="required">*</span></label>
                    <input class="form-control" type="date" id="ngay_bat_dau" name="ngay_bat_dau">
                    @error('ngay_bat_dau')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputPassword4" class="form-label">Ngày kết thúc<span class="required">*</span></label>
                    <input class="form-control" type="date" id="ngay_ket_thuc" name="ngay_ket_thuc">
                    @error('ngay_ket_thuc')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputPassword4" class="form-label">Tài liệu hỗ trợ<span class="required">*</span></label>
                    <input type="file" id="tai_lieu_ho_tro" name="tai_lieu_ho_tro[]" multiple
                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="form-control">
                    @error('tai_lieu_ho_tro')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                    <div id="fileList" class="file-list"></div>
                </div>



                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Người liên hệ khẩn cấp<span
                            class="required">*</span></label>
                    <input type="text" id="lien_he_khan_cap" name="lien_he_khan_cap" placeholder="Họ tên người liên hệ"
                        class="form-control">
                    @error('lien_he_khan_cap')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Số điện thoại khẩn cấp<span
                            class="required">*</span></label>
                    <input type="tel" id="sdt_khan_cap" name="sdt_khan_cap" placeholder="0901234567"
                        value="{{ old('sdt_khan_cap') }}" class="form-control">

                    @error('sdt_khan_cap')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Bàn giao cho<span class="required">*</span></label>
                    <select class="form-select" id="ban_giao_cho_id" name="ban_giao_cho_id">
                        <option value="">Chọn người ban giao</option>
                        @foreach ($nguoiBanGiaos as $key => $nguoiBanGiao)
                            <option value="{{ $nguoiBanGiao->id }}">{{ $nguoiBanGiao->ten_dang_nhap }}</option>
                        @endforeach

                    </select>
                    @error('ban_giao_cho_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group col-md-3">
                    <label class="form-label">Ghi chú bàn giao</label>
                    <input type="text" id="ghi_chu_ban_giao" name="ghi_chu_ban_giao"
                        placeholder="Mô tả chi tiết công việc cần bàn giao, lưu ý đặc biệt...">
                    @error('ghi_chu_ban_giao')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-12">
                    <label for="inputEmail4" class="form-label">Lý do</label>
                    <textarea class="form-textarea" id="ly_do" name="ly_do" required placeholder="Mô tả chi tiết lý do xin nghỉ..."
                        value="{{ old('ly_do') }}"></textarea>
                    @error('ly_do')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary me-2">Tạo đơn</button>
                <button class="btn btn-light">Hủy</button>
            </form>
        </div>
    </div>

    <script>
        // Validate ngày kết thúc >= ngày bắt đầu
        document.getElementById('ngay_bat_dau').addEventListener('change', function() {
            const startDate = this.value;
            const endDateInput = document.getElementById('ngay_ket_thuc');
            endDateInput.min = startDate;

            if (endDateInput.value && endDateInput.value < startDate) {
                endDateInput.value = startDate;
            }
        });

        // Reset form
        function resetForm() {
            document.getElementById('leaveRequestForm').reset();
            document.getElementById('fileList').innerHTML = '';
        }

        // hiển thị file đã chọn
        document.getElementById('tai_lieu_ho_tro').addEventListener('change', function(e) {
            const fileList = document.getElementById('fileList');
            fileList.innerHTML = '';

            Array.from(e.target.files).forEach((file, index) => {
                const fileItem = document.createElement('div');
                fileItem.className = 'file-item';
                fileItem.innerHTML = `
                    <span>📄 ${file.name} (${(file.size / 1024).toFixed(1)} KB)</span>
                    <button type="button" class="remove-file" onclick="removeFile(${index})">×</button>
                `;
                fileList.appendChild(fileItem);
            });
        });

        // remove file
        function removeFile(index) {
            const fileInput = document.getElementById('tai_lieu_ho_tro');
            const dt = new DataTransfer();

            Array.from(fileInput.files).forEach((file, i) => {
                if (i !== index) dt.items.add(file);
            });

            fileInput.files = dt.files;
            fileInput.dispatchEvent(new Event('change'));
        }

        // Set ngày tối thiểu là hôm nay
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('ngay_bat_dau').min = today;
        document.getElementById('ngay_ket_thuc').min = today;
    </script>
@endsection
