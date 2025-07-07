<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //\
    public function index()
    { $nguoiDungs = NguoiDung::with(['hoSo', 'phongBan', 'chucVu'])->get();
        return view('admin.dashboard.index', compact('nguoiDungs'));
    }

}
