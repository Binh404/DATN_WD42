<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoàn thiện hồ sơ</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Inter', sans-serif;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a3c6d;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border: 1px solid #d1d9e6;
            border-radius: 8px;
            padding: 12px;
            font-size: 0.95rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            outline: none;
        }

        .form-control[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        .text-danger {
            font-size: 0.85rem;
            margin-top: 4px;
        }

        .btn-primary {
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
            border: none;
            padding: 12px 40px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .img-thumbnail {
            border-radius: 8px;
            max-width: 120px;
            margin-top: 10px;
        }

        .form-section {
            padding: 20px;
            background: #f9fafb;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 20px;
            }

            .btn-primary {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Điền thông tin hồ sơ</h2>

        <form action="{{ route('employee.complete-profile.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <!-- Cột bên trái -->
                <div class="col-md-6">
                    <div class="form-section">
                        @foreach ([
                            'ho' => 'Họ',
                            'ten' => 'Tên',
                            'so_dien_thoai' => 'Số điện thoại',
                            'ngay_sinh' => 'Ngày sinh',
                            'dia_chi_hien_tai' => 'Địa chỉ hiện tại',
                            'dia_chi_thuong_tru' => 'Địa chỉ thường trú',
                            'cmnd_cccd' => 'CMND/CCCD',
                            'so_ho_chieu' => 'Số hộ chiếu'
                        ] as $field => $label)
                            <div class="mb-3">
                                <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                                <input type="{{ $field == 'ngay_sinh' ? 'date' : 'text' }}"
                                       name="{{ $field }}"
                                       id="{{ $field }}"
                                       class="form-control"
                                       value="{{ old($field, $hoSo->$field ?? '') }}">
                                @error($field)
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach

                        <div class="mb-3">
                            <label for="gioi_tinh" class="form-label">Giới tính</label>
                            <select name="gioi_tinh" id="gioi_tinh" class="form-select">
                                <option value="">-- Chọn --</option>
                                <option value="nam" {{ old('gioi_tinh', $hoSo->gioi_tinh ?? '') == 'nam' ? 'selected' : '' }}>Nam</option>
                                <option value="nu" {{ old('gioi_tinh', $hoSo->gioi_tinh ?? '') == 'nu' ? 'selected' : '' }}>Nữ</option>
                            </select>
                            @error('gioi_tinh')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tinh_trang_hon_nhan" class="form-label">Tình trạng hôn nhân</label>
                            <select name="tinh_trang_hon_nhan" id="tinh_trang_hon_nhan" class="form-select">
                                <option value="">-- Chọn --</option>
                                <option value="doc_than" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan ?? '') == 'doc_than' ? 'selected' : '' }}>Độc thân</option>
                                <option value="da_ket_hon" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan ?? '') == 'da_ket_hon' ? 'selected' : '' }}>Đã kết hôn</option>
                                <option value="ly_hon" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan ?? '') == 'ly_hon' ? 'selected' : '' }}>Ly hôn</option>
                                <option value="goa" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan ?? '') == 'goa' ? 'selected' : '' }}>Góa</option>
                            </select>
                            @error('tinh_trang_hon_nhan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Cột bên phải -->
                <div class="col-md-6">
                    <div class="form-section">
                        @foreach ([
                            'lien_he_khan_cap' => 'Người liên hệ khẩn cấp',
                            'sdt_khan_cap' => 'SĐT khẩn cấp',
                            'quan_he_khan_cap' => 'Quan hệ với người khẩn cấp'
                        ] as $field => $label)
                            <div class="mb-3">
                                <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                                <input type="text"
                                       name="{{ $field }}"
                                       id="{{ $field }}"
                                       class="form-control"
                                       value="{{ old($field, $hoSo->$field ?? '') }}">
                                @error($field)
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach

                        <div class="mb-3">
                            <label for="email_cong_ty" class="form-label">Email công ty</label>
                            <input type="email"
                                   name="email_cong_ty"
                                   id="email_cong_ty"
                                   class="form-control"
                                   value="{{ auth()->user()->email }}"
                                   readonly>
                        </div>

                        <div class="mb-3">
                            <label for="anh_dai_dien" class="form-label">Ảnh đại diện</label>
                            <input type="file"
                                   name="anh_dai_dien"
                                   id="anh_dai_dien"
                                   class="form-control">
                            @error('anh_dai_dien')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        @if (!empty($hoSo->anh_dai_dien))
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $hoSo->anh_dai_dien) }}"
                                     alt="Ảnh đại diện"
                                     class="img-thumbnail">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Lưu thông tin</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap 5 JS (Optional, for interactive components if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
