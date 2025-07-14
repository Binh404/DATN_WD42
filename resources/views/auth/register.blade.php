@extends('layoutsAdmin.master')
{{-- @section('title', 'thêm tài khoản') --}}
<style>
    select#vai_tro_id {
    color: black;

}
select.form-select {
    color: black !important;
}
</style>
@section('content')
{{-- resources/views/auth/register.blade.php --}}

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white fw-bold text-center fs-4">
                        Đăng ký tài khoản
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register.store') }}">
                            @csrf

                            {{-- Tên đăng nhập --}}
                            <div class="mb-3">
                                <label for="ten_dang_nhap" class="form-label">Tên đăng nhập</label>
                                <input type="text" id="ten_dang_nhap" name="ten_dang_nhap" value="{{ old('ten_dang_nhap') }}"
                                       class="form-control @error('ten_dang_nhap') is-invalid @enderror" required autofocus>
                                @error('ten_dang_nhap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                       class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" id="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Xác nhận mật khẩu --}}
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="form-control" required>
                            </div>

                            {{-- Vai trò --}}
                            <div class="mb-3">
                                <label for="vai_tro_id" class="form-label">Vai trò</label>
                                <select name="vai_tro_id" id="vai_tro_id" class="form-select" required>
                                    <option value="" disabled selected>-- Chọn vai trò --</option>
                                    @foreach ($vaitro as $vaitros)
                                        <option value="{{ $vaitros->id }}">{{ $vaitros->ten }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Phòng ban --}}
                            <div class="mb-3">
                                <label for="phong_ban_id" class="form-label">Phòng ban</label>
                                <select name="phong_ban_id" id="phong_ban_id" class="form-select" required>
                                    <option value="" disabled selected>-- Chọn phòng ban --</option>
                                    @foreach ($phongban as $phongBan)
                                        <option value="{{ $phongBan->id }}">{{ $phongBan->ten_phong_ban }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Chức vụ --}}
                            <div class="mb-3">
                                <label for="chuc_vu_id" class="form-label">Chức vụ</label>
                                <select name="chuc_vu_id" id="chuc_vu_id" class="form-select" required>
                                    <option value="" disabled selected>-- Chọn chức vụ --</option>
                                    {{-- Chức vụ sẽ được load tự động bằng JS --}}
                                </select>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">

                                <button type="submit" class="btn btn-primary px-4">Đăng ký</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Fetch chức vụ theo phòng ban --}}
    <script>
        document.getElementById('phong_ban_id').addEventListener('change', function () {
            const phongBanId = this.value;
            const chucVuSelect = document.getElementById('chuc_vu_id');

            chucVuSelect.innerHTML = '<option value="">-- Chọn chức vụ --</option>';

            if (phongBanId) {
                fetch(`/chuc-vus/${phongBanId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(chucVu => {
                            const option = document.createElement('option');
                            option.value = chucVu.id;
                            option.textContent = chucVu.ten;
                            chucVuSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Lỗi khi tải danh sách chức vụ:', error);
                    });
            }
        });
    </script>


@endsection
