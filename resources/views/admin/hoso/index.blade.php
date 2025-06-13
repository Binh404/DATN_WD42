@extends('layouts.master')
@section('title', 'Employee')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Danh sách nhân viên</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Họ</th>
                            <th>Tên</th>
                            <th>Phòng ban</th>
                            <th>Chức vụ</th>
                            <th>Email công ty</th>
                            <th>Nút</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nhanVien as $nv)
                        <tr>
                            <td>{{ $nv->hoSo->ho ?? 'N/A' }}</td>
                            <td>{{ $nv->hoSo->ten ?? 'N/A' }}</td>
                            <td>{{ $nv->phongBan->ten ?? 'N/A' }}</td>
                            <td>{{ $nv->chucVu->ten ?? 'N/A' }}</td>
                            <td>{{ $nv->email }}</td>
                            <td>
                                <a href="{{ route('hoso.edit', $nv->hoSo->id ?? 0) }}">Sửa</a>
                                
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Không có dữ liệu nhân viên.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

