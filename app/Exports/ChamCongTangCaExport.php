<?php

namespace App\Exports;

use App\Models\ChamCong;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ChamCongTangCaExport implements WithMultipleSheets
{
    protected $chamCong;
    protected $statistics;

    public function __construct($chamCong, $statistics = null)
    {
        $this->chamCong = $chamCong;
        $this->statistics = $statistics;
    }

    public function sheets(): array
    {
        $sheets = [
            new ChamCongTangCaDataSheet($this->chamCong)
        ];

        if ($this->statistics) {
            $sheets[] = new ChamCongTangCaStatisticsSheet($this->statistics);
        }

        return $sheets;
    }
}

class ChamCongTangCaDataSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $chamCong;

    public function __construct($chamCong)
    {
        $this->chamCong = $chamCong;
    }

    public function collection()
    {
        return $this->chamCong;
    }

    public function headings(): array
    {
        return [
            'STT',
            'Mã NV',
            'Họ và tên',
            'Email',
            'Phòng ban',
            'Ngày chấm công',
            'Thứ',
            'Giờ vào thực tế',
            'Giờ ra thực tế',
            'Số giờ làm',
            'Số công',
            'Trạng thái',
            'Ghi chú',
        ];
    }

    public function map($chamCong): array
    {
        static $stt = 0;
        $stt++;

        return [
            $stt,
            'NV' . str_pad($chamCong->dangKyTangCa->nguoiDung->id, 4, '0', STR_PAD_LEFT),
            ($chamCong->dangKyTangCa->nguoiDung->hoSo->ho ?? 'N/A') . ' ' . ($chamCong->dangKyTangCa->nguoiDung->hoSo->ten ?? 'N/A'),
            $chamCong->dangKyTangCa->nguoiDung->email,
            $chamCong->dangKyTangCa->nguoiDung->phongBan->ten_phong_ban ?? 'N/A',
            Carbon::parse($chamCong->dangKyTangCa->ngay_tang_ca)->format('d/m/Y'),
            Carbon::parse($chamCong->dangKyTangCa->ngay_tang_ca)->locale('vi')->dayName,
            $chamCong->gio_bat_dau_thuc_te ? Carbon::parse($chamCong->gio_bat_dau_thuc_te)->format('H:i') : '',
            $chamCong->gio_ket_thuc_thuc_te ? Carbon::parse($chamCong->gio_ket_thuc_thuc_te)->format('H:i') : '',
            $chamCong->so_gio_tang_ca_thuc_te ? number_format($chamCong->so_gio_tang_ca_thuc_te, 1) : '',
            $chamCong->so_cong_tang_ca ? number_format($chamCong->so_cong_tang_ca, 1) : '',
            $this->getTrangThaiText($chamCong->trang_thai),
            $chamCong->ghi_chu ?? '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:M1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => '4472C4']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Tạo border cho toàn bộ dữ liệu
        $lastRow = $this->chamCong->count() + 1;
        $sheet->getStyle('A1:M' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Căn giữa các cột số
        $sheet->getStyle('A:A')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B:B')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('F:F')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('H:M')->getAlignment()->setHorizontal('center');

        return [];
    }

    public function title(): string
    {
        return 'Dữ liệu chấm công';
    }



    private function getTrangThaiText($trangThai)
    {
        $trangThaiMap = [
            'chua_lam' => 'Chưa làm',
            'dang_lam' => 'Đang làm',
            'hoan_thanh' => 'Hoàn thành',
            'khong_hoan_thanh' => 'Không hoàn thành',
        ];

        return $trangThaiMap[$trangThai] ?? $trangThai;
    }

    private function getTrangThaiDuyetText($trangThaiDuyet)
    {
        switch ($trangThaiDuyet) {
            case 1:
                return 'Đã duyệt';
            case 2:
                return 'Từ chối';
            case 3:
                return 'Chờ duyệt';
            default:
                return 'Chưa gửi';
        }
    }
}

class ChamCongTangCaStatisticsSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $statistics;

    public function __construct($statistics)
    {
        $this->statistics = $statistics;
    }

    public function collection()
    {
        return collect([
            ['label' => 'Kỳ báo cáo', 'value' => $this->statistics['period']['start'] . ' - ' . $this->statistics['period']['end']],
            ['label' => 'Tổng số bản ghi', 'value' => $this->statistics['total_records']],
            ['label' => 'Tổng số nhân viên', 'value' => $this->statistics['total_employees']],
            ['label' => 'Tổng số giờ làm', 'value' => number_format($this->statistics['total_hours'], 1) . ' giờ'],
            ['label' => 'Tổng số công', 'value' => number_format($this->statistics['total_workdays'], 1) . ' công'],
            ['label' => '', 'value' => ''],
            ['label' => 'THỐNG KÊ THEO TRẠNG THÁI', 'value' => ''],
            ['label' => 'Bình thường', 'value' => $this->statistics['status_breakdown']['binh_thuong']],
            ['label' => 'Đi muộn', 'value' => $this->statistics['status_breakdown']['di_muon']],
            ['label' => 'Về sớm', 'value' => $this->statistics['status_breakdown']['ve_som']],
            ['label' => 'Vắng mặt', 'value' => $this->statistics['status_breakdown']['vang_mat']],
            ['label' => 'Nghỉ phép', 'value' => $this->statistics['status_breakdown']['nghi_phep']],
            ['label' => '', 'value' => ''],
            ['label' => 'THỐNG KÊ PHÊ DUYỆT', 'value' => ''],
            ['label' => 'Đã duyệt', 'value' => $this->statistics['approval_status']['approved']],
            ['label' => 'Từ chối', 'value' => $this->statistics['approval_status']['rejected']],
            ['label' => 'Chờ duyệt', 'value' => $this->statistics['approval_status']['pending']],
        ]);
    }

    public function headings(): array
    {
        return [
            'Chỉ tiêu',
            'Giá trị'
        ];
    }

    public function map($item): array
    {
        return [
            $item['label'],
            $item['value']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->getStyle('A1:B1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => '70AD47']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Section headers
        $sheet->getStyle('A7:B7')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'E2EFDA']
            ]
        ]);

        $sheet->getStyle('A14:B14')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'E2EFDA']
            ]
        ]);

        // Borders for all data
        $sheet->getStyle('A1:B18')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        return [];
    }

    public function title(): string
    {
        return 'Thống kê tổng hợp';
    }
}
