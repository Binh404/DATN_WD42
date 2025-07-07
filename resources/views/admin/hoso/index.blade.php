@extends('layoutsAdmin.master')
@section('title', 'Danh sách nhân sự')

@section('content')
<div class="container-fluid px-4">

    {{-- TIÊU ĐỀ + LINK XEM NHÂN SỰ NGHỈ --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0 fw-bold text-primary">Danh sách nhân sự đang làm việc</h4>
        <a href="{{ route('hoso.resigned') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-box-arrow-in-right me-1"></i> Xem danh sách đã nghỉ
        </a>
    </div>

    {{-- TÌM KIẾM --}}
    <form id="autoSearchForm" method="GET" action="{{ route('hoso.all') }}" class="input-group mb-4" style="max-width: 360px; margin-left: auto;">
        <input type="text" name="search" id="searchInput" class="form-control form-control-sm" placeholder="Tìm họ, tên, email" value="{{ request('search') }}">
    </form>

    {{-- THÔNG BÁO --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- BẢNG --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive" style="min-height: 600px;">
                <table class="table table-striped align-middle mb-0 text-center">
                    <thead class="table-light">
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
                    <tbody>
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
                                        <a href="{{ route('hoso.edit', $nv->hoSo->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('hoso.markResigned', $nv->hoSo->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Bạn có chắc muốn đánh dấu nhân viên này là đã nghỉ?')">
                                                <i class="bi bi-person-x"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted fst-italic">Chưa có hồ sơ</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted py-4">Không có dữ liệu nhân sự.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- PHÂN TRANG --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $nguoiDungs->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>

</div>

{{-- SCRIPT TÌM KIẾM --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    const input = document.getElementById('searchInput');
    const form = document.getElementById('autoSearchForm');
    const tbody = document.querySelector('tbody');

    let timeout = null;

    input.addEventListener('input', function () {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-muted">Đang tải dữ liệu...</td></tr>`;
            form.submit();
        }, 600);
    });

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-muted">Đang tải dữ liệu...</td></tr>`;
            form.submit();
        }
    });
});
</script>
@endsection
