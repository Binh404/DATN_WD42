@extends('layoutsAdmin.master')
<style>
.create-btn {
    display: inline-block;
    background-color: #4f46e5; /* Màu xanh chàm */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-bottom: 10px;
}

.create-btn:hover {
    background-color: #4338ca; /* Tối hơn khi hover */
}



</style>
@section('content')
    <div class="container mt-4">
        <h2>Danh sách tài khoản người dùng</h2>
        <a class="create-btn" href="{{route('register')}}">Tạo tài khoản</a>


        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên đăng nhập</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Trạng thái</th>
                    <th>Trạng thái công việc</th>
                    <th>Lần đăng nhập cuối</th>
                    <th>IP đăng nhập cuối</th>
                    <th>Phòng ban</th>
                    <th>Chức vụ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($taikhoan as $item)
                    @if ($item->id != Auth::id())
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->ten_dang_nhap }}</td>
                            <td>{{ $item->email }}</td>

                            <td>{{ $item->vaiTro->ten }}</td>

                            <td>{{ $item->trang_thai == 1 ? 'Hoạt động' : 'Ngưng hoạt động' }}</td>
                            <td>
                                @if ($item->trang_thai_cong_viec == 'dang_lam')
                                    Đang làm
                                @elseif ($item->trang_thai_cong_viec == 'da_nghi')
                                    Đã nghỉ
                                @endif
                            </td>
                            <td>{{ $item->lan_dang_nhap_cuoi }}</td>
                            <td>{{ $item->ip_dang_nhap_cuoi }}</td>
                            <td>{{ $item->phong_ban_id }}</td>
                            <td>{{ $item->chuc_vu_id }}</td>
                            <td>
                                <a href="{{ route('tkedit', $item->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                            </td>
                        </tr>
                    @endif
                @endforeach


            </tbody>
        </table>
    </div>
@endsection