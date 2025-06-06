@extends('layouts.master')

@section('content')

<div class="container">
    <h2>Tạo vai trò mới</h2>
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="ten" class="form-label">Tên vai trò</label>
            <input type="text" name="ten" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="display_name" class="form-label">Tên hiển thị</label>
            <input type="text" name="ten_hien_thi" class="form-control">
        </div>
        <div class="mb-3">
            <label for="mo_ta" class="form-label">Mô tả</label>
            <textarea name="mo_ta" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Phân quyền</label>
            <div class="row">
                @foreach($permissions as $group => $perms)
                    <div class="col-12 mb-3">
                        <div class="mb-2">
                            <strong>
                                <input type="checkbox" class="form-check-input me-2 group-check" id="group-{{ $group }}">
                                {{ $group }}
                            </strong>
                        </div>
                        <div class="row">
                            @foreach($perms->chunk(ceil($perms->count()/3)) as $chunk)
                                <div class="col-md-4">
                                    @foreach($chunk as $permission)
                                        <div class="form-check mb-1">
                                            <input class="form-check-input perm-check" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="perm{{ $permission->id }}" data-group="group-{{ $group }}">
                                            <label class="form-check-label" for="perm{{ $permission->id }}">
                                                {{ $permission->ten }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
</div>
<script>
    // Tích group sẽ tích tất cả quyền trong group
    document.querySelectorAll('.group-check').forEach(function(groupCheckbox) {
        groupCheckbox.addEventListener('change', function() {
            let group = this.id;
            document.querySelectorAll('.perm-check[data-group="' + group + '"]').forEach(function(permCheckbox) {
                permCheckbox.checked = groupCheckbox.checked;
            });
        });
    });
</script>
@endsection
