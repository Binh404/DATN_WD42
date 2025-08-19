@extends('layoutsAdmin.master')
@section('title', 'Lương')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between flex-wrap align-items-center mb-3">
    <h3 class="font-weight-bold mb-0">Danh sách lương cơ bản</h3>

    <div class="d-flex gap-2 align-items-end">
        <!-- Form tìm kiếm trước -->
        {{-- <form method="GET" action="{{ route('luong.list') }}" class="d-flex flex-wrap gap-2 align-items-end">
            <div class="me-2">
                <select name="thang" id="thang" class="form-select">
                    <option value="">Tất cả tháng</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $thang == $i ? 'selected' : '' }}>Tháng {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="me-2">
                <select name="nam" id="nam" class="form-select">
                    <option value="">Tất cả năm</option>
                    @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}" {{ $nam == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form> --}}

        <!-- Nút xuất Excel sau -->
        <a href="{{ route('luong.export.luongcb') }}" class="btn btn-success">📤 Xuất Excel</a>
    </div>
</div>


                <div class="table-responsive">
                    <table id="salary" class="table table-sm table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Họ và tên</th>
                                <th>Chức vụ</th>
                                <th>Số hợp đồng</th>
                                <th>Lương cơ bản</th>
                                <th>Phụ cấp</th>
                                <th>Tổng lương</th>
                                <th>Ngày tạo</th>
                                <th>Ngày bắt đầu hiệu lực</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($luongs as $index => $luong)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if(isset($luong->nguoiDung->hoSo))
                                            {{ $luong->nguoiDung->hoSo->ho . ' ' . $luong->nguoiDung->hoSo->ten }}
                                        @else
                                            Không có tên
                                        @endif
                                    </td>
                                    <td>{{ $luong->nguoiDung->chucVu->ten ?? 'Không có chức vụ' }}</td>
                                    <td>{{ $luong->hopDongLaoDong->so_hop_dong ?? 'Không có hợp đồng' }}</td>
                                    <td>{{ number_format($luong->luong_co_ban) }} đ</td>
                                    <td>{{ number_format($luong->phu_cap) }} đ</td>
                                    <td class="text-success fw-bold">{{ number_format($luong->luong_co_ban + $luong->phu_cap) }} đ</td>
                                    <td>{{ $luong->created_at ? $luong->created_at->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $luong->updated_at ? $luong->updated_at->format('d/m/Y') : '-' }}</td>

                                    <td>
                                        <div class="dropdown position-static">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('luong.edit', $luong->id) }}">
                                                        <i class="mdi mdi-eye"></i> Sửa
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('luong.delete', $luong->id) }}" method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Bạn có chắc muốn xoá?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="dropdown-item">
                                                            <i class="mdi mdi-delete me-2"></i> Xoá
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex" style="justify-content: right; padding-right: 20px;margin-bottom: 15px;">
                {{-- Pagination links --}}
                {{ $luongs->links() }}
                </div>

        </div>
    </div>
</div>
<!-- Main Content End -->
<style>
    .table-responsive {
    overflow: visible !important;
}

.table-responsive table {
    margin-bottom: 0; /* tránh bị tràn */
}

.pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 6px;
}

.pagination li {
    display: inline-block;
}

.pagination li a,
.pagination li span {
    display: block;
    padding: 8px 14px;
    border: 1px solid #ddd;
    border-radius: 6px;
    background-color: #fff;
    color: #333;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
}

.pagination li a:hover {
    background-color: #f0f0f0;
    border-color: #bbb;
}

.pagination .active span {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
    font-weight: bold;
}

.pagination .disabled span {
    color: #aaa;
    background-color: #f9f9f9;
    border-color: #ddd;
    cursor: not-allowed;
}

.content-wrapper{
    padding: 0px;
}

</style>
@stop
