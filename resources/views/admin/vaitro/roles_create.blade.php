@extends('layouts.master')

@section('content')
@include('layouts.partials.statistics')
<div class="container">
    <h2>Tạo vai trò mới</h2>
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên vai trò</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="display_name" class="form-label">Tên hiển thị</label>
            <input type="text" name="display_name" class="form-control">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Phân quyền</label>
            <div class="row">
                @foreach($permissions as $group => $perms)
                    <div class="col-md-4 mb-2">
                        <strong>{{ $group }}</strong>
                        @foreach($perms as $permission)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="perm{{ $permission->id }}">
                                <label class="form-check-label" for="perm{{ $permission->id }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
</div>
@endsection
