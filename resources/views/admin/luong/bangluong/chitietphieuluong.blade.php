@extends('layoutsAdmin.master')
@section('title', 'Chi tiết Phiếu lương')

@push('styles')
<style>
@media print {
    body * {
        visibility: hidden;
    }

    .content, .content * {
        visibility: visible;
    }

    .content {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        margin: 0;
        padding: 0;
    }

    aside, header, footer, nav, .btn, .btn * {
        display: none !important;
    }
}
</style>
@endpush

@section('content')
<div class="content-header">
    <div class="container-fluid">
        {{-- <h3 class="text-center fw-bold text-uppercase">PHIẾU LƯƠNG {{ $thang }}/{{ $nam }}</h3> --}}
    </div>
</div>

<div class="content">
    <div class="container-fluid d-flex justify-content-center">
        <div class="w-100" style="max-width: 900px;">
            <table class="table table-bordered align-middle text-center">
                <tbody>
                    <tr>
                        <td colspan="3" style="width: 100%; text-align: center; font-weight: bold;">
                            Thông tin chung
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3" style="width: 22%; vertical-align: middle;">
                            @if (!empty($base64))
                                <img src="{{ $base64 }}" alt="logo" style="width: 120px; height: auto;">
                            @else
                                <p>Không tìm thấy logo</p>
                            @endif                        </td>
                        <th class="text-start ps-3" style="width: 20%">Mã số NV:</th>
                        <td class="text-start" style="width: 20%"><span class="fw-bold bg-warning px-2">{{ $luong->nguoiDung->hoSo->ma_nhan_vien ?? '---' }}</span></td>

                    </tr>
                    <tr>
                        <th class="text-start ps-3">Tên NV:</th>
                        <td class="text-start">{{ $luong->nguoiDung->hoSo->ho }} {{ $luong->nguoiDung->hoSo->ten }}</td>

                    </tr>
                    <tr>
                        <th class="text-start ps-3">Chức vụ:</th>
                        <td class="text-start">{{ $luong->nguoiDung->chucVu->ten ?? '---' }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">

                    <tr>
                        <th style="width:5%">STT</th>
                        <th style="width:35%">Chỉ tiêu 01</th>
                        <th style="width:15%">Số tiền nhận</th>
                        <th style="width:25%">Chỉ tiêu 02</th>
                        <th style="width:20%">Giá trị liên quan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td class="text-start ps-3">Lương Cơ bản</td>
                        <td class="text-end pe-3">{{ number_format($luong->luong_co_ban) }}</td>
                        <td class="text-start ps-3">Ngày công</td>
                        <td>{{ number_format($luong->so_ngay_cong) }}</td>
                    </tr>
                    <tr class="fw-bold">
                        <td>2</td>
                        <td class="text-start ps-3">Tổng lương</td>
                        <td class="text-end pe-3">{{ number_format($luong->tong_luong) }}</td>
                        <td class="text-start ps-3">Tăng ca</td>
                        <td>{{ number_format($luong->cong_tang_ca) }}</td>

                    </tr>
                    <tr>
                        <td>3</td>
                        <td class="text-start ps-3">Phụ cấp</td>
                        <td class="text-end pe-3">{{ number_format($nhanVien->phu_cap_trach_nhiem ?? 0) }}</td>
                        <td class="text-start ps-3">Bảo hiểm</td>
                        <td class="text-end pe-3">{{ number_format($nhanVien->bao_hiem ?? 0) }}</td>
                    </tr>
                    {{-- <tr>
                        <td>4</td>
                        <td class="text-start ps-3">Tiền cơm / ngày</td>
                        <td class="text-end pe-3">{{ number_format($nhanVien->phu_cap_com ?? 0) }}</td>
                        <td class="text-start ps-3">Thuế TNCN</td>
                        <td class="text-end pe-3">{{ number_format($nhanVien->thue_tncn ?? 0) }}</td>
                    </tr> --}}
                    {{-- <tr>
                        <td>5</td>
                        <td class="text-start ps-3">Xăng xe, điện thoại</td>
                        <td class="text-end pe-3">{{ number_format($nhanVien->phu_cap_xang ?? 0) }}</td>
                        <td></td>
                        <td></td>
                    </tr> --}}
                    {{-- <tr>
                        <td>6</td>
                        <td class="text-start ps-3">Nhà ở / Con nhỏ</td>
                        <td class="text-end pe-3">{{ number_format($nhanVien->phu_cap_nhao ?? 0) }}</td>
                        <td></td>
                        <td></td>
                    </tr> --}}
                    <tr class="fw-bold">
                        <td>7</td>
                        <td class="text-start ps-3">Tổng phụ cấp</td>
                        <td class="text-end pe-3">{{ number_format(($nhanVien->phu_cap_trach_nhiem ?? 0) + ($nhanVien->phu_cap_com ?? 0) + ($nhanVien->phu_cap_xang ?? 0) + ($nhanVien->phu_cap_nhao ?? 0)) }}</td>
                        <td class="text-start ps-3">Tổng trừ</td>
                        <td class="text-end pe-3">{{ number_format(($nhanVien->bao_hiem ?? 0) + ($nhanVien->thue_tncn ?? 0)) }}</td>
                    </tr>
                    <tr class="fw-bold bg-light">
                        <td colspan="4" class="text-start ps-3">Thực lĩnh</td>
                        {{-- <td class="text-end pe-3">{{ number_format($tongLuong - (($nhanVien->bao_hiem ?? 0) + ($nhanVien->thue_tncn ?? 0))) }}</td> --}}
                        <td class="text-end pe-3">{{ number_format($luong->luong_thuc_nhan) }}</td>
                    </tr>
                </tbody>
            </table>


            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2 mt-4 no-print">
                {{-- <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print"></i> In phiếu
                </button> --}}
                @php
                    use Carbon\Carbon;
                    $thang = Carbon::parse($luong->created_at)->format('m');
                    $nam = Carbon::parse($luong->created_at)->format('Y');
                @endphp

                <a class="btn btn-danger" href="{{ route('luong.pdf', ['user_id' => $luong->nguoi_dung_id, 'thang' => $thang, 'nam' => $nam]) }}">
                     <i class="fas fa-file-pdf"></i>Xuất phiếu lương
                </a>
{{-- <a href="{{ route('luong.pdf', [
                    'user_id' => $luong->nguoi_dung_id,
                    'thang' => \Carbon\Carbon::parse($luong->created_at)->month,
                    'nam' => \Carbon\Carbon::parse($luong->created_at)->year
                ]) }}" class="btn btn-sm btn-info">
                    Xuất PDF
                </a> --}}

{{-- <a class="btn btn-danger" target="_blank"
                   href="{{ route('luong.pdf', ['user_id' => $nhanVien->nguoi_dung_id ?? $nhanVien->id, 'thang' => $thang, 'nam' => $nam]) }}">
                    <i class="fas fa-file-pdf"></i> Xuất PDF
                </a> --}}


            </div>
        </div>
    </div>
</div>
@endsection
