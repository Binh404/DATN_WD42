<?php

namespace App\Exports;

use App\Models\LuongNhanVien;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LuongNhanVienExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return LuongNhanVien::with('nguoiDung', 'nguoiDung.hoSo', 'nguoiDung.chucVu')->get();
    }

    public function map($row): array
    {
        return [
            $row->id,
            optional($row->nguoiDung->hoSo)->ma_nhan_vien ?? '',
            optional($row->nguoiDung->hoSo)->ho . ' ' . optional($row->nguoiDung->hoSo)->ten ?? '',
            optional($row->nguoiDung->chucVu)->ten ?? '',
            $row->luong_co_ban,
            $row->tong_luong,
            $row->luong_thuc_nhan,
            $row->so_ngay_cong,
            $row->gio_tang_ca,
            $row->ghi_chu,
            $row->created_at->format('d-m-Y'),
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Mã NV',
            'Họ tên',
            'Chức vụ',
            'Lương cơ bản',
            'Tổng lương',
            'Lương thực nhận',
            'Số ngày công',
            'Giờ tăng ca',
            'Ghi chú',
            'Ngày tạo',
        ];
    }
}
