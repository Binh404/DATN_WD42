<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Thông báo phê duyệt đăng ký tăng ca</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 28px;
            font-weight: 700;
            color: #1a3c34;
            letter-spacing: 1px;
        }
        .status-badge {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 500;
            font-size: 14px;
            margin: 15px 0;
            transition: transform 0.2s ease;
        }
        .status-badge:hover {
            transform: scale(1.05);
        }
        .status-approved {
            background-color: #e6f4ea;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }
        .status-rejected {
            background-color: #fce4e4;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }
        .status-cancelled {
            background-color: #fff8e1;
            color: #f57c00;
            border: 1px solid #ffcc80;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .info-table th,
        .info-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-table th {
            background-color: #f5f7fa;
            font-weight: 500;
            width: 40%;
            color: #1a3c34;
        }
        .reason-box {
            background-color: #fff8e1;
            border: 1px solid #ffcc80;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .reason-title {
            font-weight: 500;
            color: #f57c00;
            margin-bottom: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 12px;
        }
        .greeting {
            margin-bottom: 20px;
            font-size: 16px;
        }
        .cta-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #1a3c34;
            color: #ffffff;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            margin-top: 20px;
            transition: background-color 0.2s ease;
        }
        .cta-button:hover {
            background-color: #2e7d32;
        }
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            .container {
                padding: 20px;
            }
            .logo {
                font-size: 24px;
            }
            .info-table th,
            .info-table td {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }
            .info-table th {
                background-color: transparent;
                padding-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Hệ thống quản lý nhân sự</div>
        </div>

        <div class="greeting">
            <p>Xin chào <strong>{{ $mailData['ten_nhan_vien'] }}</strong>,</p>
        </div>

        <p>Đăng ký tăng ca của bạn đã được xử lý với thông tin như sau:</p>

        @php
            $statusClass = '';
            $statusText = '';
            $statusIcon = '';

            switch($mailData['trang_thai']) {
                case 'da_duyet':
                    $statusClass = 'status-approved';
                    $statusText = 'ĐÃ DUYỆT';
                    $statusIcon = '✅';
                    break;
                case 'tu_choi':
                    $statusClass = 'status-rejected';
                    $statusText = 'TỪ CHỐI';
                    $statusIcon = '❌';
                    break;
                case 'huy':
                    $statusClass = 'status-cancelled';
                    $statusText = 'HỦY';
                    $statusIcon = '🔄';
                    break;
            }
        @endphp

        <div style="text-align: center;">
            <span class="status-badge {{ $statusClass }}">
                {{ $statusIcon }} {{ $statusText }}
            </span>
        </div>

        <table class="info-table">
            <tr>
                <th>Ngày tăng ca:</th>
                <td>{{ $mailData['ngay_tang_ca'] }}</td>
            </tr>
            <tr>
                <th>Thời gian:</th>
                <td>{{ $mailData['gio_bat_dau'] }} - {{ $mailData['gio_ket_thuc'] }}</td>
            </tr>
            <tr>
                <th>Người phê duyệt:</th>
                <td>{{ $mailData['nguoi_duyet'] }}</td>
            </tr>
            <tr>
                <th>Thời gian phê duyệt:</th>
                <td>{{ $mailData['thoi_gian_duyet'] }}</td>
            </tr>
        </table>

        @if(in_array($mailData['trang_thai'], ['tu_choi', 'huy']) && !empty($mailData['ly_do_tu_choi']))
            <div class="reason-box">
                <div class="reason-title">
                    @if($mailData['trang_thai'] == 'tu_choi')
                        Lý do từ chối:
                    @else
                        Lý do hủy:
                    @endif
                </div>
                <div>{{ $mailData['ly_do_tu_choi'] }}</div>
            </div>
        @endif

        @if($mailData['trang_thai'] == 'da_duyet')
            <div style="background-color: #e6f4ea; border: 1px solid #a5d6a7; border-radius: 8px; padding: 15px; margin: 20px 0;">
                <p style="margin: 0; color: #2e7d32;">
                    <strong>Chúc mừng!</strong> Đăng ký tăng ca của bạn đã được phê duyệt.
                    Vui lòng thực hiện tăng ca đúng thời gian đã đăng ký.
                </p>
            </div>
        @endif

        <p>Nếu bạn có bất kỳ thắc mắc nào, vui lòng liên hệ với bộ phận Nhân sự hoặc người quản lý trực tiếp.</p>
        <a href="mailto:hr@example.com" class="cta-button">Liên hệ Nhân sự</a>

        <p>Trân trọng,<br>
        <strong>Bộ phận Nhân sự</strong></p>

        <div class="footer">
            <p>Email này được gửi tự động từ hệ thống quản lý nhân sự.</p>
            <p>⚠️ Vui lòng không trả lời email này.</p>
        </div>
    </div>
</body>
</html>
