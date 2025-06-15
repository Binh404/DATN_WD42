<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\SoDuNghiPhepNhanVien;
use Illuminate\Http\Request;

class SoDuNghiPhepController extends Controller
{
    public function index(){
        $user = auth()->user();
        $soDuNghiPhep = SoDuNghiPhepNhanVien::with('loaiNghiPhep')->where('nguoi_dung_id', $user->id)->get();
        return view('employe.nghiphep.soDuNghiPhep', compact('soDuNghiPhep'));
    }
}
