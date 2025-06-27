<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use App\Models\HoSoNguoiDung;
use Illuminate\Validation\Rule;

class HoSoNhanVienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function indexAll()
{
    $nguoiDungs = NguoiDung::with(['hoSo', 'phongBan', 'chucVu'])
        ->orderByDesc('created_at') // Nhân viên mới nhất sẽ nằm trên
        ->get();

    return view('admin.hoso.index', compact('nguoiDungs'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NguoiDung $nguoiDung)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $hoSo = HoSoNguoiDung::findOrFail($id);
        $duong_dan_quay_lai = route('hoso.all'); // trở về view duy nhất

        return view('admin.hoso.edit', compact('hoSo', 'duong_dan_quay_lai'));
    }


public function update(Request $request, $id)
{
    $hoSo = HoSoNguoiDung::findOrFail($id);

    $request->validate([
    'ho' => 'required|string|max:50',
    'ten' => 'required|string|max:50',
    'email_cong_ty' => [
        'nullable', 'email',
        Rule::unique('ho_so_nguoi_dung', 'email_cong_ty')->ignore($hoSo->id),
    ],
    'so_dien_thoai' => 'nullable|string|max:15',
    'ngay_sinh' => 'nullable|date',
    'gioi_tinh' => 'nullable|in:nam,nu,khac',
    'dia_chi_hien_tai' => 'nullable|string',
    'dia_chi_thuong_tru' => 'nullable|string',
    'cmnd_cccd' => [
        'nullable', 'string',
        Rule::unique('ho_so_nguoi_dung', 'cmnd_cccd')->ignore($hoSo->id),
    ],
    'so_ho_chieu' => 'nullable|string|max:20',
    'tinh_trang_hon_nhan' => 'nullable|in:doc_than,da_ket_hon,ly_hon,goa',
    'lien_he_khan_cap' => 'nullable|string|max:50',
    'sdt_khan_cap' => 'nullable|string|max:15',
    'quan_he_khan_cap' => 'nullable|string|max:50',
    'anh_dai_dien' => 'nullable|image|max:2048',
], [
    'ho.required' => 'Vui lòng nhập họ.',
    'ten.required' => 'Vui lòng nhập tên.',
    'email_cong_ty.email' => 'Email công ty không đúng định dạng.',
    'email_cong_ty.unique' => 'Email công ty đã tồn tại.',
    'so_dien_thoai.max' => 'Số điện thoại không quá 15 ký tự.',
    'ngay_sinh.date' => 'Ngày sinh không hợp lệ.',
    'gioi_tinh.in' => 'Giới tính không hợp lệ.',
    'cmnd_cccd.unique' => 'CMND/CCCD đã tồn tại.',
    'anh_dai_dien.image' => 'Ảnh đại diện phải là tệp hình ảnh.',
    'anh_dai_dien.max' => 'Ảnh đại diện không được vượt quá 2MB.',
]);


    // Cập nhật dữ liệu không bao gồm ảnh
    $data = $request->except(['ma_nhan_vien', 'nguoi_dung_id', 'anh_dai_dien']);
    $hoSo->update($data);

    // Nếu có ảnh thì xử lý
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
        $hoSo->save();
    }

    // Quay lại trang trước (edit) với thông báo thành công
    return redirect()->back()->with('success', 'Cập nhật hồ sơ thành công.');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NguoiDung $nguoiDung)
    {
        //
    }
}
