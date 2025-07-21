@extends('layoutsAdmin.master')
@section('title', 'Yêu cầu tuyển dụng')

@section('content')
    <style>
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 15px;
            margin-bottom: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header h1 {
            color: #2d3748;
            font-size: 25px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header .subtitle {
            color: #718096;
            font-size: 17px;
            margin-bottom: 20px;
        }

        .notifications-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .section-title {
            color: #2d3748;
            font-size: 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notification-card {
            background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border-left: 5px solid #667eea;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .notification-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .notification-card:hover {
            transform: translateX(5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        .notification-item {
            text-decoration: none
        }

        .notification-card.important {
            border-left-color: #d69e2e;
            background: linear-gradient(135deg, #fffbeb 0%, #fef2c7 100%);
        }

        .notification-card.important::before {
            background: linear-gradient(90deg, #d69e2e, #f6e05e);
        }

        .notification-header {
            display: flex;
            justify-content: between;
            align-items: flex-start;
            margin-bottom: 15px;
            gap: 15px;
        }

        .notification-title {
            font-size: 1.3em;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 10px;
            flex: 1;
        }

        .notification-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            font-size: 0.9em;
            color: #718096;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .notification-content {
            color: #4a5568;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2em;
            }

            .notification-header {
                flex-direction: column;
                gap: 10px;
            }

            .notification-actions {
                flex-direction: column;
            }

            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <div class="container-fluid px-4">

        <!-- Header Section -->
        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h2 class="fw-bold text-primary mb-0">
                    Thông báo tuyển dụng
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

            {{-- <div class="col-md-3 text-end">
        <a href="{{ route('department.yeucautuyendung.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus me-2"></i>Tạo yêu cầu
        </a>
    </div> --}}
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

        <!-- Main Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">
                        Danh sách thông báo
                    </h5>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    @if ($TuyenDungs->count() > 0)
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Mã
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Người gửi
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Chức vụ
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Trạng thái
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Ngày Tạo
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted text-center">
                                        Hành Động
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($TuyenDungs as $index => $item)
                                    <tr class="border-bottom">
                                        <td class="px-4 py-3 align-middle">
                                            <code class="bg-light text-dark px-2 py-1 rounded">{{ $item->ma }}</code>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <span>Giám đốc</span>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <span>{{ $item->chucVu->ten }}</span>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            @if ($item->trang_thai_dang == 'chua_dang')
                                                <span
                                                    class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2">
                                                    Chưa đăng
                                                </span>
                                            @elseif($item->trang_thai_dang === 'da_dang')
                                                <span
                                                    class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                                    Đã đăng
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            {{ $item->created_at }}
                                        </td>

                                        <td class="px-4 py-3 align-middle">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="{{ route('hr.captrenthongbao.tuyendung.show', ['id' => $item->id]) }}"
                                                    class="btn btn-outline-success btn-sm rounded-pill"
                                                    data-bs-toggle="tooltip" title="Chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
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
                            <h5 class="text-muted mb-3">Không tìm thấy thông báo nào</h5>
                            @if (request('search'))
                                <p class="text-muted mb-4">
                                    Không có kết quả nào cho từ khóa: <strong>"{{ request('search') }}"</strong>
                                </p>
                                <a href="/yeu$item" class="btn btn-outline-primary me-2">
                                    <i class="fas fa-list me-1"></i>Xem tất cả
                                </a>
                            @else
                                <p class="text-muted mb-4">Chưa có thông báo nào được tạo.</p>
                            @endif
                            <a href="/yeu$item/create" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Thêm thông báo đầu tiên
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection
