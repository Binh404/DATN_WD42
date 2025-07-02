<?php

namespace App\Http\Controllers\employee;

use Illuminate\Http\Request;
use App\Models\HoSoNguoiDung;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
   public function show()
{
    $nguoiDungId = Auth::id();
    $hoSo = HoSoNguoiDung::where('nguoi_dung_id', $nguoiDungId)->first();

    if (!$hoSo) {
        return redirect()->back()->with('error', 'Chưa có hồ sơ.');
    }

    return view('employe.profile', compact('hoSo'));
}

public function update(Request $request)
{
    $request->validate([
        'ho' => 'required|string|max:50',
        'ten' => 'required|string|max:50',
        'so_dien_thoai' => 'nullable|string|max:20',
        'ngay_sinh' => 'nullable|date',
        'gioi_tinh' => 'nullable|in:nam,nu,khac',
        'dia_chi_hien_tai' => 'nullable|string',
        'anh_dai_dien' => 'nullable|image|max:2048',
    ]);

    $nguoiDungId = Auth::id();
    $hoSo = HoSoNguoiDung::where('nguoi_dung_id', $nguoiDungId)->first();

    if (!$hoSo) {
        return redirect()->back()->with('error', 'Không tìm thấy hồ sơ.');
    }

    $hoSo->fill($request->except('anh_dai_dien'));

    if ($request->hasFile('anh_dai_dien')) {
        
        $file = $request->file('anh_dai_dien');
    $filename = time() . '.' . $file->getClientOriginalExtension();
    $path = storage_path('app/public/anh_dai_dien/' . $filename);

    if (!file_exists(dirname($path))) {
        mkdir(dirname($path), 0777, true);
    }

    file_put_contents($path, file_get_contents($file));

    // Cập nhật đường dẫn trong CSDL
    $hoSo->anh_dai_dien = 'storage/anh_dai_dien/' . $filename;

    }

    $hoSo->save();

    return redirect()->back()->with('success', 'Cập nhật hồ sơ thành công.');
}
    /**
     * Delete the user's account.
     */
   
}
