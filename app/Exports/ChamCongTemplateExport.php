<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Collection;

/**
 * Class ChamCongTemplateExport
 * Handles exporting attendance data to Excel with custom formatting
 */
class ChamCongTemplateExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithDefaultStyles, ShouldAutoSize, WithTitle
{
    /**
     * @var Collection
     */
    protected Collection $data;

    /**
     * @param Collection|array $data
     * @throws \InvalidArgumentException
     */
    public function __construct($data)
    {
        if (is_array($data)) {
            $data = collect($data);
        }

        if (!$data instanceof Collection) {
            throw new \InvalidArgumentException('Data must be an array or Collection');
        }

        $this->data = $data;
    }

    /**
     * Get the data collection for export
     *
     * @return Collection
     */
    public function collection(): Collection
    {
        return $this->data;
    }

    /**
     * Define column headings
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'STT',
            'Mã NV',
            'Họ và tên',
            'Email',
            'Ngày chấm công',
            'Thứ',
            'Giờ vào',
            'Giờ ra',
            'Trạng thái',
            'Ghi chú',
        ];
    }

    /**
     * Define the Excel sheet title
     *
     * @return string
     */
    public function title(): string
    {
        return 'Dữ liệu chấm công';
    }

    /**
     * Apply styles to worksheet
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet): array
    {
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
                'name' => 'Times New Roman'
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => '4472C4']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];

        // Apply header style
        $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);

        // Apply data style only to needed rows
        $rowCount = $this->data->count() + 1; // +1 for header
        if ($rowCount > 1) {
            $sheet->getStyle("A2:J{$rowCount}")->applyFromArray($dataStyle);
        }

        // Set row heights
        $sheet->getRowDimension(1)->setRowHeight(25);
        for ($i = 2; $i <= $rowCount; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(20);
        }

        return [];
    }

    /**
     * Define column widths
     *
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 8,   // STT
            'B' => 12,  // Mã NV
            'C' => 20,  // Họ và tên
            'D' => 25,  // Email
            'E' => 15,  // Ngày chấm công
            'F' => 10,  // Thứ
            'G' => 12,  // Giờ vào
            'H' => 12,  // Giờ ra
            'I' => 15,  // Trạng thái
            'J' => 20,  // G clonalWidth
        ];
    }

    /**
     * Define default styles for the sheet
     *
     * @param Style $defaultStyle
     * @return array
     */
    public function defaultStyles(Style $defaultStyle): array
    {
        return [
            'font' => [
                'name' => 'Times New Roman',
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
    }
}
