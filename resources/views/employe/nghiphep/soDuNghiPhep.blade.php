@extends('layoutsAdmin.master')

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
                    Nghỉ phép
                </h2>
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
                        Số dư
                    </h5>
                </div>

                <div class="text-end">
                    <a href="{{ route('nghiphep.index') }}" class="btn btn-primary btn-lg mb-0 me-0 text-white">
                        Quay lại
                    </a>
                </div>
            </div>

            <div class="stats">
                <div class="stat-card pending">
                    <div class="stat-number">{{ $soNgayDuocCap }}</div>
                    <div class="stat-label">Ngày được cấp</div>
                </div>
                <div class="stat-card approved">
                    <div class="stat-number">{{ $soNgayDaDung }}</div>
                    <div class="stat-label">Đã sử dụng</div>
                </div>
                <div class="stat-card rejected">
                    <div class="stat-number">{{ $soNgayChoDuyet }}</div>
                    <div class="stat-label">Chờ duyệt</div>
                </div>
                <div class="stat-card pending">
                    <div class="stat-number">{{ $soNgayConLai }}</div>
                    <div class="stat-label">Còn lại</div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    @if ($soDuNghiPhep->count() > 0)
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Loại nghỉ phép
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Số ngày được cấp
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Đã sử dụng
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Chờ duyệt
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Còn lại
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Chuyển từ năm trước
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($soDuNghiPhep as $item)
                                    <tr class="border-bottom">
                                        <td class="px-4 py-3 align-middle">
                                            <code
                                                class="bg-light text-dark px-2 py-1 rounded">{{ $item->loaiNghiPhep->ten }}</code>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <span>{{ $item->so_ngay_duoc_cap }}</span>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <span>{{ $item->so_ngay_da_dung }}</span>
                                        </td>

                                        <td class="px-4 py-3 align-middle">
                                            <span>{{ $item->so_ngay_cho_duyet }}</span>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <span>{{ $item->so_ngay_con_lai }}</span>
                                        </td>

                                        <td class="px-4 py-3 align-middle">
                                            <span>{{ $item->so_ngay_chuyen_tu_nam_truoc }}</span>
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
                            <h5 class="text-muted mb-3">Không tìm thấy đơn xin nghỉ nào</h5>
                            @if (request('search'))
                                <p class="text-muted mb-4">
                                    Không có kết quả nào cho từ khóa: <strong>"{{ request('search') }}"</strong>
                                </p>
                                <a href="/yeu$item" class="btn btn-outline-primary me-2">
                                    <i class="fas fa-list me-1"></i>Xem tất cả
                                </a>
                            @else
                                <p class="text-muted mb-4">Chưa có đơn xin nghỉ nào được tạo.</p>
                            @endif

                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

@endsection
