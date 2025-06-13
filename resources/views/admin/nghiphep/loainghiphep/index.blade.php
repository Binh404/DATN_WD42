@extends('layouts.master')
@section('title', 'Loại Nghỉ Phép')

@section('content')
<style>


    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px 0;
        text-align: center;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .header h1 {
        font-size: 2.5rem;
        font-weight: 300;
        margin-bottom: 10px;
    }

    .header p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .table-container {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        background: #f8f9fa;
        padding: 20px;
        border-bottom: 1px solid #e9ecef;

    }

    .table-header h2 {
        color: #495057;
        font-size: 1.5rem;
        margin-bottom: 5px;
    }

    .table-header .btn-add {
        width: 100px;
        height: 35px;
        background-color: #138496;
        color: white;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    th {
        background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
        color: white;
        font-weight: 600;
        padding: 18px 15px;
        text-align: left;
        border-bottom: 3px solid #667eea;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        position: relative;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
    }

    th:first-child {
        border-top-left-radius: 0;
    }

    th:last-child {
        border-top-right-radius: 0;
    }

    td {
        padding: 15px 12px;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }

    tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-active {
        background-color: #d4edda;
        color: #155724;
    }

    .status-inactive {
        background-color: #f8d7da;
        color: #721c24;
    }

    .salary-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .salary-yes {
        background-color: #cce5ff;
        color: #0056b3;
    }

    .salary-no {
        background-color: #fff3cd;
        color: #856404;
    }

    .actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .btn-lnp {
        padding: 10px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: all 0.3s ease;
        width: 36px;
        height: 36px;
        position: relative;
    }

    .btn-lnp::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 16px;
        height: 16px;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }

    .btn-detail::before {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='white' viewBox='0 0 24 24'%3E%3Cpath d='M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z'/%3E%3C/svg%3E");
    }

    .btn-edit::before {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23212529' viewBox='0 0 24 24'%3E%3Cpath d='M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0L15.13 5.12l3.75 3.75 1.83-1.83z'/%3E%3C/svg%3E");
    }

    .btn-delete::before {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='white' viewBox='0 0 24 24'%3E%3Cpath d='M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z'/%3E%3C/svg%3E");
    }

    .btn-detail {
        background-color: #17a2b8;
        color: white;
    }

    .btn-detail:hover {
        background-color: #138496;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .btn-edit {
        background-color: #ffc107;
        color: #212529;
    }

    .btn-edit:hover {
        background-color: #e0a800;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background-color: #c82333;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .code {
        font-family: 'Courier New', monospace;
        background-color: #f8f9fa;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.9rem;
        color: #495057;
        border: 1px solid #dee2e6;
    }

    .date-text {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .name-text {
        font-weight: 600;
        color: #495057;
    }

    @media (max-width: 768px) {
        .container {
            padding: 10px;
        }
        
        .header h1 {
            font-size: 2rem;
        }
        
        table {
            font-size: 0.85rem;
        }
        
        th, td {
            padding: 10px 8px;
        }
        
        .actions {
            flex-direction: column;
            gap: 4px;
        }
        
        .btn-lnp {
            font-size: 0.8rem;
            padding: 6px 12px;
        }
    }
</style>

    <div class="container">
        <div class="header">
            <h1>Quản lý loại nghỉ phép</h1>
            <p>Danh sách các loại nghỉ phép trong hệ thống</p>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h2>Danh sách loại nghỉ phép</h2>
                <a href="{{ route('hr.loainghiphep.create') }}">
                    <button class="btn-lnp btn-add">Thêm mới</button>
                </a>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên loại nghỉ phép</th>
                        <th>Mã loại nghỉ phép</th>
                        <th>Có lương</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Ngày cập nhật</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td class="name-text">Nghỉ phép năm</td>
                        <td><span class="code">ANNUAL</span></td>
                        <td><span class="salary-badge salary-yes">Có lương</span></td>
                        <td><span class="status-badge status-active">Hoạt động</span></td>
                        <td class="date-text">15/01/2024 09:30</td>
                        <td class="date-text">20/05/2024 14:15</td>
                        <td>
                            <div class="actions">
                                <a href="{{route('hr.loainghiphep.show',  123)}}">
                                    <button class="btn-lnp btn-detail" onclick="viewDetail(1)" title="Xem chi tiết"></button>
                                </a>
                                <a href="{{route('hr.loainghiphep.edit', 123)}}">
                                    <button class="btn-lnp btn-edit" onclick="editRecord(1)" title="Chỉnh sửa"></button>
                                </a>
                                <button class="btn-lnp btn-delete" onclick="deleteRecord(1)" title="Xóa"></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td class="name-text">Nghỉ ốm</td>
                        <td><span class="code">SICK</span></td>
                        <td><span class="salary-badge salary-yes">Có lương</span></td>
                        <td><span class="status-badge status-active">Hoạt động</span></td>
                        <td class="date-text">15/01/2024 09:35</td>
                        <td class="date-text">15/01/2024 09:35</td>
                        <td>
                            <div class="actions">
                                <button class="btn-lnp btn-detail" onclick="viewDetail(2)" title="Xem chi tiết"></button>
                                <button class="btn-lnp btn-edit" onclick="editRecord(2)" title="Chỉnh sửa"></button>
                                <button class="btn-lnp btn-delete" onclick="deleteRecord(2)" title="Xóa"></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td class="name-text">Nghỉ thai sản</td>
                        <td><span class="code">MATERNITY</span></td>
                        <td><span class="salary-badge salary-yes">Có lương</span></td>
                        <td><span class="status-badge status-active">Hoạt động</span></td>
                        <td class="date-text">15/01/2024 09:40</td>
                        <td class="date-text">10/03/2024 11:20</td>
                        <td>
                            <div class="actions">
                                <button class="btn-lnp btn-detail" onclick="viewDetail(3)" title="Xem chi tiết"></button>
                                <button class="btn-lnp btn-edit" onclick="editRecord(3)" title="Chỉnh sửa"></button>
                                <button class="btn-lnp btn-delete" onclick="deleteRecord(3)" title="Xóa"></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td class="name-text">Nghỉ không lương</td>
                        <td><span class="code">UNPAID</span></td>
                        <td><span class="salary-badge salary-no">Không lương</span></td>
                        <td><span class="status-badge status-active">Hoạt động</span></td>
                        <td class="date-text">15/01/2024 09:45</td>
                        <td class="date-text">15/01/2024 09:45</td>
                        <td>
                            <div class="actions">
                                <button class="btn-lnp btn-detail" onclick="viewDetail(4)" title="Xem chi tiết"></button>
                                <button class="btn-lnp btn-edit" onclick="editRecord(4)" title="Chỉnh sửa"></button>
                                <button class="btn-lnp btn-delete" onclick="deleteRecord(4)" title="Xóa"></button>
                            </div>
                        </td>
                    </tr>
        
                </tbody>
            </table>
        </div>
    </div>



    <script>
        function viewDetail(id) {
            alert('Xem chi tiết loại nghỉ phép ID: ' + id);
            // Thực hiện chuyển hướng hoặc mở modal chi tiết
        }

        function editRecord(id) {
            alert('Chỉnh sửa loại nghỉ phép ID: ' + id);
            // Thực hiện chuyển hướng đến trang chỉnh sửa
        }

        function deleteRecord(id) {
            if (confirm('Bạn có chắc chắn muốn xóa loại nghỉ phép này?')) {
                alert('Đã xóa loại nghỉ phép ID: ' + id);
                // Thực hiện xóa bản ghi
            }
        }
    </script>
@endsection

