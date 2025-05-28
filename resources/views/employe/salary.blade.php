@extends('layoutsEmploye.master')

@section('content-employee')
<section class="content-section" id="salary">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Bảng lương</h2>
        <button class="btn btn-primary">
            <i class="fas fa-download"></i>
            Tải bảng lương
        </button>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Tháng/Năm</th>
                    <th>Lương cơ bản</th>
                    <th>Phụ cấp</th>
                    <th>Thưởng</th>
                    <th>Khấu trừ</th>
                    <th>Thực nhận</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>05/2025</td>
                    <td>12,000,000đ</td>
                    <td>2,000,000đ</td>
                    <td>1,000,000đ</td>
                    <td>500,000đ</td>
                    <td>14,500,000đ</td>
                    <td><span class="status-badge status-approved">Đã thanh toán</span></td>
                    <td>
                        <button class="btn btn-secondary">
                            <i class="fas fa-eye"></i>
                            Xem chi tiết
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>04/2025</td>
                    <td>12,000,000đ</td>
                    <td>2,000,000đ</td>
                    <td>800,000đ</td>
                    <td>450,000đ</td>
                    <td>14,350,000đ</td>
                    <td><span class="status-badge status-approved">Đã thanh toán</span></td>
                    <td>
                        <button class="btn btn-secondary">
                            <i class="fas fa-eye"></i>
                            Xem chi tiết
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
@endsection

