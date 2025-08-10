<?php

namespace App\Exports;

use App\Models\Luong;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LuongCoBanExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Luong::with(['nguoiDung.hoSo', 'nguoiDung.chucVu', 'nguoiDung.hopDongLaoDong'])->get();
    }

    public function map($row): array
    {
        return [
            $row->id,
            optional($row->nguoiDung->hoSo)->ma_nhan_vien ?? '',
            trim((optional($row->nguoiDung->hoSo)->ho ?? '') . ' ' . (optional($row->nguoiDung->hoSo)->ten ?? '')),
            optional($row->nguoiDung->chucVu)->ten ?? '',
            number_format($row->luong_co_ban, 0, ',', '.'),
            number_format($row->tong_luong, 0, ',', '.'),
            // number_format($row->luong_thuc_nhan, 0, ',', '.'),
            // $row->so_ngay_cong ?? 0,
            // $row->gio_tang_ca ?? 0,
            // $row->ghi_chu ?? '',
            $row->created_at ? $row->created_at->format('d/m/Y') : '',
            optional($row->nguoiDung->hopDongLaoDong)->so_hop_dong ?? '',
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Mã nhân viên',
            'Họ và tên',
            'Chức vụ',
            'Lương cơ bản (VNĐ)',
            'Tổng lương (VNĐ)',
            'Lương thực nhận (VNĐ)',
            'Số ngày công',
            'Giờ tăng ca',
            'Ghi chú',
            'Ngày tạo',
            'Số hợp đồng',
        ];
    }
}