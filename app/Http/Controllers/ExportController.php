<?php

namespace App\Http\Controllers;

use App\Exports\ChamCongExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
// use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Xuất file Excel - File sẽ được tải xuống trực tiếp
     */
    public function exportExcel()
    {
        // File sẽ được tạo và tải xuống ngay lập tức
        // Không lưu trên server
        // return Excel::download(new ChamCongExport, 'cham-cong.xlsx');
    }

    /**
     * Xuất file CSV - File sẽ được tải xuống trực tiếp
     */
    public function exportCsv()
    {
        // File sẽ được tạo và tải xuống ngay lập tức
        // Không lưu trên server
        // return Excel::download(new ChamCongExport(), 'cham-cong.csv');
    }
}
