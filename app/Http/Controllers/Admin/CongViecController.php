<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CongViec;
use Illuminate\Http\Request;

class CongViecController extends Controller
{
    public function index() {
        $congviecs = CongViec::orderBy('id', 'desc')->get();
        return view('admin.congviec.index', compact('congviecs'));
    }
}
