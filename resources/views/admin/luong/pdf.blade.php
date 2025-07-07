<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid #000; padding: 5px; }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .text-start { text-align: left; }
        .fw-bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="content-header">
    <div class="container-fluid">
        <h3 class="text-center fw-bold text-uppercase">PHIẾU LƯƠNG {{ $thang }}/{{ $nam }}</h3>
    </div>
</div>

<div class="content">
    <div class="container-fluid d-flex justify-content-center">
        <div class="w-100" style="max-width: 900px;">
            <table class="table table-bordered align-middle text-center">
                <tbody>
                    <tr>
                        <td rowspan="3" style="width: 22%; vertical-align: middle;">
                            <img src="{{ $base64 }}" alt="logo" style="width: 118px; height: auto;">
                        </td>
                        <th class="text-start ps-3" style="width: 20%">Mã số NV:</th>
                        <td class="text-start" style="width: 20%"><span class="fw-bold bg-warning px-2">{{ $nhanVien->ma_nhan_vien ?? '---' }}</span></td>

                    </tr>
                    <tr>
                        <th class="text-start ps-3">Tên NV:</th>
                        <td class="text-start">{{ $nhanVien->ho }} {{ $nhanVien->ten }}</td>

                    </tr>
                    <tr>
                        <th class="text-start ps-3">Chức vụ:</th>
                        <td class="text-start">{{ $nhanVien->chuc_vu ?? '---' }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:5%">STT</th>
                        <th style="width:35%">Chỉ tiêu 01</th>
                        <th style="width:15%">Thành tiền 01</th>
                        <th style="width:25%">Chỉ tiêu 02</th>
                        <th style="width:20%">Thành tiền 02</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td class="text-start ps-3">Lương Cơ bản</td>
                        <td class="text-end pe-3">{{ number_format($tongLuong) }}</td>
                        <td class="text-start ps-3">Ngày công</td>
                        <td>{{ $soCong }}</td>
                    </tr>
                    <tr class="fw-bold">
                        <td>2</td>
                        <td class="text-start ps-3">Tổng lương</td>
                        <td class="text-end pe-3">{{ number_format($tongLuong) }}</td>
                        <td class="text-start ps-3">Tăng ca</td>
                        <td>-</td>
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
                        <td class="text-end pe-3">{{ number_format($tongLuong - (($nhanVien->bao_hiem ?? 0) + ($nhanVien->thue_tncn ?? 0))) }}</td>
                    </tr>
                </tbody>
            </table>


            <!-- Buttons -->
            {{-- <div class="d-flex justify-content-end gap-2 mt-4 no-print">
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print"></i> In phiếu
                </button>
                <a class="btn btn-danger" target="_blank"
                   href="{{ route('luong.pdf', ['user_id' => $nhanVien->nguoi_dung_id ?? $nhanVien->id, 'thang' => $thang, 'nam' => $nam]) }}">
                    <i class="fas fa-file-pdf"></i> Xuất PDF
                </a>
            </div> --}}
        </div>
    </div>
</div>
</body>
</html>
