
@extends('layoutsEmploye.master')

@section('content-employee')
<section class="content-section" id="leave">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Đơn nghỉ phép</h2>
        <button class="btn btn-primary" onclick="showLeaveModal()">
            <i class="fas fa-plus"></i>
            Tạo đơn nghỉ phép
        </button>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Ngày tạo</th>
                    <th>Loại nghỉ</th>
                    <th>Từ ngày</th>
                    <th>Đến ngày</th>
                    <th>Lý do</th>
                    <th>Trạng thái</th>
                    <th>Phản hồi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>20/05/2025</td>
                    <td>Nghỉ có lương</td>
                    <td>25/05/2025</td>
                    <td>26/05/2025</td>
                    <td>Việc gia đình</td>
                    <td><span class="status-badge status-pending">Chờ duyệt</span></td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>10/04/2025</td>
                    <td>Nghỉ có lương</td>
                    <td>16/04/2025</td>
                    <td>16/04/2025</td>
                    <td>Khám bệnh</td>
                    <td><span class="status-badge status-approved">Đã duyệt</span></td>
                    <td>Đồng ý</td>
                </tr>
                <tr>
                    <td>01/03/2025</td>
                    <td>Nghỉ không lương</td>
                    <td>05/03/2025</td>
                    <td>07/03/2025</td>
                    <td>Du lịch</td>
                    <td><span class="status-badge status-rejected">Từ chối</span></td>
                    <td>Không đủ ngày phép</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
@endsection
