<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ChamCongTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\ChamCongImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class ImportChamCongController extends Controller
{
    public function showImportForm()
    {
        return view('admin.cham-cong.import');
    }
    public function import(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240', // Max 10MB
        ], [
            'file.required' => 'Vui lòng chọn file để import',
            'file.mimes' => 'File phải có định dạng Excel (.xlsx, .xls) hoặc CSV',
            'file.max' => 'File không được vượt quá 10MB',
        ]);

        try {
            $file = $request->file('file');

            // Tạo import instance
            $import = new ChamCongImport();

            // Thực hiện import
            Excel::import($import, $file);

            // Lấy thông tin import
            $errors = $import->getErrors();
            $successCount = $import->getSuccessCount();
            $skipCount = $import->getSkipCount();
            // dd($successCount, $skipCount, $errors);
            // Chuẩn bị thông báo
            $message = "Import hoàn thành!";
            $messageType = 'success';

            if ($successCount > 0) {
                $message .= " Đã import thành công {$successCount} bản ghi.";
            }

            if ($skipCount > 0) {
                $message .= " Đã bỏ qua {$skipCount} bản ghi.";
                $messageType = 'warning';
            }

            if (!empty($errors)) {
                $messageType = 'error';
                $message .= " Có " . count($errors) . " lỗi xảy ra.";
            }

            return back()->with([
                'message' => $message,
                'messageType' => $messageType,
                'importResults' => [
                    'success' => $successCount,
                    'skip' => $skipCount,
                    'errors' => $errors,
                ],
            ]);

        } catch (Throwable $e) {
            Log::error('Import ChamCong failed: ' . $e->getMessage());

            return back()->with([
                'message' => 'Có lỗi xảy ra trong quá trình import: ' . $e->getMessage(),
                'messageType' => 'error',
            ]);
        }
    }
    public function downloadTemplate()
    {
        $templatePath = storage_path('app/private/templates/cham-cong-template.xlsx');

        if (!file_exists($templatePath)) {
            // Tạo file template nếu chưa có
            // dd('template');
            $this->createTemplate();
        }

        return response()->download($templatePath, 'cham-cong-tang-ca-template.xlsx');
    }

    private function createTemplate()
    {
        // Tạo dữ liệu mẫu
        $templateData = collect([
            [
                'STT' => 1,
                'Mã NV' => 'NV0001',
                'Họ và tên' => 'Nguyễn Văn A',
                'Email' => 'nguyenvana@email.com',
                'Ngày chấm công' => '01/01/2025',
                'Thứ' => 'Thứ 2',
                'Giờ vào' => '08:30',
                'Giờ ra' => '15:30',
                'Trạng thái' => 'Đã duyệt',
                'Ghi chú' => 'Đi muộn',
            ],
            [
                'STT' => 2,
                'Mã NV' => 'NV0002',
                'Họ và tên' => 'Trần Thị B',
                'Email' => 'tranthib@email.com',
                'Ngày chấm công' => '02/01/2025',
                'Thứ' => 'Thứ 3',
                'Giờ vào' => '08:30',
                'Giờ ra' => '15:30',
                'Trạng thái' => 'Chờ duyệt',
                'Ghi chú' => 'Quên ko chấm công',
            ]
        ]);

        // Tạo thư mục templates nếu chưa có
        $templateDir = storage_path('app/templates');
        if (!is_dir($templateDir)) {
            mkdir($templateDir, 0755, true);
        }

        // Export template
        Excel::store(new ChamCongTemplateExport($templateData), 'templates/cham-cong-template.xlsx');
    }
}
