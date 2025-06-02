<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\TinTuyenDung;
use Illuminate\Http\Request;

class TuyenDungController extends Controller
{
    //
    public function getJob()
    {
        $tuyenDung = TinTuyenDung::get();
        return view('homePage.job', compact('tuyenDung'));
    }
    public function getJobDetail($id)
    {
        $tuyenDung = TinTuyenDung::findOrFail($id);

        $relateJob = TinTuyenDung::where('id', '!=', $id) // Loại trừ tin hiện tại
        ->orderByDesc('luong_toi_da') // Sắp xếp lương giảm dần
        ->take(3)
        ->get();
        return view('homePage.detailJob', compact('tuyenDung','relateJob'));
    }

}