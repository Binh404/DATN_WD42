@extends('layouts.master')

@section('content')

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
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->display_name }}</td>
                    <td>{{ $role->description }}</td>
                    <td>{{ $role->level }}</td>
                    <td>{{ $role->is_system ? '✔' : '' }}</td>
                    <td>
                        <a href="#" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="#" class="btn btn-danger btn-sm">Xóa</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
