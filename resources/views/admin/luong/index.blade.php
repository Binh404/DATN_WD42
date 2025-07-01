@extends('layouts.master')
@section('title', 'Lương')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Lương</h1>
      </div>
    </div>
  </div>
</div>
<!-- Breadcrumbs End -->

@include('layouts.partials.error-message')

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between flex-wrap align-items-center mb-3">
                    <h4 class="font-weight-bold mb-0">Lương nhân sự</h4>
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
                                <th>Họ và tên</th>
                                <th>Số giờ làm</th>
                                <th>Tổng lương</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($luongTheoNguoi as $nguoi)
                                <tr>
                                    <td>{{ $nguoi->ho_ten }}</td>
                                    <td>{{ number_format($nguoi->tong_gio_lam) }}</td>
                                    <td>{{ number_format($nguoi->tong_luong) }}</td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm">
                                            Thưởng
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->
@stop
