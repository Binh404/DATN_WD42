<?php

namespace App\Http\Controllers;

use App\Models\GioLamViec;
use App\Models\NguoiDung;
use Illuminate\Http\Request;

class QuyDinhController extends Controller
{
    public function index(){
        $gioLamViec = GioLamViec::first();
        // dd($gioLamViec);
        $soNhanVien = NguoiDung::count();
       $thongTinHr = NguoiDung::with('hoSo','phongBan') // load hồ sơ
        ->whereHas('vaiTro', function($query) {
            $query->where('name', 'hr'); // lọc vai trò HR
        })
        ->first();


        // dd($thongTinHr);
        return view('quyDinh.index',compact('gioLamViec','soNhanVien', 'thongTinHr'));
    }
}
