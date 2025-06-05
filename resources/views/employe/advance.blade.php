@extends('layoutsEmploye.master')

@section('content-employee')
<section class="content-section" id="advance">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Tạm ứng lương</h2>
        <button class="btn btn-primary" onclick="showAdvanceModal()">
            <i class="fas fa-plus"></i>
            Tạo đơn tạm ứng
        </button>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Ngày tạo</th>
                    <th>Số tiền</th>
                    <th>Lý do</th>
                    <th>Trạng thái</th>
                    <th>Ngày duyệt</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>25/05/2025</td>
                    <td>5,000,000đ</td>
                    <td>Tạm ứng cá nhân</td>
                    <td><span class="status-badge status-pending">Chờ duyệt</span></td>
                    <td>-</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>15/04/2025</td>
                    <td>3,000,000đ</td>
                    <td>Chi phí y tế</td>
                    <td><span class="status-badge status-approved">Đã duyệt</span></td>
                    <td>16/04/2025</td>
                    <td>Đã chuyển khoản</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
@endsection
