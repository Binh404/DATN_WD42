@extends('layouts.master')
@section('title', 'Danh sách nhân sự')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Danh sách toàn bộ nhân sự</h5>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ảnh đại diện</th>
                            <th>Họ</th>
                            <th>Tên</th>
                            <th>Chức vụ</th>
                            <th>Phòng ban</th>
                            <th>Email công ty</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nguoiDungs as $nv)
                        <tr>
                            <td>
                                @if(!empty($nv->hoSo->anh_dai_dien))
                                    <img src="{{ asset($nv->hoSo->anh_dai_dien) }}" alt="Ảnh" width="50" height="50" class="rounded-circle">
                                @else
                                    <span class="text-muted">Không có</span>
                                @endif
                            </td>
                            <td>{{ $nv->hoSo->ho ?? 'N/A' }}</td>
                            <td>{{ $nv->hoSo->ten ?? 'N/A' }}</td>
                            <td>{{ $nv->chucVu->ten ?? 'N/A' }}</td>
                            <td>{{ $nv->phongBan->ten_phong_ban ?? 'N/A' }}</td>
                            <td>{{ $nv->hoSo->email_cong_ty ?? 'N/A' }}</td>
                            <td>{{ $nv->created_at ? $nv->created_at->format('d/m/Y') : 'N/A' }}</td>
                            <td>
                                @if(isset($nv->hoSo->id))
                                    <a href="{{ route('hoso.edit', $nv->hoSo->id) }}" class="btn btn-sm btn-outline-primary">Sửa</a>
                                @else
                                    <span class="text-muted">Chưa có hồ sơ</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Không có dữ liệu nhân sự.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
