@extends('layoutsAdmin.master')

@section('content')
<div class="container">
    <h2 class="mb-4">Điền thông tin hồ sơ</h2>

    <form action="{{ route('employee.complete-profile.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            {{-- Cột bên trái --}}
            <div class="col-md-6">
                @foreach ([
                    'ho' => 'Họ',
                    'ten' => 'Tên',
                    'so_dien_thoai' => 'Số điện thoại',
                    'ngay_sinh' => 'Ngày sinh',
                    'dia_chi_hien_tai' => 'Địa chỉ hiện tại',
                    'dia_chi_thuong_tru' => 'Địa chỉ thường trú',
                    'cmnd_cccd' => 'CMND/CCCD',
                    'so_ho_chieu' => 'Số hộ chiếu'
                ] as $field => $label)
                    <div class="mb-3">
                        <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                        <input type="{{ $field == 'ngay_sinh' ? 'date' : 'text' }}" name="{{ $field }}" id="{{ $field }}"
                               class="form-control" value="{{ old($field, $hoSo->$field ?? '') }}">
                        @error($field)
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                <div class="mb-3">
                    <label for="gioi_tinh" class="form-label">Giới tính</label>
                    <select name="gioi_tinh" id="gioi_tinh" class="form-select">
                        <option value="">-- Chọn --</option>
                        <option value="nam" {{ old('gioi_tinh', $hoSo->gioi_tinh ?? '') == 'nam' ? 'selected' : '' }}>Nam</option>
                        <option value="nu" {{ old('gioi_tinh', $hoSo->gioi_tinh ?? '') == 'nu' ? 'selected' : '' }}>Nữ</option>
                        <option value="khac" {{ old('gioi_tinh', $hoSo->gioi_tinh ?? '') == 'khac' ? 'selected' : '' }}>Khác</option>
                    </select>
                    @error('gioi_tinh')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tinh_trang_hon_nhan" class="form-label">Tình trạng hôn nhân</label>
                    <select name="tinh_trang_hon_nhan" id="tinh_trang_hon_nhan" class="form-select">
                        <option value="">-- Chọn --</option>
                        <option value="doc_than" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan ?? '') == 'doc_than' ? 'selected' : '' }}>Độc thân</option>
                        <option value="da_ket_hon" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan ?? '') == 'da_ket_hon' ? 'selected' : '' }}>Đã kết hôn</option>
                        <option value="ly_hon" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan ?? '') == 'ly_hon' ? 'selected' : '' }}>Ly hôn</option>
                        <option value="goa" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan ?? '') == 'goa' ? 'selected' : '' }}>Góa</option>
                    </select>
                    @error('tinh_trang_hon_nhan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Cột bên phải --}}
            <div class="col-md-6">
                @foreach ([
                    'lien_he_khan_cap' => 'Người liên hệ khẩn cấp',
                    'sdt_khan_cap' => 'SĐT khẩn cấp',
                    'quan_he_khan_cap' => 'Quan hệ với người khẩn cấp'
                ] as $field => $label)
                    <div class="mb-3">
                        <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                        <input type="text" name="{{ $field }}" id="{{ $field }}" class="form-control"
                               value="{{ old($field, $hoSo->$field ?? '') }}">
                        @error($field)
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                <div class="mb-3">
                    <label for="email_cong_ty" class="form-label">Email công ty</label>
                    <input type="email" name="email_cong_ty" id="email_cong_ty" class="form-control"
                           value="{{ $hoSo->nguoiDung->email }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="anh_dai_dien" class="form-label">Ảnh đại diện</label>
                    <input type="file" name="anh_dai_dien" id="anh_dai_dien" class="form-control">
                    @error('anh_dai_dien')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                @if (!empty($hoSo->anh_dai_dien))
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $hoSo->anh_dai_dien) }}" alt="Ảnh đại diện" class="img-thumbnail" width="100">
                    </div>
                @endif
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
        </div>
    </form>
</div>
@endsection
