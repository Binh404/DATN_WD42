@extends('layouts.master')
@section('title', 'Danh Sách Ứng Viên')

@section('content')

<div class="container mt-4">
    <h2 class="text-center mb-4 fw-bold text-primary">📋 Danh sách Ứng Viên</h2>
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm rounded">
            <thead class="table-primary text-center">
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên Ứng Viên</th>
                    <th scope="col">Email</th>
                    <th scope="col">Số Điện Thoại</th>
                    <th scope="col">Kinh Nghiệm</th>
                    <th scope="col">Kỹ Năng</th>
                    <th scope="col">Vị Trí</th>
                    <th scope="col">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ungViens as $key => $uv)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $uv->ten_ung_vien }}</td>
                    <td>{{ $uv->email }}</td>
                    <td>{{ $uv->so_dien_thoai }}</td>
                    <td>{{ $uv->kinh_nghiem }}</td>
                    <td>{{ $uv->ky_nang }}</td>
                    <td>{{ $uv->tinTuyenDung->tieu_de }}</td>
                    <td class="text-center">
                        <a href="/ungvien/show/{{ $uv->id }}" class="btn btn-sm btn-info text-white me-1">Xem</a>
                        <form action="/ungvien/delete/{{ $uv->id }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa ứng viên này không?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

<style>
    table tr:hover {
        background-color: #f0f8ff !important;
        transition: background 0.3s ease;
    }

    .btn-info:hover {
        background-color: #0d6efd !important;
    }
</style>