@extends('layouts.master')
@section('title', 'Hồ sơ trưởng phòng')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Danh sách trưởng phòng</h5>
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
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($truongPhong as $nv)
                        <tr>
                            <td>{{ $nv->hoSo->ho ?? 'N/A' }}</td>
                            <td>{{ $nv->hoSo->ten ?? 'N/A' }}</td>
                            <td>{{ $nv->phongBan->ten ?? 'N/A' }}</td>
                            <td>{{ $nv->chucVu->ten ?? 'N/A' }}</td>
                            <td>{{ $nv->email }}</td>
                            <td><a href="{{ route('hoso.edit', $nv->hoSo->id ?? 0) }}">Sửa</a></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Không có trưởng phòng nào.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
