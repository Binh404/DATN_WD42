<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo miễn nhiệm</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .email-wrapper {
            max-width: 650px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }
        .header {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            color: white;
            padding: 45px 30px;
            text-align: center;
            position: relative;
        }
        .header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 12px;
        }
        .header p {
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 25px;
            color: #374151;
        }
        .regret-message {
            background: #fef2f2;
            border: 2px solid #fca5a5;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }
        .regret-message h2 {
            color: #991b1b;
            font-size: 20px;
            margin-bottom: 15px;
        }
        .regret-message p {
            color: #7f1d1d;
            line-height: 1.7;
        }
        .info-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            border-left: 4px solid #64748b;
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
            min-width: 150px;
            margin-right: 15px;
        }
        .info-value {
            color: #6b7280;
            flex: 1;
        }
        .support-section {
            background: #f0f9ff;
            border: 2px solid #38bdf8;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
        }
        .support-section h3 {
            color: #0c4a6e;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .support-section p {
            color: #0369a1;
            line-height: 1.7;
        }
        .footer {
            background: #f9fafb;
            padding: 35px 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            color: #6b7280;
            margin-bottom: 8px;
        }
        .signature {
            font-weight: 600;
            color: #374151;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <h1>📋 Thông báo miễn nhiệm</h1>
            <p>Thông báo chính thức về quyết định nhân sự</p>
        </div>

        <div class="content">
            <div class="greeting">
                Kính gửi <strong>{{ $donDeXuat->nguoiDuocDeXuat->hoSo->ho ?? 'N/A' }} {{ $donDeXuat->nguoiDuocDeXuat->hoSo->ten ?? 'N/A' }}</strong>,
            </div>

            <div class="regret-message">
                <h2>⚠️ Thông báo miễn nhiệm</h2>
                <p>Chúng tôi rất tiếc phải thông báo rằng bạn đã được phê duyệt miễn nhiệm khỏi vị trí hiện tại theo đơn đề xuất đã được xem xét và phê duyệt.</p>
            </div>

            <div class="info-card">
                <div class="info-row">
                    <div class="info-label">👤 Người đề xuất:</div>
                    <div class="info-value">{{ $donDeXuat->nguoiTao->hoSo->ho ?? 'N/A' }} {{ $donDeXuat->nguoiTao->hoSo->ten ?? 'N/A' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">💬 Ghi chú:</div>
                    <div class="info-value">{{ $donDeXuat->ghi_chu ?? 'Không có ghi chú' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">📅 Ngày phê duyệt:</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($donDeXuat->thoi_gian_duyet)->format('d/m/Y H:i') }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">✅ Người duyệt:</div>
                    <div class="info-value">{{ $nguoiDuyet->hoSo->ho ?? 'N/A' }} {{ $nguoiDuyet->hoSo->ten ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="support-section">
                <h3>🤝 Hỗ trợ và bước tiếp theo:</h3>
                <p>Vui lòng liên hệ phòng nhân sự trong vòng 2 ngày làm việc để được hỗ trợ về các thủ tục cần thiết, quyền lợi và các bước tiếp theo. Chúng tôi sẽ hỗ trợ bạn trong quá trình chuyển đổi này.</p>
            </div>

            <p style="color: #6b7280; margin-top: 25px; text-align: center; font-style: italic;">
                Cảm ơn bạn đã có những đóng góp quý báu trong thời gian qua.
            </p>
        </div>

        <div class="footer">
            <p>Trân trọng,</p>
            <p class="signature">🏢 Đội ngũ Quản lý Nhân sự</p>
        </div>
    </div>
</body>
</html>
