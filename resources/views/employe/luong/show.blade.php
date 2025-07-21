@extends('layoutsEmploye.master')

@section('css')
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            line-height: 1.6;
        }

        .container {
            max-width: 100%;
            margin: 0;
            padding: 20px;
        }
        .header_salary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .header_salary h1 {
            font-size: 2.2em;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header_salary-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }


        .info-item {
            background: rgba(255,255,255,0.1);
            padding: 15px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .info-item h3 {
            font-size: 0.9em;
            opacity: 0.8;
            margin-bottom: 5px;
        }

        .info-item p {
            font-size: 1.3em;
            font-weight: bold;
        }

        .main-employee {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            border: 1px solid #e1e8ed;
        }

        .card h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #3498db;
            font-size: 1.4em;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .salary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .salary-item:last-child {
            border-bottom: none;
            font-weight: bold;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            margin: 10px -10px -10px -10px;
            padding: 15px 20px;
            border-radius: 10px;
        }

        .salary-label {
            font-weight: 500;
            color: #555;
        }

        .salary-value {
            font-weight: bold;
            color: #2c3e50;
        }

        .salary-value.positive {
            color: #27ae60;
        }

        .salary-value.negative {
            color: #e74c3c;
        }

        .salary-value.total {
            color: #8e44ad;
            font-size: 1.2em;
        }

        .attendance-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .attendance-item {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(116, 185, 255, 0.3);
        }

        .attendance-item h4 {
            font-size: 0.9em;
            opacity: 0.9;
            margin-bottom: 8px;
        }

        .attendance-item .number {
            font-size: 2em;
            font-weight: bold;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 500;
        }
        .status-processing { background-color: #f0ad4e; }

        .status-approved {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .status-paid       { background-color: #0275d8; } /* xanh đậm */
        .status-unknown    { background-color: gray; }


        @media (max-width: 768px) {
            .main-employee {
                grid-template-columns: 1fr;
            }

            .header_salary-info {
                grid-template-columns: 1fr;
            }

            .actions {
                flex-direction: column;
            }
        }
</style>
@endsection

@section('content-employee')
        <!-- header_salary_em với thông tin chung -->
        <div class="header_salary">
            <h1>
                <i class="fas fa-receipt"></i>
                Chi tiết bảng lương tháng {{ $bangLuong->thang }}/{{ $bangLuong->nam }}
            </h1>
            <div class="header_salary-info">
                <div class="info-item">
                    <h3>Nhân viên</h3>
                    <p>{{ $hoSo->ho. ' ' . $hoSo->ten }}</p>
                </div>
                <div class="info-item">
                    <h3>Mã nhân viên</h3>
                    <p>{{ $hoSo->ma_nhan_vien }}</p>
                </div>
                <div class="info-item">
                    <h3>Phòng ban</h3>
                    <p>{{ $phongBan->ten_phong_ban }}</p>
                </div>
                <div class="info-item">
                    <h3>Chức vụ</h3>
                    <p>{{ $chucVu->ten }}</p>
                </div>
                <div class="info-item">
                    <h3>Trạng thái</h3>
                    <p><span class="status-badge {{ $bangLuong->trang_thai_label['class'] }}">
                        {{ $bangLuong->trang_thai_label['text'] }}
                    </span></p>
                </div>
            </div>
        </div>

        <div class="main-employee">
            <!-- Thông tin lương -->
            <div class="card">
                <h2><i class="fas fa-money-bill-wave"></i> Thông tin lương</h2>

                <div class="salary-item">
                    <span class="salary-label">Lương cơ bản</span>
                    <span class="salary-value positive">{{ number_format($bangLuongChiTiet->luong_co_ban , 0, '.', '.') }}đ</span>
                </div>
                 @foreach ($danhSachPhuCap as $phuCap)

                <div class="salary-item">
                    <span class="salary-label">{{ $phuCap['ten_phu_cap']  }}</span>
                    <span class="salary-value positive">{{ number_format($phuCap['so_tien'], 0, '.', '.') }}đ</span>
                </div>
                @endforeach
                {{-- <div class="salary-item">
                    <span class="salary-label">Phụ cấp ăn trưa</span>
                    <span class="salary-value positive">500.000đ</span>
                </div>
                <div class="salary-item">
                    <span class="salary-label">Phụ cấp xăng xe</span>
                    <span class="salary-value positive">300.000đ</span>
                </div>
                <div class="salary-item">
                    <span class="salary-label">Phụ cấp điện thoại</span>
                    <span class="salary-value positive">200.000đ</span>
                </div> --}}
                <div class="salary-item">
                    <span class="salary-label">Tổng phụ cấp</span>
                    <span class="salary-value positive">{{ number_format($bangLuongChiTiet->tong_phu_cap , 0, '.', '.') }}đ</span>
                </div>
                <div class="salary-item">
                    <span class="salary-label">Tổng thu nhập</span>
                    <span class="salary-value positive">{{ number_format($bangLuongChiTiet->tong_luong , 0, '.', '.') }}đ</span>
                </div>
            </div>

            <!-- Thông tin khấu trừ -->
            <div class="card">
                <h2><i class="fas fa-minus-circle"></i> Các khoản khấu trừ</h2>
                @foreach ($danhSachKhauTru as $khauTru)
                    <div class="salary-item">
                        <span class="salary-label">{{ $khauTru['ten_khau_tru'] }} (8%)</span>
                        <span class="salary-value negative">-{{ number_format($khauTru['so_tien'], 0, '.', '.') }}đ</span>
                    </div>
                @endforeach

                {{-- <div class="salary-item">
                    <span class="salary-label">Bảo hiểm y tế (1.5%)</span>
                    <span class="salary-value negative">-180.000đ</span>
                </div>
                <div class="salary-item">
                    <span class="salary-label">Bảo hiểm thất nghiệp (1%)</span>
                    <span class="salary-value negative">-120.000đ</span>
                </div>
                <div class="salary-item">
                    <span class="salary-label">Thuế thu nhập cá nhân</span>
                    <span class="salary-value negative">-550.000đ</span>
                </div> --}}
                <div class="salary-item">
                    <span class="salary-label">Ứng lương</span>
                    <span class="salary-value negative">-1.000.000đ</span>
                </div>
                <div class="salary-item">
                    <span class="salary-label">Tổng khấu trừ</span>
                    <span class="salary-value negative">{{ number_format($bangLuongChiTiet->tong_khau_tru , 0, '.', '.') }}đ</span>
                </div>
            </div>
        </div>

        <!-- Thông tin chấm công -->
        <div class="card full-width">
            <h2><i class="fas fa-calendar-check"></i> Thông tin chấm công</h2>
            <div class="attendance-grid">
                <div class="attendance-item">
                    <h4>Số ngày làm việc</h4>
                    <div class="number">{{ $thongTinChamCong['so_ngay_cham_cong'] }}</div>
                </div>
                <div class="attendance-item">
                    <h4>Số ngày nghỉ phép</h4>
                    <div class="number">{{ $thongTinNghiPhep['so_ngay_nghi_phep'] }}</div>
                </div>
                <div class="attendance-item">
                    <h4>Số ngày nghỉ không lương</h4>
                    <div class="number">{{ $thongTinNghiPhep['so_ngay_nghi_phep'] }}</div>
                </div>
                <div class="attendance-item">
                    <h4>Số giờ làm thêm</h4>
                    <div class="number">{{ $thongTinChamCong['so_gio_lam_them'] }}</div>
                </div>
                <div class="attendance-item">
                    <h4>Số lần đi muộn</h4>
                    <div class="number">{{ $thongTinChamCong['so_lan_di_muon'] }}</div>
                </div>
                <div class="attendance-item">
                    <h4>Số lần về sớm</h4>
                    <div class="number">{{ $thongTinChamCong['so_lan_ve_som'] }}</div>
                </div>
            </div>
        </div>

        <!-- Tổng kết lương thực nhận -->
        <div class="card full-width">
            <h2><i class="fas fa-hand-holding-usd"></i> Tổng kết</h2>
            <div class="salary-item">
                <span class="salary-label" style="font-size: 1.2em;">Lương thực nhận tháng {{ $bangLuong->thang }}/{{ $bangLuong->nam }}</span>
                <span class="salary-value total" style="font-size: 1.5em;">{{ number_format($bangLuongChiTiet->luong_thuc_nhan , 0, '.', '.') }}đ</span>
            </div>
        </div>

        <!-- Các nút hành động -->
        <div class="actions">
            <button class="btn btn-primary">
                <i class="fas fa-download"></i>
                Tải phiếu lương PDF
            </button>
            <button class="btn btn-secondary">
                <i class="fas fa-print"></i>
                In phiếu lương
            </button>
            <button class="btn btn-success">
                <i class="fas fa-envelope"></i>
                Gửi email
            </button>
            <a href="javascript:history.back()" class="btn" style="background: #6c757d; color: white;">
                <i class="fas fa-arrow-left"></i>
                Quay lại
            </a>
        </div>
@endsection

@section('javascript')
<script>
        // Thêm hiệu ứng hover cho các card
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 10px 30px rgba(0,0,0,0.15)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 5px 20px rgba(0,0,0,0.08)';
            });
        });

        // Thêm hiệu ứng click cho các nút
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });
    </script>
@endsection
