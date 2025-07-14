@extends('layoutsAdmin.master')
@section('title', 'Yêu cầu tuyển dụng')

@section('content')
    <style>
        a {
            text-decoration: none;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.5);
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-left: 5px solid;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .stat-card.pending {
            border-left-color: #f39c12;
        }

        .stat-card.approved {
            border-left-color: #27ae60;
        }

        .stat-card.rejected {
            border-left-color: #e74c3c;
        }

        .stat-number {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #666;
            font-size: 1rem;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h3 {
            margin: 0;
            color: #333;
        }

        .close {
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: #333;
        }

        textarea {
            width: 100%;
            min-height: 100px;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-family: inherit;
            resize: vertical;
            font-size: 14px;
        }

        textarea:focus {
            outline: none;
            border-color: #667eea;
        }
    </style>

    <div class="container-fluid px-4">

        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h2 class="fw-bold text-primary mb-0">
                    Duyệt đơn
                </h2>
            </div>

            <div class="col-md-5">
                <form method="GET" action="/yeu$yeuCauTuyenDung">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" name="search"
                            placeholder="Tìm kiếm yêu cầu..." value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            Tìm kiếm
                        </button>
                    </div>
                </form>
            </div>

        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">
                        Đơn xin nghỉ
                    </h5>
                </div>
            </div>

            <div class="stats">
                <div class="stat-card pending">
                    <div class="stat-number">{{ $soDonChuaDuyet }}</div>
                    <div class="stat-label">Chờ duyệt</div>
                </div>
                <div class="stat-card approved">
                    <div class="stat-number">{{ $thongKe['da_duyet'] ?? 0 }}</div>
                    <div class="stat-label">Đã duyệt</div>
                </div>
                <div class="stat-card rejected">
                    <div class="stat-number">{{ $thongKe['tu_choi'] ?? 0 }}</div>
                    <div class="stat-label">Từ chối</div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    @if ($donXinNghis->count() > 0)
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Mã
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Tên nhân viên
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Phòng ban
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Loại Nghỉ
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Từ ngày
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Đến ngày
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Trạng thái
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted text-center">
                                        Thao tác
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donXinNghis as $item)
                                    <tr class="border-bottom">
                                        <td class="px-4 py-3 align-middle">
                                            <code class="bg-light text-dark px-2 py-1 rounded">2</code>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <span>{{ $item->nguoiDung->hoSo->ho . ' ' . $item->nguoiDung->hoSo->ten }}</span>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <span>{{ $item->nguoiDung->phongBan->ten_phong_ban }}</span>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <span>{{ $item->loaiNghiPhep->ten }}</span>
                                        </td>

                                        <td class="px-4 py-3 align-middle">
                                            <span>{{ $item->ngay_bat_dau->format('d/m/Y') }}</span>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <span>{{ $item->ngay_ket_thuc->format('d/m/Y') }}</span>
                                        </td>

                                        <td class="px-4 py-3 align-middle">
                                            @php
                                                $ketQua = $item->ketQuaDuyetTheoCap($vaiTro->ten === 'hr' ? 2 : 1);
                                            @endphp

                                            @if ($ketQua === 'da_duyet')
                                                <span class="bg-success-subtle text-success">
                                                    Đã duyệt
                                                </span>
                                            @elseif ($ketQua === 'tu_choi')
                                                <span class="bg-danger-subtle text-danger">
                                                    Từ chối
                                                </span>
                                            @else
                                                <span class="bg-warning-subtle text-warning">
                                                    Chờ duyệt
                                                </span>
                                            @endif

                                        </td>

                                        <td class="px-4 py-3 align-middle">
                                            @if ($ketQua === 'da_duyet')
                                                <a class="btn btn-outline-success btn-sm rounded-pill"
                                                    href="{{ route('department.donxinnghi.show', $item->id) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @elseif ($ketQua === 'tu_choi')
                                                <a class="btn btn-outline-success btn-sm rounded-pill"
                                                    href="{{ route('department.donxinnghi.show', $item->id) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @else
                                                <a class="btn btn-outline-success btn-sm rounded-pill"
                                                    href="{{ route('department.donxinnghi.duyet', $item->id) }}">
                                                    <i class="fas fa-check text-success"></i>
                                                </a>

                                                <button class="btn btn-outline-success btn-sm rounded-pill"
                                                    onclick="clickTuChoi({{ $item->id }})"><i
                                                        class="fas fa-times text-danger"></i></button>
                                                <a class="btn btn-outline-success btn-sm rounded-pill"
                                                    href="{{ route('department.donxinnghi.show', $item->id) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    @else
                        <!-- Thông báo không tìm thấy -->
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-search fa-3x text-muted opacity-50"></i>
                            </div>
                            <h5 class="text-muted mb-3">Không tìm thấy đơn  xin nghỉ nào</h5>
                            @if (request('search'))
                                <p class="text-muted mb-4">
                                    Không có kết quả nào cho từ khóa: <strong>"{{ request('search') }}"</strong>
                                </p>
                                <a href="/yeu$item" class="btn btn-outline-primary me-2">
                                    <i class="fas fa-list me-1"></i>Xem tất cả
                                </a>
                            @else
                                <p class="text-muted mb-4">Chưa có đơn  xin nghỉ nào được tạo.</p>
                            @endif

                        </div>
                    @endif
                </div>
            </div>
        </div>


    </div>

    <!-- Modal cho ghi chú từ chối -->
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <form action="{{ route('department.donxinnghi.tuchoi') }}" id="frmTuChoiDonXinNghi" method="POST">
                @csrf

                <div class="modal-header">
                    <h3>Lý do từ chối</h3>
                    <span class="close">&times;</span>
                </div>
                <div style="margin-bottom: 20px;">
                    <input type="hidden" id="don_xin_nghi_id" name="don_xin_nghi_id">
                    <label for="rejectReason" style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">
                        Vui lòng nhập lý do từ chối đơn xin nghỉ:
                    </label>
                    <textarea id="rejectReason" name="ghi_chu"
                        placeholder="Ví dụ: Thời gian nghỉ trùng với dự án quan trọng, cần sắp xếp lại công việc..."></textarea>
                </div>
                <div style="text-align: right; display: flex; gap: 10px; justify-content: flex-end;">
                    <button class="btn" type="button" style="background: #95a5a6; color: white;"
                        onclick="closeRejectModal()">Hủy</button>
                    <button type="submit" class="btnn btnn-reject" onclick="return confirmReject()">Xác nhận từ
                        chối</button>
                </div>
            </form>

        </div>
    </div>

    <script>
        function clickTuChoi(id) {
            document.getElementById('rejectModal').style.display = 'block';
            document.getElementById('rejectReason').value = '';
            document.getElementById('rejectReason').focus();
            document.getElementById('don_xin_nghi_id').value = id;
        }

        // Đóng modal khi click vào nút X
        document.querySelector('.close').addEventListener('click', function() {
            closeRejectModal();
        });

        // Đóng modal khi click ra ngoài
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('rejectModal');
            if (e.target === modal) {
                closeRejectModal();
            }
        });

        // Hàm đóng modal
        function closeRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
            currentRejectEmployee = '';
        }

        // Hàm xác nhận từ chối
        function confirmReject() {
            const reason = document.getElementById('rejectReason').value.trim();
            if (!reason) {
                alert('Vui lòng nhập lý do từ chối!');
                return false;
            }

            return confirm('Bạn có chắc chắn muốn từ chối đơn xin nghỉ này không?');
        }

        // Xử lý phím Enter trong textarea
        document.getElementById('rejectReason').addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.ctrlKey) {
                confirmReject();
            }
        });

        // Hiệu ứng hover cho cards
        document.querySelectorAll('.request-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0) scale(1)';
            });
        });
    </script>


@endsection
