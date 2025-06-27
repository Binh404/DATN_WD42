<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo chấm công</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            line-height: 1.2;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #4472C4;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 18px;
            color: #4472C4;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 12px;
            color: #666;
        }

        .statistics {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .stat-box {
            background: #f8f9fa;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            width: 23%;
            border-radius: 4px;
        }

        .stat-box h3 {
            font-size: 16px;
            color: #4472C4;
            margin-bottom: 5px;
        }

        .stat-box p {
            font-size: 10px;
            color: #666;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #4472C4;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f5f5f5;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 7px;
            font-weight: bold;
        }

        .badge-success { background: #28a745; color: white; }
        .badge-warning { background: #ffc107; color: #212529; }
        .badge-info { background: #17a2b8; color: white; }
        .badge-danger { background: #dc3545; color: white; }
        .badge-secondary { background: #6c757d; color: white; }

        .summary-section {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .summary-box {
            width: 48%;
            border: 1px solid #ddd;
            padding: 10px;
            background: #f8f9fa;
        }

        .summary-box h4 {
            color: #4472C4;
            margin-bottom: 10px;
            font-size: 12px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 9px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
            padding: 5px;
            background: white;
        }

        .page-break {
            page-break-after: always;
        }
        .summary-section.flex-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap; /* Cho responsive, tự xuống dòng khi không đủ chỗ */
        }

        .summary-box {
            flex: 1;
            min-width: 300px; /* Đảm bảo có chiều rộng tối thiểu */
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.05);
        }
</style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>BÁO CÁO CHẤM CÔNG</h1>
        <p>Kỳ báo cáo: {{ $statistics['period']['start'] }} - {{ $statistics['period']['end'] }}</p>
        <p>Ngày xuất: {{ date('d/m/Y H:i:s') }}</p>
    </div>
    <!-- Statistics Summary -->
    <div class="statistics">
        <div class="stat-box">
            <h3>{{ number_format($statistics['total_records']) }}</h3>
            <p>Tổng bản ghi</p>
        </div>
        <div class="stat-box">
            <h3>{{ number_format($statistics['total_employees']) }}</h3>
            <p>Số nhân viên</p>
        </div>
        <div class="stat-box">
            <h3>{{ number_format($statistics['total_hours'], 1) }}</h3>
            <p>Tổng giờ làm</p>
        </div>
        <div class="stat-box">
            <h3>{{ number_format($statistics['total_workdays'], 1) }}</h3>
            <p>Tổng công</p>
        </div>
    </div>

    <!-- Summary Analysis -->
    <!-- Summary Analysis -->
    <div class="summary-section flex-row">
        <div class="summary-box">
            <h4>Thống kê theo trạng thái</h4>
            <div class="summary-item">
                <span>Bình thường:</span>
                <span><strong>{{ $statistics['status_breakdown']['binh_thuong'] }}</strong></span>
            </div>
            <div class="summary-item">
                <span>Đi muộn:</span>
                <span><strong>{{ $statistics['status_breakdown']['di_muon'] }}</strong></span>
            </div>
            <div class="summary-item">
                <span>Về sớm:</span>
                <span><strong>{{ $statistics['status_breakdown']['ve_som'] }}</strong></span>
            </div>
            <div class="summary-item">
                <span>Vắng mặt:</span>
                <span><strong>{{ $statistics['status_breakdown']['vang_mat'] }}</strong></span>
            </div>
            <div class="summary-item">
                <span>Nghỉ phép:</span>
                <span><strong>{{ $statistics['status_breakdown']['nghi_phep'] }}</strong></span>
            </div>
        </div>

        <div class="summary-box">
            <h4>Thống kê phê duyệt</h4>
            <div class="summary-item">
                <span>Đã duyệt:</span>
                <span><strong>{{ $statistics['approval_status']['approved'] }}</strong></span>
            </div>
            <div class="summary-item">
                <span>Từ chối:</span>
                <span><strong>{{ $statistics['approval_status']['rejected'] }}</strong></span>
            </div>
            <div class="summary-item">
                <span>Chờ duyệt:</span>
                <span><strong>{{ $statistics['approval_status']['pending'] }}</strong></span>
            </div>
            <div class="summary-item">
                <span>Tỷ lệ duyệt:</span>
                <span><strong>
                    @if($statistics['total_records'] > 0)
                        {{ number_format(($statistics['approval_status']['approved'] / $statistics['total_records']) * 100, 1) }}%
                    @else
                        0%
                    @endif
                </strong></span>
            </div>
        </div>
    </div>


    <div class="page-break"></div>

    <!-- Data Table -->
    <div class="table-container">
        <h3 style="margin-bottom: 10px; color: #4472C4;">Chi tiết dữ liệu chấm công</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 3%;">STT</th>
                    <th style="width: 6%;">Mã NV</th>
                    <th style="width: 15%;">Họ và tên</th>
                    <th style="width: 10%;">Phòng ban</th>
                    <th style="width: 8%;">Ngày</th>
                    <th style="width: 6%;">Vào</th>
                    <th style="width: 6%;">Ra</th>
                    <th style="width: 5%;">Giờ</th>
                    <th style="width: 5%;">Công</th>
                    <th style="width: 4%;">Muộn</th>
                    <th style="width: 4%;">Sớm</th>
                    <th style="width: 10%;">Trạng thái</th>
                    <th style="width: 8%;">Phê duyệt</th>
                    <th style="width: 10%;">Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chamCong as $index => $cc)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">NV{{ str_pad($cc->nguoiDung->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $cc->nguoiDung->hoSo->ho ?? 'N/A' }} {{ $cc->nguoiDung->hoSo->ten ?? 'N/A' }}</td>
                    <td>{{ $cc->nguoiDung->phongBan->ten_phong_ban ?? 'N/A' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($cc->ngay_cham_cong)->format('d/m/Y') }}</td>
                    <td class="text-center">
                        @if($cc->gio_vao)
                            {{ \Carbon\Carbon::parse($cc->gio_vao)->format('H:i') }}
                        @endif
                    </td>
                    <td class="text-center">
                        @if($cc->gio_ra)
                            {{ \Carbon\Carbon::parse($cc->gio_ra)->format('H:i') }}
                        @endif
                    </td>
                    <td class="text-center">{{ $cc->so_gio_lam ? number_format($cc->so_gio_lam, 1) : '' }}</td>
                    <td class="text-center">{{ $cc->so_cong ? number_format($cc->so_cong, 1) : '' }}</td>
                    <td class="text-center">{{ $cc->phut_di_muon ?? 0 }}</td>
                    <td class="text-center">{{ $cc->phut_ve_som ?? 0 }}</td>
                    <td class="text-center">
                        @php
                            $statusClass = [
                                'binh_thuong' => 'badge-success',
                                'di_muon' => 'badge-warning',
                                've_som' => 'badge-info',
                                'vang_mat' => 'badge-danger',
                                'nghi_phep' => 'badge-secondary'
                            ];
                            $statusText = [
                                'binh_thuong' => 'Bình thường',
                                'di_muon' => 'Đi muộn',
                                've_som' => 'Về sớm',
                                'vang_mat' => 'Vắng mặt',
                                'nghi_phep' => 'Nghỉ phép'
                            ];
                        @endphp
                        <span class="badge {{ $statusClass[$cc->trang_thai] ?? 'badge-secondary' }}">
                            {{ $statusText[$cc->trang_thai] ?? $cc->trang_thai }}
                        </span>
                    </td>
                    <td class="text-center">
                        @if($cc->trang_thai_duyet == 1)
                            <span class="badge badge-success">Duyệt</span>
                        @elseif($cc->trang_thai_duyet == 2)
                            <span class="badge badge-danger">Từ chối</span>
                        @elseif($cc->trang_thai_duyet == 3)
                            <span class="badge badge-warning">Chờ duyệt</span>
                        @else
                            <span class="badge badge-secondary">Chưa gửi lý do</span>
                        @endif
                    </td>
                    <td style="font-size: 7px;">{{ Str::limit($cc->ghi_chu ?? '', 20) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Hệ thống quản lý chấm công - Trang {{ '{PAGE_NUM}' }} / {{ '{PAGE_COUNT}' }}</p>
    </div>
</body>
</html>
