<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chúc mừng thăng chức</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 50px 30px;
            text-align: center;
            position: relative;
        }
        .header::before {
            content: '🎉';
            font-size: 80px;
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0.2;
        }
        .celebration-icon {
            font-size: 64px;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }
        .header h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }
        .header p {
            font-size: 18px;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }
        .content {
            padding: 45px 30px;
        }
        .greeting {
            font-size: 20px;
            margin-bottom: 30px;
            color: #374151;
            text-align: center;
        }
        .congratulation-message {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border-radius: 16px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
            border: 2px solid #10b981;
        }
        .congratulation-message h2 {
            color: #065f46;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .congratulation-message p {
            color: #047857;
            font-size: 16px;
            line-height: 1.7;
        }
        .promotion-badge {
            display: inline-block;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 18px;
            margin: 20px 0;
            box-shadow: 0 8px 20px rgba(251, 191, 36, 0.3);
        }
        .info-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
            border-left: 5px solid #10b981;
        }
        .info-row {
            display: flex;
            align-items: flex-start;
            margin-bottom: 18px;
            padding-bottom: 18px;
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
        .next-steps {
            background: #fffbeb;
            border: 2px solid #fbbf24;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
        }
        .next-steps h3 {
            color: #92400e;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .next-steps p {
            color: #a16207;
            line-height: 1.7;
        }
        .footer {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .footer p {
            margin-bottom: 10px;
            opacity: 0.9;
        }
        .signature {
            font-weight: 600;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <div class="celebration-icon">🏆</div>
            <h1>Chúc Mừng Thăng Chức!</h1>
            <p>Một cột mốc quan trọng trong sự nghiệp của bạn</p>
        </div>

        <div class="content">
            <div class="greeting">
                Kính gửi <strong>{{ $donDeXuat->nguoiDuocDeXuat->hoSo->ho ?? 'N/A' }} {{ $donDeXuat->nguoiDuocDeXuat->hoSo->ten ?? 'N/A' }}</strong>,
            </div>

            <div class="congratulation-message">
                <h2>🎊 Xin chúc mừng! 🎊</h2>
                <p>Chúng tôi rất vui mừng thông báo rằng bạn đã được đề cử và phê duyệt thành công cho vị trí:</p>
                <div class="promotion-badge">
                    👨‍💼 TRƯỞNG PHÒNG 👨‍💼
                </div>
                <p>Đây là sự ghi nhận xứng đáng cho những đóng góp và nỗ lực của bạn!</p>
            </div>

            <div class="info-card">
                <div class="info-row">
                    <div class="info-label">🎯 Người đề xuất:</div>
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

            <div class="next-steps">
                <h3>🚀 Bước tiếp theo:</h3>
                <p>Vui lòng liên hệ phòng nhân sự trong vòng 3 ngày làm việc để được hướng dẫn chi tiết về vai trò mới, quyền hạn và trách nhiệm của vị trí Trưởng phòng.</p>
            </div>
        </div>

        <div class="footer">
            <p>Một lần nữa, xin chúc mừng và chúc bạn thành công trong vai trò mới!</p>
            <p class="signature">🏢 Đội ngũ Quản lý Nhân sự</p>
        </div>
    </div>
</body>
</html>
