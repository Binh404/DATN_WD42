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
        return Luong::with(['nguoiDung.hoSo', 'nguoiDung.chucVu', 'hopDongLaoDong'])->get();
    }

    public function map($row): array
    {
        return [
            $row->id,
            optional($row->nguoiDung->hoSo)->ma_nhan_vien ?? '',
            trim((optional($row->nguoiDung->hoSo)->ho ?? '') . ' ' . (optional($row->nguoiDung->hoSo)->ten ?? '')),
            optional($row->nguoiDung->chucVu)->ten ?? '',
            optional($row->hopDongLaoDong)->so_hop_dong ?? '',
            number_format($row->luong_co_ban, 0, ',', '.') . ' đ',
            number_format($row->phu_cap, 0, ',', '.') . ' đ',
            number_format($row->tong_luong, 0, ',', '.') . ' đ',
            // number_format($row->luong_thuc_nhan, 0, ',', '.'),
            // $row->so_ngay_cong ?? 0,
            // $row->gio_tang_ca ?? 0,
            // $row->ghi_chu ?? '',
            $row->created_at ? $row->created_at->format('d/m/Y') : '',
            $row->updated_at ? $row->updated_at->format('d/m/Y') : '',


        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Mã nhân viên',
            'Họ và tên',
            'Chức vụ',
            'Số hợp đồng',
            'Lương cơ bản (VNĐ)',
            'Phụ cấp (VNĐ)',
            'Tổng lương (VNĐ)',
            'Ngày tạo',
            'Ngày bắt đầu hiệu lực',

        ];
    }
}