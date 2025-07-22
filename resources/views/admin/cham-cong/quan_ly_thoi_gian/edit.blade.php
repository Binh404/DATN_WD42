@extends('layoutsAdmin.master')

@section('title', 'Sửa giờ làm việc')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cập nhật giờ làm việc</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.giolamviec.index') }}" class="btn btn-secondary btn-sm">
                        <i class="mdi mdi-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>

            <form action="{{ route('admin.giolamviec.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="gio_bat_dau" class="form-label">Giờ bắt đầu <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('gio_bat_dau') is-invalid @enderror"
                                    name="gio_bat_dau" id="gio_bat_dau"
                                    value="{{ old('gio_bat_dau', $gioLamViec->gio_bat_dau) }}">
                                @error('gio_bat_dau')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="gio_ket_thuc" class="form-label">Giờ kết thúc <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('gio_ket_thuc') is-invalid @enderror"
                                    name="gio_ket_thuc" id="gio_ket_thuc"
                                    value="{{ old('gio_ket_thuc', $gioLamViec->gio_ket_thuc) }}">
                                @error('gio_ket_thuc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="gio_nghi_trua" class="form-label">Giờ nghỉ trưa (giờ) <span class="text-danger">*</span></label>
                                <input type="number" step="0.1" min="0" max="4"
                                    class="form-control @error('gio_nghi_trua') is-invalid @enderror"
                                    name="gio_nghi_trua" id="gio_nghi_trua"
                                    value="{{ old('gio_nghi_trua', $gioLamViec->gio_nghi_trua) }}">
                                @error('gio_nghi_trua')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="so_phut_cho_phep_di_tre" class="form-label">Số phút cho phép đi trễ</label>
                                <input type="number" min="0" max="120"
                                    class="form-control @error('so_phut_cho_phep_di_tre') is-invalid @enderror"
                                    name="so_phut_cho_phep_di_tre" id="so_phut_cho_phep_di_tre"
                                    value="{{ old('so_phut_cho_phep_di_tre', $gioLamViec->so_phut_cho_phep_di_tre) }}">
                                @error('so_phut_cho_phep_di_tre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="so_phut_cho_phep_ve_som" class="form-label">Số phút cho phép về sớm</label>
                                <input type="number" min="0" max="120"
                                    class="form-control @error('so_phut_cho_phep_ve_som') is-invalid @enderror"
                                    name="so_phut_cho_phep_ve_som" id="so_phut_cho_phep_ve_som"
                                    value="{{ old('so_phut_cho_phep_ve_som', $gioLamViec->so_phut_cho_phep_ve_som) }}">
                                @error('so_phut_cho_phep_ve_som')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="gio_bat_dau_tang_ca" class="form-label">Giờ bắt đầu tăng ca</label>
                                <input type="time" class="form-control @error('gio_bat_dau_tang_ca') is-invalid @enderror"
                                    name="gio_bat_dau_tang_ca" id="gio_bat_dau_tang_ca"
                                    value="{{ old('gio_bat_dau_tang_ca', $gioLamViec->gio_bat_dau_tang_ca) }}">
                                @error('gio_bat_dau_tang_ca')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-content-save"></i> Lưu giờ làm việc
                    </button>
                    <a href="{{ route('admin.giolamviec.index') }}" class="btn btn-secondary">
                        <i class="mdi mdi-close"></i> Hủy bỏ
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
