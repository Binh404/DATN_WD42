@extends('layouts.master')
@section('title', 'Phiếu lương')

@section('content')
<div class="container mt-4">
    <h3>Phiếu lương theo tháng</h3>
    <form method="GET" action="{{ route('phieuluong.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="thang">Tháng</label>
            <select name="thang" class="form-select">
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $thang == $i ? 'selected' : '' }}>Tháng {{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3">
            <label for="nam">Năm</label>
            <select name="nam" class="form-select">
                @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                    <option value="{{ $i }}" {{ $nam == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Họ tên</th>
                    {{-- <th>Số giờ làm</th> --}}
                    <th>Lương</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($luongTheoNguoi as $nguoi)
                                        <tr>
                                            <td>{{ $nguoi['ho_ten'] }}</td>
                                            {{-- <td>{{ number_format($nguoi['tong_gio_lam']) }}</td> --}}
                                            <td>{{ number_format($nguoi['tong_luong']) }}</td>
                                            <td>
                                            <a href="{{ route('luong.chitiet', [
                                                'user_id' => $nguoi['id'],
                                                'thang' => request('thang', now()->month),
                                                'nam' => request('nam', now()->year)
                                            ]) }}" class="btn btn-info btn-sm">
                                                Xem chi tiết
                                            </a>

                                        </td>
                                        </tr>
                                    @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
