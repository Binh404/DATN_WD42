@extends('layoutsAdmin.master')
@section('title', 'Chi tiết phụ lục hợp đồng')

@php
    // Helper function to format values for display
    function format_value($value, $is_money = false) {
        if ($is_money) {
            return number_format($value, 0, ',', '.') . ' VNĐ';
        }
        return $value;
    }

    // Helper function to render a comparison row in the table
    function render_comparison_row($label, $old_value, $new_value, $is_money = false) {
        $old_formatted = format_value($old_value, $is_money);
        $new_formatted = format_value($new_value, $is_money);
        $highlight_class = $old_formatted !== $new_formatted ? 'table-warning' : '';

        echo "<tr>";
        echo "<th style='width: 200px;'>{$label}</th>";
        echo "<td>{$old_formatted}</td>";
        echo "<td class='{$highlight_class}'><strong>{$new_formatted}</strong></td>";
        echo "</tr>";
    }
@endphp

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Chi tiết phụ lục: {{ $phuLuc->so_phu_luc }}</h6>
            <a href="{{ route('hopdong.show', $phuLuc->hop_dong_id) }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại hợp đồng gốc
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- General Info -->
                <div class="col-md-6">
                    <h4>Thông tin chung</h4>
                    <table class="table table-bordered">
                        <tr><th style="width: 200px;">Hợp đồng gốc</th><td>{{ $phuLuc->hopDong->so_hop_dong }}</td></tr>
                        <tr><th>Nhân viên</th><td>{{ $phuLuc->hopDong->hoSoNguoiDung->ho . ' ' . $phuLuc->hopDong->hoSoNguoiDung->ten }}</td></tr>
                        <tr><th>Tên phụ lục</th><td>{{ $phuLuc->ten_phu_luc ?? 'Không có' }}</td></tr>
                        <tr><th>Ngày ký</th><td>{{ $phuLuc->ngay_ky->format('d/m/Y') }}</td></tr>
                        <tr><th>Ngày hiệu lực PL</th><td>{{ $phuLuc->ngay_hieu_luc->format('d/m/Y') }}</td></tr>
                        <tr><th>Trạng thái ký</th>
                            <td>
                                @if($phuLuc->trang_thai_ky == 'da_ky')
                                    <span class="badge badge-success">Đã ký</span>
                                @else
                                    <span class="badge badge-warning">Chờ ký</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- File and Creator Info -->
                <div class="col-md-6">
                    <h4>Thông tin khác</h4>
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px;">Người tạo</th>
                            <td>{{ $phuLuc->nguoiTao->hoSo->ho . ' ' . $phuLuc->nguoiTao->hoSo->ten }}</td>
                        </tr>
                        <tr>
                            <th>Tệp đính kèm</th>
                            <td>
                                @if($phuLuc->tep_dinh_kem)
                                    <a href="{{ asset('storage/' . $phuLuc->tep_dinh_kem) }}" target="_blank" class="btn btn-info btn-sm">
                                        <i class="fas fa-file-download"></i> Tải về
                                    </a>
                                @else
                                    Không có
                                @endif
                            </td>
                        </tr>
                        <tr><th>Ghi chú</th><td>{{ $phuLuc->ghi_chu ?? 'Không có' }}</td></tr>
                    </table>
                </div>
            </div>

            <!-- Comparison Table -->
            <div class="row mt-4">
                <div class="col-12">
                    <h4>Nội dung thay đổi</h4>
                    <p>{{ $phuLuc->noi_dung_thay_doi }}</p>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nội dung</th>
                                    <th>Giá trị cũ</th>
                                    <th>Giá trị mới (từ phụ lục)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $hopDongGoc = $phuLuc->hopDong;
                                    render_comparison_row('Vị trí công việc', $hopDongGoc->chucVu->ten, $phuLuc->chucVu->ten);
                                    render_comparison_row('Loại hợp đồng', $hopDongGoc->loai_hop_dong, $phuLuc->loai_hop_dong);
                                    render_comparison_row('Ngày kết thúc', $hopDongGoc->ngay_ket_thuc->format('d/m/Y'), $phuLuc->ngay_ket_thuc->format('d/m/Y'));
                                    render_comparison_row('Lương cơ bản', $hopDongGoc->luong_co_ban, $phuLuc->luong_co_ban, true);
                                    render_comparison_row('Phụ cấp', $hopDongGoc->phu_cap, $phuLuc->phu_cap, true);
                                    render_comparison_row('Hình thức làm việc', $hopDongGoc->hinh_thuc_lam_viec, $phuLuc->hinh_thuc_lam_viec);
                                    render_comparison_row('Địa điểm làm việc', $hopDongGoc->dia_diem_lam_viec, $phuLuc->dia_diem_lam_viec);
                                @endphp
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
