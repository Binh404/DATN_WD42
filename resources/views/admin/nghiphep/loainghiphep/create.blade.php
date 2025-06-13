@extends('layouts.master')
@section('title', 'Thêm Loại Nghỉ Phép')

@section('content')
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .header h1 {
            font-size: 2.2em;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .header p {
            opacity: 0.9;
            font-size: 1.1em;
        }

        .form-container {
            padding: 40px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 0.95em;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 9px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fafbfc;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #4facfe;
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 172, 254, 0.2);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 5px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: #4facfe;
        }

        .color-input {
            width: 60px;
            height: 50px;
            border-radius: 12px;
            border: 2px solid #e1e5e9;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .color-input:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(79, 172, 254, 0.4);
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #6c757d;
            border: 2px solid #e9ecef;
        }

        .btn-secondary:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        .required {
            color: #e74c3c;
        }

        .form-section {
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 1px solid #f0f0f0;
        }

        .form-section:last-child {
            border-bottom: none;
        }

        .section-title {
            font-size: 1.3em;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-icon {
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .container {
                margin: 10px;
                border-radius: 15px;
            }
            
            .form-container {
                padding: 20px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 1.8em;
            }
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            display: none;
        }
    </style>

    <div class="container">
        <div class="header">
            <h1>🏖️ Thêm Loại Nghỉ Phép</h1>
            <p>Cấu hình loại nghỉ phép mới cho hệ thống</p>
        </div>

        <div class="form-container">
            <div class="success-message" id="successMessage">
                ✅ Thêm loại nghỉ phép thành công!
            </div>

            <form id="leaveTypeForm">
                <!-- Thông tin cơ bản -->
                <div class="form-section">
                    <div class="section-title">
                        <div class="section-icon">1</div>
                        Thông tin cơ bản
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="ten">Tên loại nghỉ phép <span class="required">*</span></label>
                            <input type="text" id="ten" name="ten" required placeholder="VD: Nghỉ phép năm">
                        </div>
                        <div class="form-group">
                            <label for="ma">Mã loại nghỉ phép <span class="required">*</span></label>
                            <input type="text" id="ma" name="ma" required placeholder="VD: NPN" maxlength="10">
                        </div>
                        <div class="form-group full-width">
                            <label for="mo_ta">Mô tả</label>
                            <textarea id="mo_ta" name="mo_ta" placeholder="Mô tả chi tiết về loại nghỉ phép này..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Cấu hình ngày -->
                <div class="form-section">
                    <div class="section-title">
                        <div class="section-icon">2</div>
                        Cấu hình ngày nghỉ
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="so_ngay_nam">Số ngày/năm</label>
                            <input type="number" id="so_ngay_nam" name="so_ngay_nam" min="0" max="365" placeholder="12">
                        </div>
                        <div class="form-group">
                            <label for="toi_da_ngay_lien_tiep">Tối đa ngày liên tiếp</label>
                            <input type="number" id="toi_da_ngay_lien_tiep" name="toi_da_ngay_lien_tiep" min="0" max="365" placeholder="5">
                        </div>
                        <div class="form-group">
                            <label for="so_ngay_bao_truoc">Số ngày báo trước tối thiểu</label>
                            <input type="number" id="so_ngay_bao_truoc" name="so_ngay_bao_truoc" min="0" max="30" placeholder="3">
                        </div>
                        <div class="form-group">
                            <label for="toi_da_ngay_chuyen">Tối đa ngày chuyển</label>
                            <input type="number" id="toi_da_ngay_chuyen" name="toi_da_ngay_chuyen" min="0" max="365" placeholder="5">
                        </div>
                    </div>
                </div>

                <!-- Điều kiện áp dụng -->
                <div class="form-section">
                    <div class="section-title">
                        <div class="section-icon">3</div>
                        Điều kiện áp dụng
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="gioi_tinh_ap_dung">Giới tính áp dụng</label>
                            <select id="gioi_tinh_ap_dung" name="gioi_tinh_ap_dung">
                                <option value="tat_ca">Tất cả</option>
                                <option value="nam">Nam</option>
                                <option value="nu">Nữ</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Cấu hình khác -->
                <div class="form-section">
                    <div class="section-title">
                        <div class="section-icon">4</div>
                        Cấu hình khác
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" id="cho_phep_chuyen_nam" name="cho_phep_chuyen_nam" value="1">
                                <label for="cho_phep_chuyen_nam">Cho phép chuyển năm</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" id="yeu_cau_giay_to" name="yeu_cau_giay_to" value="1">
                                <label for="yeu_cau_giay_to">Yêu cầu giấy tờ</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" id="co_luong" name="co_luong" value="1" checked>
                                <label for="co_luong">Có lương</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" id="trang_thai" name="trang_thai" value="1" checked>
                                <label for="trang_thai">Trạng thái hoạt động</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="button-group">
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">🔄 Làm mới</button>
                    <button type="submit" class="btn btn-primary">💾 Lưu loại nghỉ phép</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-generate mã from tên
        document.getElementById('ten').addEventListener('input', function() {
            const ten = this.value;
            const ma = ten
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/đ/g, 'd')
                .replace(/[^a-z0-9\s]/g, '')
                .split(' ')
                .map(word => word.charAt(0))
                .join('')
                .toUpperCase()
                .substring(0, 10);
            
            document.getElementById('ma').value = ma;
        });

        // Form submission
        document.getElementById('leaveTypeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simulate form submission
            const formData = new FormData(this);
            const data = {};
            
            // Process regular fields
            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }
            
            // Process checkboxes
            const checkboxes = ['cho_phep_chuyen_nam', 'yeu_cau_giay_to', 'co_luong', 'trang_thai'];
            checkboxes.forEach(field => {
                data[field] = document.getElementById(field).checked ? 1 : 0;
            });
            
            // Add timestamp
            data['updated_at'] = new Date().toISOString();
            
            console.log('Dữ liệu form:', data);
            
            // Show success message
            const successMessage = document.getElementById('successMessage');
            successMessage.style.display = 'block';
            successMessage.scrollIntoView({ behavior: 'smooth' });
            
            // Hide success message after 3 seconds
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000);
        });

        function resetForm() {
            document.getElementById('leaveTypeForm').reset();
            document.getElementById('co_luong').checked = true;
            document.getElementById('trang_thai').checked = true;
            document.getElementById('mau_sac').value = '#4facfe';
            document.getElementById('successMessage').style.display = 'none';
        }

        // Add some interactive animations
        document.querySelectorAll('.form-group input, .form-group select, .form-group textarea').forEach(element => {
            element.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
                this.parentElement.style.transition = 'transform 0.2s ease';
            });
            
            element.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>

@endsection
