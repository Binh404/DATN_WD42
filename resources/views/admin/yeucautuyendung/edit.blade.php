@extends('layoutsAdmin.master')
@section('title', 'Sửa Cầu Tuyển Dụng')

@section('content')

    <div class="container-fluid px-4">
        <div class="col-md-4">
            <h2 class="fw-bold text-primary mb-2">
                Yêu cầu tuyển dụng
            </h2>
        </div>

    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">
                    Chỉnh sửa
                </h5>
            </div>
        </div>
        <div class="card-body">
            <form class="forms-sample ml-5 row g-3" id="recruitmentForm"
                action="{{ route('department.yeucautuyendung.update', ['id' => $yeuCau->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Mã yêu cầu<span class="required">*</span></label>
                    <input type="text" id="ma" name="ma" value="{{ old('ma', $yeuCau->ma) }}"
                        class="form-control">
                    @error('ma')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="inputPassword4" class="form-label">Số lượng cần tuyển<span class="required">*</span></label>
                    <input type="text" id="so_luong" name="so_luong" value="{{ old('so_luong', $yeuCau->so_luong) }}"
                        class="form-control">
                    @error('so_luong')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Chức vụ<span class="required">*</span></label>
                    <select class="form-select" id="chuc_vu_id" name="chuc_vu_id">
                        <option value="">-- Chọn Chức Vụ --</option>
                        @foreach ($chucVus as $chucVu)
                            <option {{ $chucVu->id === $yeuCau->chuc_vu_id ? 'selected' : '' }} value="{{ $chucVu->id }}"
                                {{ old('chuc_vu_id') == $chucVu->id ? 'selected' : '' }}>
                                {{ $chucVu->ten }}</option>
                        @endforeach
                    </select>
                    @error('chuc_vu_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="inputPassword4" class="form-label">Loại hợp đồng<span class="required">*</span></label>
                    <select class="form-select" id="loai_hop_dong" name="loai_hop_dong">
                        <option value="">-- Chọn Loại Hợp Đồng --</option>
                        <option value="thu_viec" {{ $yeuCau->loai_hop_dong === 'thu_viec' ? 'selected' : '' }}
                            {{ old('loai_hop_dong', $hopDong->loai_hop_dong ?? '') == 'thu_viec' ? 'selected' : '' }}>Thử
                            Việc</option>
                        <option value="xac_dinh_thoi_han"
                            {{ $yeuCau->loai_hop_dong === 'xac_dinh_thoi_han' ? 'selected' : '' }}
                            {{ old('loai_hop_dong', $hopDong->loai_hop_dong ?? '') == 'xac_dinh_thoi_han' ? 'selected' : '' }}>
                            Xác Định Thời Hạn</option>
                        <option value="khong_xac_dinh_thoi_han"
                            {{ $yeuCau->loai_hop_dong === 'khong_xac_dinh_thoi_han' ? 'selected' : '' }}
                            {{ old('loai_hop_dong', $hopDong->loai_hop_dong ?? '') == 'khong_xac_dinh_thoi_han' ? 'selected' : '' }}>
                            Không Xác Định Thời Hạn</option>

                    </select>
                    @error('loai_hop_dong')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Lương tối thiểu<span class="required">*</span></label>
                    <input type="number" id="luong_toi_thieu" name="luong_toi_thieu"
                        value="{{ old('luong_toi_thieu', $yeuCau->luong_toi_thieu) }}" min="0" class="form-control">
                    @error('luong_toi_thieu')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>
                <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Lương tối đa<span class="required">*</span></label>
                    <input type="number" id="luong_toi_da" name="luong_toi_da"
                        value="{{ old('luong_toi_da', $yeuCau->luong_toi_da) }}" min="0" class="form-control">
                    @error('luong_toi_da')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Kinh nghiệm tối thiểu<span class="required">*</span></label>
                    <input type="number" id="kinh_nghiem_toi_thieu" name="kinh_nghiem_toi_thieu"
                        value="{{ old('kinh_nghiem_toi_thieu', $yeuCau->kinh_nghiem_toi_thieu) }}" min="0"
                        class="form-control">
                    @error('kinh_nghiem_toi_thieu')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>
                <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Kinh nghiệm tối đa<span class="required">*</span></label>
                    <input type="number" id="kinh_nghiem_toi_da" name="kinh_nghiem_toi_da"
                        value="{{ old('kinh_nghiem_toi_da', $yeuCau->kinh_nghiem_toi_da) }}" min="0"
                        class="form-control">
                    @error('kinh_nghiem_toi_da')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="inputPassword4" class="form-label">Trình độ học vấn<span class="required">*</span></label>
                    <select class="form-select" id="trinh_do_hoc_van" name="trinh_do_hoc_van">
                        <option value="">-- Chọn Trình Độ --</option>
                        <option value="Trung cấp"
                            {{ old('trinh_do_hoc_van', $yeuCau->trinh_do_hoc_van ?? '') == 'Trung cấp' ? 'selected' : '' }}>
                            Trung cấp</option>
                        <option value="Cao đẳng"
                            {{ old('trinh_do_hoc_van', $yeuCau->trinh_do_hoc_van ?? '') == 'Cao đẳng' ? 'selected' : '' }}>
                            Cao đẳng</option>
                        <option value="Đại học"
                            {{ old('trinh_do_hoc_van', $yeuCau->trinh_do_hoc_van ?? '') == 'Đại học' ? 'selected' : '' }}>
                            Đại học</option>

                    </select>
                    @error('trinh_do_hoc_van')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Yêu cầu ứng viên<span class="required">*</span></label>
                    <textarea class="form-control" id="yeu_cau" name="yeu_cau" value="{{ old('yeu_cau', $yeuCau->yeu_cau) }}"
                        cols="30" rows="30">1</textarea>
                    @error('yeu_cau')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="inputEmail4" class="form-label">Kỹ năng yêu cầu<span class="required">*</span></label>
                    <input type="text" name="ky_nang_yeu_cau" class="form-control"
                        value="{{ old('ky_nang_yeu_cau', is_array($yeuCau->ky_nang_yeu_cau) ? implode(', ', $yeuCau->ky_nang_yeu_cau) : $yeuCau->ky_nang_yeu_cau) }}">

                    @error('ky_nang_yeu_cau')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Ghi chú</label>
                    <input type="texty" class="form-control" id="ghi_chu" name="ghi_chu"
                        value="{{ old('ghi_chu', $yeuCau->ghi_chu) }}">
                    @error('ghi_chu')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="inputEmail4" class="form-label">Mô tả công việc<span class="required">*</span></label>
                    <textarea id="mo_ta_cong_viec" name="mo_ta_cong_viec" class="form-control" cols="10" rows="30">
                        {{ old('mo_ta_cong_viec', $yeuCau->mo_ta_cong_viec) }}
                    </textarea>

                    @error('mo_ta_cong_viec')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary me-2">Cập nhật</button>
                <button class="btn btn-light">Hủy</button>
            </form>
        </div>
    </div>


    <style>
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 4px;
        }

        .required {
            color: #e74c3c;
        }
    </style>
@endsection
