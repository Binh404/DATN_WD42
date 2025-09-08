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
        {{-- <div class="alert alert-warning mb-0 py-2 px-3">
            <i class="fas fa-exclamation-triangle"></i>
             <strong>Quy tắc:</strong> Chỉ được tính lương tháng trước khi sang tháng mới


        </div> --}}
          {{-- <p class="form-text text-muted">Có {{ $nhanViensChuaTinhLuong->count() }} nhân viên chưa được tính lương</p> --}}
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
        @php
            $thangHienTai = now()->month;
            $namHienTai = now()->year;
            $thangTruoc = $thangHienTai == 1 ? 12 : $thangHienTai - 1;
            $namTruoc = $thangHienTai == 1 ? $namHienTai - 1 : $namHienTai;
        @endphp
        <a href="{{ route('luong.create', ['thang' => $thangTruoc, 'nam' => $namTruoc]) }}" class="btn btn-warning">
            <i class="fas fa-calculator"></i> Tính lương tháng {{ $thangTruoc }}/{{ $namTruoc }}
        </a>
        {{-- <a href="{{ route('luong.create') }}" class="btn btn-outline-warning">
            <i class="fas fa-calculator"></i> Tính lương mới
        </a> --}}
        {{-- <a href="{{ route('luong.danh-sach-da-tinh-luong') }}" class="btn btn-info">
            <i class="fas fa-list"></i> Danh sách đã tính lương
        </a> --}}
        <a href="{{ route('luong.trang-thai-hien-tai') }}" class="btn btn-primary">
            <i class="fas fa-chart-pie"></i> Trạng thái tính lương
        </a>
        {{-- <a href="{{ route('luong.kiem-tra-vi-pham') }}" class="btn btn-danger" target="_blank">
            <i class="fas fa-exclamation-triangle"></i> Kiểm tra vi phạm
        </a> --}}
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
                                    <td>{{ optional($luong->nguoiDung->chucVu)->ten ?? 'Không có chức vụ' }}</td>
                                    <td>{{ $luong->luong_thang }}/{{ $luong->luong_nam }}</td>
                                    <td>{{ number_format($luong->so_ngay_cong) }}</td>
                                    <td>{{ number_format($luong->luong_thuc_nhan, 0, ',', '.') }} VNĐ</td>
                                    <td>{{ $luong->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        {{-- <a  href="{{ route('luong.chitiet', ['id' => $luong->id, 'thang' => $thang, 'nam' => $nam]) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a> --}}
                                        <a  href="{{ route('luong.chitiet', $luong->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('luong.pdf', ['user_id' => $luong->nguoi_dung_id, 'thang' => $luong->luong_thang, 'nam' => $luong->luong_nam]) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <form action="{{ route('luong.delete', $luong->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phiếu lương này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
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
