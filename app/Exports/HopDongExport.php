<?php

namespace App\Exports;

use App\Models\HopDongLaoDong;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class HopDongExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $hopDongs;

    public function __construct($hopDongs = null)
    {
        $this->hopDongs = $hopDongs;
    }

    public function collection()
    {
        if ($this->hopDongs) {
            return $this->hopDongs;
        }
        
        return HopDongLaoDong::with(['hoSoNguoiDung', 'chucVu', 'nguoiHuy.hoSo'])->get();
    }

    public function headings(): array
    {
        return [
            'STT',
            'Số hợp đồng',
            'Mã nhân viên',
            'Họ và tên',
            'Email công ty',
            'Chức vụ',
            'Loại hợp đồng',
            'Ngày bắt đầu',
            'Ngày kết thúc',
            'Lương cơ bản (VNĐ)',
            'Phụ cấp (VNĐ)',
            'Hình thức làm việc',
            'Địa điểm làm việc',
            'Trạng thái hợp đồng',
            'Trạng thái ký',
            'Ghi chú',
            'Ngày tạo',
            'Ngày cập nhật'
        ];
    }

    public function map($hopDong): array
    {
        static $stt = 0;
        $stt++;

        return [
            $stt,
            $hopDong->so_hop_dong,
            $hopDong->hoSoNguoiDung ? $hopDong->hoSoNguoiDung->ma_nhan_vien : 'N/A',
            $hopDong->hoSoNguoiDung ? ($hopDong->hoSoNguoiDung->ho . ' ' . $hopDong->hoSoNguoiDung->ten) : 'N/A',
            $hopDong->hoSoNguoiDung ? $hopDong->hoSoNguoiDung->email_cong_ty : 'N/A',
            $hopDong->chucVu ? $hopDong->chucVu->ten : $hopDong->chuc_vu,
            $this->getLoaiHopDongText($hopDong->loai_hop_dong),
            $hopDong->ngay_bat_dau ? $hopDong->ngay_bat_dau->format('d/m/Y') : 'N/A',
            $hopDong->ngay_ket_thuc ? $hopDong->ngay_ket_thuc->format('d/m/Y') : 'Không xác định',
            number_format($hopDong->luong_co_ban, 0, ',', '.'),
            number_format($hopDong->phu_cap, 0, ',', '.'),
            $hopDong->hinh_thuc_lam_viec,
            $hopDong->dia_diem_lam_viec,
            $this->getTrangThaiHopDongText($hopDong->trang_thai_hop_dong),
            $this->getTrangThaiKyText($hopDong->trang_thai_ky),
            $hopDong->ghi_chu ?? 'Không có',
            $hopDong->created_at ? $hopDong->created_at->format('d/m/Y H:i:s') : 'N/A',
            $hopDong->updated_at ? $hopDong->updated_at->format('d/m/Y H:i:s') : 'N/A'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style cho header
        $sheet->getStyle('A1:R1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Style cho toàn bộ bảng
        $sheet->getStyle('A1:R' . ($this->collection()->count() + 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Căn giữa cho các cột số
        $sheet->getStyle('A:A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G:G')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H:I')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('N:O')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('Q:R')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Wrap text cho các cột có nội dung dài
        $sheet->getStyle('M:M')->getAlignment()->setWrapText(true);
        $sheet->getStyle('P:P')->getAlignment()->setWrapText(true);

        return $sheet;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // STT
            'B' => 20,  // Số hợp đồng
            'C' => 15,  // Mã nhân viên
            'D' => 25,  // Họ và tên
            'E' => 30,  // Email công ty
            'F' => 20,  // Chức vụ
            'G' => 20,  // Loại hợp đồng
            'H' => 15,  // Ngày bắt đầu
            'I' => 15,  // Ngày kết thúc
            'J' => 18,  // Lương cơ bản
            'K' => 18,  // Phụ cấp
            'L' => 20,  // Hình thức làm việc
            'M' => 25,  // Địa điểm làm việc
            'N' => 20,  // Trạng thái hợp đồng
            'O' => 15,  // Trạng thái ký
            'P' => 30,  // Ghi chú
            'Q' => 20,  // Ngày tạo
            'R' => 20,  // Ngày cập nhật
        ];
    }

    private function getLoaiHopDongText($loaiHopDong)
    {
        switch ($loaiHopDong) {
            case 'thu_viec':
                return 'Thử việc';
            case 'xac_dinh_thoi_han':
                return 'Xác định thời hạn';
            case 'khong_xac_dinh_thoi_han':
                return 'Không xác định thời hạn';
            case 'mua_vu':
                return 'Mùa vụ';
            default:
                return 'Không xác định';
        }
    }

    private function getTrangThaiHopDongText($trangThai)
    {
        switch ($trangThai) {
            case 'tao_moi':
                return 'Tạo mới';
            case 'hieu_luc':
                return 'Đang hiệu lực';
            case 'chua_hieu_luc':
                return 'Chưa hiệu lực';
            case 'het_han':
                return 'Hết hạn';
            case 'huy_bo':
                return 'Đã hủy';
            default:
                return 'Không xác định';
        }
    }

    private function getTrangThaiKyText($trangThaiKy)
    {
        switch ($trangThaiKy) {
            case 'cho_ky':
                return 'Chờ ký';
            case 'da_ky':
                return 'Đã ký';
            default:
                return 'Không xác định';
        }
    }
} 