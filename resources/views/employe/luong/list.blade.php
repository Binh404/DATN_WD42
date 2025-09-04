@extends('layoutsAdmin.master')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Phiếu lương của tôi</h2>

    <form method="GET" class="row mb-4">
        <div class="col-md-2">
            <select name="thang" class="form-control">
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('thang') == $i ? 'selected' : '' }}>Tháng {{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2">
            <select name="nam" class="form-control">
                @for ($i = date('Y'); $i >= 2022; $i--)
                    <option value="{{ $i }}" {{ request('nam') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" type="submit">Lọc</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Tháng/Năm</th>
                <th>Ngày tạo</th>
                <th>Lương cơ bản</th>
                <th>Ngày công</th>
                <th>Công tăng ca</th>
                <th>Lương thực nhận</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($luongs as $luong)
            <tr>
                <td>
                    {{ $luong->luong_thang }}/{{ $luong->luong_nam }}
                </td>
                <td>
                    {{ $luong->created_at ? $luong->created_at->format('d/m/Y') : '/' }}
                </td>
                <td>{{ number_format($luong->luong_co_ban) }} VNĐ</td>
                <td>{{ number_format($luong->so_ngay_cong) }}</td>
                <td>{{ number_format($luong->cong_tang_ca) }}</td>
                <td><strong>{{ number_format($luong->luong_thuc_nhan) }} VNĐ</strong></td>
                <td>
                    <a class="dropdown-item" href="{{ route('luong.pdf.employee', ['thang' => $luong->luong_thang, 'nam' => $luong->luong_nam]) }}">
                       <i class="mdi mdi-download"></i> Tải PDF
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">Không có dữ liệu lương.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
