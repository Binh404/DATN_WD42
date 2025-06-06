<?php

namespace App\Exports;

use App\Models\UngTuyen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UngTuyenExport implements FromCollection, WithHeadings
{
    protected $data;
   
    public function collection()
    {
        $this->data = UngTuyen::with('tinTuyenDung')->get()->map(function ($ungTuyen) {
            return [
                'id' => $ungTuyen->id,
                'ma_ung_vien' => $ungTuyen->ma_ung_tuyen,
                'vi_tri_tuyen_dung' => optional($ungTuyen->tinTuyenDung)->tieu_de,
                'ten_ung_vien' => $ungTuyen->ten_ung_vien,
                'email' => $ungTuyen->email,
                'so_dien_thoai' => $ungTuyen->so_dien_thoai,
                'kinh_nghiem' => $ungTuyen->kinh_nghiem,
                'ky_nang' => $ungTuyen->ky_nang,
                'thu_gioi_thieu' => $ungTuyen->thu_gioi_thieu,
                'cv_url' => url(asset('storage/' . $ungTuyen->tai_cv)),
                'ngay_ung_tuyen' => $ungTuyen->created_at->format('Y-m-d'),
            ];
        });

        return $this->data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Mã ứng viên',
            'Vị trí tuyển dụng',
            'Tên Ứng Viên',
            'Email',
            'Số Điện Thoại',
            'Kinh Nghiệm',
            'Kỹ Năng',
            'Thư Giới Thiệu',
            'CV Ứng Tuyển',
            'Ngày Ứng Tuyển',
        ];
    }
}
