<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChucVuController extends Controller
{
    public function getByPhongBan($phongBanId)
    {
        $chucVus = \App\Models\ChucVu::where('phong_ban_id', $phongBanId)->get();

        return response()->json($chucVus);
    }
}
