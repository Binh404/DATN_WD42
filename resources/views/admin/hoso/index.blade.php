@extends('layouts.master')
@section('title', 'Danh sách nhân sự')

@section('content')
<div class="container mt-4">

    {{-- TÌM KIẾM --}}
    <div class="d-flex justify-content-end mb-3">
        <form id="autoSearchForm" method="GET" action="{{ route('hoso.all') }}" class="d-flex" style="width: 320px;">
            <input type="text" name="search" id="searchInput" class="form-control form-control-sm me-2"
                placeholder="Tìm họ, tên, email" value="{{ request('search') }}">
        </form>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const input = document.getElementById('searchInput');
                const form = document.getElementById('autoSearchForm');

                let timeout = null;

                input.addEventListener('input', function () {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        form.submit(); // Gửi form sau 600ms khi người dùng ngừng gõ
                    }, 600);
                });

                // Nếu người dùng ấn Enter thì submit luôn
                input.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        form.submit();
                    }
                });
            });
        </script>
    </div>

    {{-- BẢNG DANH SÁCH --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top">
            <h5 class="mb-0">Danh sách toàn bộ nhân sự</h5>
        </div>

        @if(session('success'))
            <div class="alert alert-success mx-3 mt-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive" style="min-height: 400px;"> {{-- giữ chiều cao --}}
            <table class="table table-striped align-middle mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th>Ảnh</th>
                        <th>Họ</th>
                        <th>Tên</th>
                        <th>Chức vụ</th>
                        <th>Phòng ban</th>
                        <th>Email công ty</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($nguoiDungs as $nv)
                        <tr>
                            <td>
                                @if(!empty($nv->hoSo->anh_dai_dien))
                                    <img src="{{ asset($nv->hoSo->anh_dai_dien) }}" alt="Ảnh" width="45" height="45" class="rounded-circle border">
                                @else
                                    <span class="text-muted fst-italic">Không có</span>
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
                                    <span class="text-muted fst-italic">Chưa có hồ sơ</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Không có dữ liệu nhân sự.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PHÂN TRANG --}}
    <div class="d-flex justify-content-center mt-4" style="min-height: 60px;">
        {{ $nguoiDungs->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
