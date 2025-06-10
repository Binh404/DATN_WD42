@extends('layouts.master')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="container">
    <h2>Danh sách vai trò</h2>
    <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">Thêm vai trò</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên vai trò</th>
                <th>Tên hiển thị</th>
                <th>Mô tả</th>
                <th>Level</th>
                <th>Hệ thống</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $role->ten }}</td>
                    <td>{{ $role->ten_hien_thi }}</td>
                    <td>{{ $role->mo_ta }}</td>
                    <td>{{ $role->la_vai_tro_he_thong }}</td>
                    <td>{{ $role->trang_thai ? '✔' : '' }}</td>
                    <td>
                        <a href="#" class="btn btn-warning btn-sm">Sửa</a>
                         <form action="/vaitro/delete/{{$role->id}}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger btn-sm rounded-pill delete-btn" onclick="return confirm('Bạn có muốn xóa không?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
