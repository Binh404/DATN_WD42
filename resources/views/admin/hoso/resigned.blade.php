@extends('layoutsAdmin.master')
@section('title', 'Nhân sự đã nghỉ việc')

@section('content')
<div class="container-fluid px-4">

    {{-- TIÊU ĐỀ + NÚT QUAY LẠI --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Danh sách nhân sự đã nghỉ việc</h2>
        <a href="{{ route('hoso.all') }}" class="btn btn-secondary btn-sm rounded-pill">
            <i class="bi bi-arrow-left-circle me-1"></i> Quay về danh sách đang làm
        </a>
    </div>

    {{-- TÌM KIẾM --}}
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card mt-4">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"><i class="mdi mdi-magnify me-2"></i> Tìm kiếm</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('hoso.resigned') }}">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    {{-- Ô tìm kiếm --}}
                                    <div class="col-md-8 mb-3">
                                        <label for="search" class="form-label">Tìm theo tên, họ, email</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="mdi mdi-account-search"></i>
                                            </span>
                                            <input type="text" name="search" id="searchInput"
                                                class="form-control form-control-sm"
                                                placeholder="Tìm họ, tên, email ..."
                                                value="{{ request('search') }}">
                                        </div>
                                    </div>

                                    {{-- Nút tìm & làm mới --}}
                                    <div class="col-md-4 mb-3">
                                        <div class="d-flex gap-2 mt-4">
                                            <button type="submit" class="btn btn-primary btn-sm py-2">
                                                <i class="mdi mdi-magnify me-1"></i> Tìm kiếm
                                            </button>
                                            <a href="{{ route('hoso.resigned') }}" class="btn btn-secondary btn-sm py-2">
                                                <i class="mdi mdi-refresh me-1"></i> Làm mới
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- THÔNG BÁO --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- BẢNG DỮ LIỆU --}}
    <div class="card shadow-sm border-0 rounded-4 mt-4">
        <div class="card-body p-0">
            <div class="table-responsive" style="min-height: 600px;">
                <table class="table table-hover align-middle mb-0 text-center">
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
                                        <img src="{{ asset($nv->hoSo->anh_dai_dien) }}" alt="Ảnh" width="45" height="45"
                                            class="rounded-circle border shadow-sm object-fit-cover">
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
                                    <form action="{{ route('hoso.restore', $nv->hoSo->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-success rounded-pill"
                                            onclick="return confirm('Khôi phục nhân viên này về trạng thái đang làm?')">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Khôi phục
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted py-4">Không có dữ liệu nhân sự nghỉ việc.</td>
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
@endsection
