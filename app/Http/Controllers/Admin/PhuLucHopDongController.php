<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhuLucHopDong;
use Illuminate\Http\Request;

class PhuLucHopDongController extends Controller
{
    public function show(PhuLucHopDong $phuLuc)
    {
        // Eager load related data for efficiency
        $phuLuc->load(['hopDong.hoSoNguoiDung', 'chucVu', 'nguoiTao.hoSo']);

        return view('admin.hopdong.phuluc.show', compact('phuLuc'));
    }
}
