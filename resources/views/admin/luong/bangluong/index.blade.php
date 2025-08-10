@extends('layoutsAdmin.master')
@section('title', 'Lương')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif
<!-- Breadcrumbs Start -->
{{-- <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Lương</h1>
      </div>
    </div>
  </div>
</div> --}}
<!-- Breadcrumbs End -->

{{-- @include('layouts.partials.error-message') --}}

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between flex-wrap align-items-center mb-3">
    <!-- Bên trái -->
    <div class="d-flex align-items-end gap-3 flex-wrap">
        <h3 class="font-weight-bold mb-0">Phiếu Lương</h3>
       <form method="GET" action="{{ route('luong.index') }}" class="d-flex flex-wrap gap-2 align-items-end">
                        <div class="me-2">
                            <select name="thang" id="thang" class="form-select">
                                <option value="">Tất cả</option>
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
                    </form>
    </div>

    <!-- Bên phải -->
    <div class="d-flex gap-2">
        <a href="{{ route('luong.export.luong') }}" class="btn btn-success">📤 Xuất Excel</a>
        <form action="{{ route('luong.gui-mail-tat-ca') }}" method="POST">
            @csrf
            <input type="hidden" name="thang" value="{{ $thang }}">
            <input type="hidden" name="nam" value="{{ $nam }}">
            <button type="submit" class="btn btn-primary">Gửi tất cả phiếu lương</button>
        </form>
    </div>
</div>


                <div class="table-responsive">
                    <table id="salary" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã bảng lương</th>
                                <th>Họ và tên</th>
                                <th>Chức vụ</th>
                                <th>Lương tháng</th>
                                <th>Ngày công</th>
                                <th>Thực lãnh</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($luongs as $index => $luong)
                                <tr>
                                    <td>{{ ($luongs->currentPage() - 1) * $luongs->perPage() + $loop->iteration }}</td>
                                   <td>{{ $luong->bangLuong->ma_bang_luong ?? 'Không có mã' }}</td>

                                    {{-- <td>{{ optional($luong->nguoiDung->hoSo)->ho . ' ' . optional($luong->nguoiDung->hoSo)->ten ?? 'Không có tên' }}</td> --}}
                                    <td>
                                        @if(isset($luong->nguoiDung->hoSo))
                                            {{ $luong->nguoiDung->hoSo->ho . ' ' . $luong->nguoiDung->hoSo->ten }}
                                        @else
                                            Không có tên
                                        @endif
                                    </td>
                                    <td>{{ $luong->nguoiDung->chucVu->ten ?? 'Không có chức vụ' }}</td>
                                    <td>{{ number_format($luong->luong_co_ban) }} đ</td>

                                    <td>{{ number_format($luong->so_ngay_cong) }}</td>

                                    <td class="text-success fw-bold">{{ number_format($luong->luong_thuc_nhan) }} đ</td>
                                    <td>
                                        {{-- {{ $luong->bangLuong->ngay ?? '-' }}/{{ $luong->bangLuong->thang ?? '-' }}/{{ $luong->bangLuong->nam ?? '-' }} --}}
                                        {{ $luong->bangLuong->created_at ? $luong->bangLuong->created_at->format('d/m/Y') : '-' }}
                                    </td>
                                    {{-- <td></td> --}}
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">

                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('luong.chitiet', ['id' => $luong->id, 'thang' => $thang, 'nam' => $nam]) }}">
                                                        <i class="mdi mdi-eye"></i> Xem chi
                                                        tiết
                                                    </a>
                                                </li>

                                                <li>
                                                    <form action="{{ route('luong.delete', $luong->id) }}" method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Bạn có chắc muốn xoá?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('Bạn có chắc muốn xoá?')" class="dropdown-item"><i
                                                                class="mdi mdi-delete me-2"></i>Xoá</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- Pagination --}}
                </div>

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

</style>
@stop
