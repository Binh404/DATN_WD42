<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo trạng thái đơn đề xuất</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .email-wrapper {
            max-width: 650px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        }
        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }
        .header p {
            font-size: 16px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 25px;
            color: #374151;
        }
        .info-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            border-left: 4px solid #4f46e5;
        }
        .info-row {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #374151;
            min-width: 140px;
            margin-right: 15px;
        }
        .info-value {
            color: #6b7280;
            flex: 1;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-da_duyet {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        .status-tu_choi {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }
        .status-huy {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        }
        .rejection-reason {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 16px;
            margin: 20px 0;
            color: #991b1b;
        }
        .footer {
            background: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            color: #6b7280;
            margin-bottom: 8px;
        }
        .signature {
            font-weight: 600;
            color: #4f46e5;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <h1>📋 Thông báo đơn đề xuất</h1>
            <p>Cập nhật trạng thái đơn đề xuất của bạn</p>
        </div>

        <div class="content">
            <div class="greeting">
                Kính gửi <strong>{{ $donDeXuat->nguoiTao->hoSo->ho ?? '' }} {{ $donDeXuat->nguoiTao->hoSo->ten ?? '' }}</strong>,
            </div>

            <p style="color: #6b7280; margin-bottom: 25px;">
                Đơn đề xuất của bạn đã được xử lý. Dưới đây là thông tin chi tiết:
            </p>

            <div class="info-card">
                <div class="info-row">
                    <div class="info-label">👤 Người đề xuất:</div>
                    <div class="info-value">{{ $donDeXuat->nguoiTao->hoSo->ho ?? 'N/A' }} {{ $donDeXuat->nguoiTao->hoSo->ten ?? 'N/A' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">🎯 Người được đề xuất:</div>
                    <div class="info-value">{{ $donDeXuat->nguoiDuocDeXuat->hoSo->ho ?? 'N/A' }} {{ $donDeXuat->nguoiDuocDeXuat->hoSo->ten ?? 'N/A' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">📝 Loại đề xuất:</div>
                    <div class="info-value">
                        @if ($donDeXuat->loai_de_xuat == 'xin_nghi')
                            🏖️ Xin nghỉ
                        @elseif ($donDeXuat->loai_de_xuat == 'de_cu_truong_phong')
                            🚀 Đề cử lên trưởng phòng
                        @elseif ($donDeXuat->loai_de_xuat == 'mien_nhiem_nhan_vien')
                            ⚠️ Miễn nhiệm nhân viên
                        @elseif ($donDeXuat->loai_de_xuat == 'mien_nhiem_truong_phong')
                            ⚠️ Miễn nhiệm trưởng phòng
                        @else
                            ❓ Không xác định
                        @endif
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">💬 Ghi chú:</div>
                    <div class="info-value">{{ $donDeXuat->ghi_chu ?? 'Không có ghi chú' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">📊 Trạng thái:</div>
                    <div class="info-value">
                        <span class="status-badge status-{{ $trangThai }}">
                            @if ($trangThai == 'da_duyet')
                                ✅ Đã phê duyệt
                            @elseif ($trangThai == 'tu_choi')
                                ❌ Bị từ chối
                            @elseif ($trangThai == 'huy')
                                🗑️ Đã hủy
                            @else
                                ❓ Không xác định
                            @endif
                        </span>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">👨‍💼 Người duyệt:</div>
                    <div class="info-value">{{ $nguoiDuyet->hoSo->ho ?? 'N/A' }} {{ $nguoiDuyet->hoSo->ten ?? 'N/A' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">🕐 Thời gian duyệt:</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($donDeXuat->thoi_gian_duyet)->format('d/m/Y H:i') }}</div>
                </div>
            </div>

            @if ($trangThai == 'tu_choi' && $lyDoTuChoi)
                <div class="rejection-reason">
                    <strong>🚫 Lý do từ chối:</strong><br>
                    {{ $lyDoTuChoi }}
                </div>
            @endif

            <p style="color: #6b7280; margin-top: 25px;">
                💡 <em>Vui lòng liên hệ phòng nhân sự nếu bạn có bất kỳ thắc mắc nào.</em>
            </p>
        </div>

        <div class="footer">
            <p>Trân trọng,</p>
            <p class="signature">🏢 Đội ngũ Quản lý Nhân sự</p>
        </div>
    </div>
</body>
</html>
