<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phiếu lương tháng {{ $thang }}/{{ $nam }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            line-height: 1.6;
            background: #f9f9f9;
            color: #333;
            margin: 40px;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        h4 {
            text-align: center;
            font-size: 16px;
            color: #555;
            margin-top: 0;
        }

        .logo {
            width: 100px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background: #fff;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px 12px;
            text-align: left;
        }

        thead {
            background-color: #ecf0f1;
        }

        tbody tr:nth-child(even) {
            background-color: #f6f6f6;
        }

        td strong {
            font-weight: bold;
            color: #2c3e50;
        }

        .text-right {
            text-align: right;
        }

        .highlight {
            background-color: #dff0d8;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="2">
                @if($base64)
                    <img src="{{ $base64 }}" class="logo" alt="Logo">
                @endif
            </td>
            <td colspan="2" class="text-right">
                <strong>Tháng:</strong> {{ $thang }}/{{ $nam }}<br>
                <strong>Ngày in:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}
            </td>
        </tr>
    </table>

    <h2>PHIẾU LƯƠNG NHÂN VIÊN</h2>
    <h4>Họ tên: {{ $nhanVien }} | Phòng: {{ $phongBan }} | Chức vụ: {{ $chucVu }}</h4>

    <table>
        <thead>
            <tr>
                <th style="width: 10%">STT</th>
                <th style="width: 50%">Chỉ tiêu</th>
                <th style="width: 40%">Số tiền / Số giờ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Lương cơ bản</td>
                <td>{{ number_format($luongCoBan) }} VNĐ</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Số ngày công</td>
                <td>{{ number_format($soCong) }} ngày</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Giờ tăng ca</td>
                <td>{{ number_format($gioTangCa) }} giờ</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Công tăng ca</td>
                <td>{{ number_format($congTangCa) }} </td>
            </tr>
            <tr>
                <td>5</td>
                <td>Tổng lương</td>
                <td>{{ number_format($tongLuong) }} VNĐ</td>
            </tr>
            <tr class="highlight">
                <td>6</td>
                <td>Thực nhận</td>
                <td><strong>{{ number_format($luongThucNhan) }} </strong>VNĐ</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
