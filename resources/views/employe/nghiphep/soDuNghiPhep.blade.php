@extends('layoutsEmploye.master')

@section('content-employee')
    <style>
        .containerr {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.3;
            }
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .employee-info {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-top: 20px;
            position: relative;
            z-index: 1;
        }

        .employee-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
        }

        .employee-details h2 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .employee-details p {
            opacity: 0.9;
            font-size: 1rem;
        }

        .overview-cards {
            padding: 30px;
            background: rgba(248, 250, 252, 0.5);
        }

        .cards-grid {
            display: flex;
            flex-direction: row;
        }

        .overview-card {
            width: 210px;
            height: 200px;
            margin: 15px;
            background: white;
            padding: 25px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .overview-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4f46e5, #7c3aed);
        }

        .overview-card:hover {
            transform: translateY(-5px);
            border-color: #4f46e5;
            box-shadow: 0 15px 35px rgba(79, 70, 229, 0.2);
        }

        .card-icon {
            width: 50px;
            height: 50px;
            margin: 0 auto 15px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .card-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .card-label {
            color: #64748b;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .allocated-card .card-icon {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .used-card .card-icon {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        .pending-card .card-icon {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .remaining-card .card-icon {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .detailed-table {
            padding: 30px;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 25px;
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: white;
        }

        .table th {
            padding: 18px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #059669;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            transform: scale(1.01);
        }

        .table tbody tr:last-child {
            border-bottom: none;
        }

        .table td {
            padding: 16px;
            font-size: 0.95rem;
            color: #475569;
        }

        .leave-type-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: #6acec3;
        }

        .badge-annual {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .badge-sick {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .badge-personal {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
        }

        .badge-maternity {
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
            color: white;
        }

        .number-cell {
            font-weight: 700;
            font-size: 1rem;
        }

        .allocated-number {
            color: #3b82f6;
        }

        .used-number {
            color: #ef4444;
        }

        .pending-number {
            color: #f59e0b;
        }

        .remaining-number {
            color: #10b981;
        }

        .carried-number {
            color: #6366f1;
        }

        .date-cell {
            color: #64748b;
            font-size: 0.9rem;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 1rem;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }

            .employee-info {
                flex-direction: column;
                gap: 10px;
            }

            .cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .year-buttons {
                justify-content: center;
            }

            .table-container {
                overflow-x: auto;
            }

            .table th,
            .table td {
                padding: 12px 8px;
                font-size: 0.85rem;
            }

            .leave-type-badge {
                font-size: 0.75rem;
                padding: 6px 12px;
            }
        }
    </style>

    <div class="containerr">

        <div class="overview-cards">
            <div class="cards-grid">
                <div class="overview-card allocated-card">
                    <div class="card-icon">📅</div>
                    <div class="card-number" id="totalAllocated">{{ $soNgayDuocCap }}</div>
                    <div class="card-label">Tổng ngày được cấp</div>
                </div>
                <div class="overview-card used-card">
                    <div class="card-icon">✅</div>
                    <div class="card-number" id="totalUsed">{{ $soNgayDaDung }}</div>
                    <div class="card-label">Đã sử dụng</div>
                </div>
                <div class="overview-card pending-card">
                    <div class="card-icon">⏳</div>
                    <div class="card-number" id="totalPending">{{ $soNgayChoDuyet }}</div>
                    <div class="card-label">Chờ duyệt</div>
                </div>
                <div class="overview-card remaining-card">
                    <div class="card-icon">💰</div>
                    <div class="card-number" id="totalRemaining">{{ $soNgayConLai }}</div>
                    <div class="card-label">Còn lại</div>
                </div>
            </div>
        </div>

        <div class="detailed-table">
            <h2 class="section-title">Chi Tiết Nghỉ Phép Năm <span id="currentYear">2025</span></h2>
            <div class="table-container">
                <table class="table" id="leaveTable">
                    <thead>
                        <tr>
                            <th>Loại nghỉ phép</th>
                            <th>Số ngày được cấp</th>
                            <th>Đã sử dụng</th>
                            <th>Chờ duyệt</th>
                            <th>Còn lại</th>
                            <th>Chuyển từ năm trước</th>
                            <th>Cập nhật lần cuối</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @foreach ($soDuNghiPhep as $index => $item)
                            <tr>
                                <td>
                                    <span class="leave-type-badge">
                                        {{ $item->loaiNghiPhep->ten  }}
                                    </span>
                                </td>
                                <td class="number-cell allocated-number">{{ $item->so_ngay_duoc_cap }}</td>
                                <td class="number-cell used-number">{{ $item->so_ngay_da_dung }}</td>
                                <td class="number-cell pending-number">{{ $item->so_ngay_cho_duyet }}</td>
                                <td class="number-cell remaining-number">{{ $item->so_ngay_con_lai }}</td>
                                <td class="number-cell carried-number">{{ $item->so_ngay_chuyen_tu_nam_truoc }}</td>
                                <td class="date-cell">{{ $item->updated_at }}</td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
