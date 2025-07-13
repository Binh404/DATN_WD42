@extends('layoutsAdmin.master')
@section('title', 'Lương')

@section('content')
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

@include('layouts.partials.error-message')

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between flex-wrap align-items-center mb-3">

                    <h3 class="font-weight-bold mb-0">Lương</h3>

 <a href="{{ route('luong.export.luong') }}" class="btn btn-success">📤 Xuất Excel</a>
                    <form method="GET" action="{{ route('luong.index') }}" class="d-flex flex-wrap gap-2 align-items-end">
                        <div class="me-2">
                            <label for="thang" class="form-label mb-0">Tháng</label>
                            <select name="thang" id="thang" class="form-select">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $thang == $i ? 'selected' : '' }}>Tháng {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="me-2">
                            <label for="nam" class="form-label mb-0">Năm</label>
                            <select name="nam" id="nam" class="form-select">
                                @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                    <option value="{{ $i }}" {{ $nam == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Tìm kiếm
                            </button>
                        </div>
                    </form>
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
                                <th>Chi tiết</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($luongs as $index => $luong)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
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
                                        <a href="{{ route('luong.chitiet', ['id' => $luong->id, 'thang' => $thang, 'nam' => $nam]) }}"
                                            class="btn btn-info btn-sm">
                                                Xem chi tiết
                                            </a>


                                    </td>
                                    <td>
                                         <form action="{{ route('luong.delete', $luong->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn xoá?')">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Bạn có chắc muốn xoá?')" class="btn btn-danger btn-sm">Xoá</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- Pagination --}}
                </div>

            </div>

            <div class="d-flex" style="justify-content: right; padding-right: 20px;">
                {{ $luongs->links() }}
            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->
@stop
