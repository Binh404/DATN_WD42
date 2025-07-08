@extends('layoutsEmploye.master')

@section('content-employee')
    <style>
        .containerr {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 4px;
        }

        .headerr {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .headerr h1 {
            font-size: 2rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .headerr p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .form-container {
            padding: 40px;
        }

        .form-grid {
            display: grid;
            gap: 25px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
        }

        .required {
            color: #e74c3c;
        }

        input[type="text"],
        input[type="date"],
        input[type="tel"],
        select,
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e8ed;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fafbfc;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #4facfe;
            background: white;
            box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
        }

        select {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 40px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .file-upload {
            position: relative;
            display: inline-block;
            cursor: pointer;
            width: 100%;
        }

        .file-upload input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-upload-label {
            display: block;
            padding: 12px 15px;
            border: 2px dashed #cbd5e0;
            border-radius: 10px;
            text-align: center;
            background: #f7fafc;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-upload-label:hover {
            border-color: #4facfe;
            background: #edf8ff;
        }

        .file-upload-label i {
            font-size: 1.5rem;
            color: #4facfe;
            margin-bottom: 8px;
            display: block;
        }

        .file-list {
            margin-top: 10px;
        }

        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            background: #f1f5f9;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .file-item span {
            font-size: 0.9rem;
            color: #475569;
        }

        .remove-file {
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            font-size: 0.8rem;
        }

        .emergency-contact {
            background: #fff7ed;
            border: 2px solid #fed7aa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .emergency-contact h3 {
            color: #ea580c;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .handover-section {
            background: #f0f9ff;
            border: 2px solid #bae6fd;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .handover-section h3 {
            color: #0369a1;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .btnn-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            justify-content: center;
        }

        .btnn {
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btnn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btnn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .btnn-secondary {
            background: #6b7280;
            color: white;
        }

        .btnn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
        }

        .auto-generate {
            display: inline-flex;
            align-items: center;
            background: #10b981;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            cursor: pointer;
            margin-left: 10px;
            transition: background 0.3s ease;
        }

        .auto-generate:hover {
            background: #059669;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .container {
                margin: 10px;
                border-radius: 15px;
            }

            .headerr {
                padding: 20px;
            }

            .form-container {
                padding: 20px;
            }
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #10b981;
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transform: translateX(400px);
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .notification.show {
            transform: translateX(0);
        }
    </style>

    <div class="containerr">
        <div class="headerr">
            <h1>🏢 Đơn Xin Nghỉ Phép</h1>
            <p>Điền thông tin chi tiết để tạo đơn xin nghỉ</p>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="form-container">
            <form id="leaveRequestForm" action="{{ route('nghiphep.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-grid">
                    <!-- Mã đơn nghỉ -->
                    <div class="form-group">
                        <label for="ma_don_nghi">Mã đơn nghỉ <span class="required">*</span></label>
                        <div style="display: flex; align-items: center;">
                            <input type="text" id="ma_don_nghi" name="ma_don_nghi" required placeholder="VD: DN001-2024">
                            @error('ma_don_nghi')
                                <span class="error-message">{{ $message }}</span>
                            @enderror

                        </div>
                    </div>

                    <!-- Loại nghỉ phép -->
                    <div class="form-group">
                        <label for="loai_nghi_phep_id">Loại nghỉ phép <span class="required">*</span></label>
                        <select id="loai_nghi_phep_id" name="loai_nghi_phep_id" required>
                            <option value="">-- Chọn loại nghỉ --</option>
                            @foreach ($soDus as $key => $soDu)
                                <option value="{{ $soDu->loaiNghiPhep->id }}">{{ $soDu->loaiNghiPhep->ten }}</option>
                            @endforeach

                        </select>
                        @error('loai_nghi_phep_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Thời gian nghỉ -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ngay_bat_dau">Ngày bắt đầu <span class="required">*</span></label>
                            <input type="date" id="ngay_bat_dau" name="ngay_bat_dau" required>
                            @error('ngay_bat_dau')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="ngay_ket_thuc">Ngày kết thúc <span class="required">*</span></label>
                            <input type="date" id="ngay_ket_thuc" name="ngay_ket_thuc" required>
                            @error('ngay_ket_thuc')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Lý do nghỉ -->
                    <div class="form-group full-width">
                        <label for="ly_do">Lý do nghỉ <span class="required">*</span></label>
                        <textarea id="ly_do" name="ly_do" required placeholder="Mô tả chi tiết lý do xin nghỉ..."></textarea>
                        @error('ly_do')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tài liệu hỗ trợ -->
                    <div class="form-group full-width">
                        <label for="tai_lieu_ho_tro">Tài liệu hỗ trợ</label>
                        <div class="file-upload">
                            <input type="file" id="tai_lieu_ho_tro" name="tai_lieu_ho_tro[]" multiple
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <label for="tai_lieu_ho_tro" class="file-upload-label">
                                <i>📎</i>
                                <div>Nhấp để chọn tệp hoặc kéo thả tệp vào đây</div>
                                <small style="color: #6b7280;">Hỗ trợ: PDF, DOC, DOCX, JPG, PNG</small>
                            </label>
                            @error('tai_lieu_ho_tro')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div id="fileList" class="file-list"></div>
                    </div>
                </div>

                <!-- Thông tin liên hệ khẩn cấp -->
                <div class="emergency-contact">
                    <h3>📞 Thông tin liên hệ khẩn cấp</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="lien_he_khan_cap">Người liên hệ khẩn cấp</label>
                            <input type="text" id="lien_he_khan_cap" name="lien_he_khan_cap"
                                placeholder="Họ tên người liên hệ">
                            @error('lien_he_khan_cap')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="sdt_khan_cap">Số điện thoại khẩn cấp</label>
                            <input type="tel" id="sdt_khan_cap" name="sdt_khan_cap" placeholder="0901234567">
                            @error('sdt_khan_cap')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Thông tin bàn giao công việc -->
                <div class="handover-section">
                    <h3>🤝 Thông tin bàn giao công việc</h3>
                    <div class="form-group">
                        <label for="ban_giao_cho_id">Bàn giao cho</label>
                        <select id="ban_giao_cho_id" name="ban_giao_cho_id">
                            <option value="">-- Chọn người nhận bàn giao --</option>
                            @foreach ($nguoiBanGiaos as $key => $nguoiBanGiao)
                                <option value="{{ $nguoiBanGiao->id }}">{{ $nguoiBanGiao->ten_dang_nhap }}</option>
                            @endforeach


                        </select>
                        @error('ban_giao_cho_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="ghi_chu_ban_giao">Ghi chú bàn giao</label>
                        <textarea id="ghi_chu_ban_giao" name="ghi_chu_ban_giao"
                            placeholder="Mô tả chi tiết công việc cần bàn giao, lưu ý đặc biệt..."></textarea>
                        @error('ghi_chu_ban_giao')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="btnn-group">
                    <button type="button" class="btnn btnn-secondary" onclick="resetForm()">🔄 Làm mới</button>
                    <button type="submit" class="btnn btnn-primary">📝 Gửi đơn xin nghỉ</button>
                </div>
            </form>
        </div>
    </div>

    <div id="notification" class="notification">
        Đơn xin nghỉ đã được gửi thành công! ✅
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
