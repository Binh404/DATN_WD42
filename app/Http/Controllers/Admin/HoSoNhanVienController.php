<?php

namespace App\Http\Controllers\Admin;

use App\Models\NguoiDung;
use Illuminate\Http\Request;
use App\Models\HoSoNguoiDung;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class HoSoNhanVienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function indexAll(Request $request)
{
    $keyword = $request->input('search');

    $nguoiDungs = NguoiDung::with(['hoSo', 'phongBan', 'chucVu'])
        // ->where('trang_thai_cong_viec', 'dang_lam') // chỉ lấy nhân viên đang làm
        ->whereHas('hoSo', function ($query) {
            $query->where('trang_thai_cong_viec', 'dang_lam');
        })
        ->when($keyword, function ($query) use ($keyword) {
            $query->whereHas('hoSo', function ($subQuery) use ($keyword) {
                $subQuery->where('ho', 'like', "%$keyword%")
                         ->orWhere('ten', 'like', "%$keyword%")
                         ->orWhere('email_cong_ty', 'like', "%$keyword%");
            });
        })
        ->orderByDesc('created_at')
        ->paginate(10);

    return view('admin.hoso.index', compact('nguoiDungs', 'keyword'));
}
// Danh sách đã nghỉ việc
public function indexResigned(Request $request)
{
    $keyword = $request->input('search');

    $nguoiDungs = NguoiDung::with(['hoSo', 'phongBan', 'chucVu'])
        ->where('trang_thai_cong_viec', 'da_nghi') // <-- lọc ở đây mới đúng
        ->when($keyword, function ($query) use ($keyword) {
            $query->whereHas('hoSo', function ($subQuery) use ($keyword) {
                $subQuery->where('ho', 'like', "%$keyword%")
                         ->orWhere('ten', 'like', "%$keyword%")
                         ->orWhere('email_cong_ty', 'like', "%$keyword%");
            });
        })
        ->orderByDesc('created_at')
        ->paginate(10);

    return view('admin.hoso.resigned', compact('nguoiDungs', 'keyword'));
}


// Đánh dấu nghỉ việc
public function markResigned($id)
{
    $hoSo = HoSoNguoiDung::findOrFail($id);
    $nguoiDung = $hoSo->nguoiDung; // lấy bản ghi liên kết từ bảng nguoi_dung

    if ($nguoiDung) {
        $nguoiDung->trang_thai_cong_viec = 'da_nghi';
        $nguoiDung->save();
    }

    return redirect()->route('hoso.all')->with('success', 'Đã đánh dấu nhân viên nghỉ việc.');
}
// Khôi phục nhân viên
public function restore($id)
{
    $hoSo = HoSoNguoiDung::findOrFail($id);
    $nguoiDung = $hoSo->nguoiDung;

    if ($nguoiDung) {
        $nguoiDung->trang_thai_cong_viec = 'dang_lam';
        $nguoiDung->save();
    }

    return redirect()->route('hoso.resigned')->with('success', 'Đã khôi phục nhân viên về trạng thái đang làm.');
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

    $validated = $request->validate([
        'ho' => 'required|string|max:50',
        'ten' => 'required|string|max:50',
        'so_dien_thoai' => 'required|string|max:20|regex:/^[0-9]{9,15}$/',
        'ngay_sinh' => 'required|date',
        'gioi_tinh' => 'required|in:nam,nu,khac',
        'dia_chi_hien_tai' => 'required|string|max:255',
        'dia_chi_thuong_tru' => 'required|string|max:255',
        'cmnd_cccd' => [
            'required', 'string', 'regex:/^[0-9]{9,12}$/',
            Rule::unique('ho_so_nguoi_dung', 'cmnd_cccd')->ignore($hoSo->id),
        ],
        'so_ho_chieu' => 'nullable|string|max:20',
        'tinh_trang_hon_nhan' => 'required|in:doc_than,da_ket_hon,ly_hon,goa',
        'anh_dai_dien' => 'nullable|image|max:2048',
        'lien_he_khan_cap' => 'nullable|string|max:100',
        'sdt_khan_cap' => 'nullable|string|max:20|regex:/^[0-9]{9,15}$/',
        'quan_he_khan_cap' => 'nullable|string|max:50',
    ], [
        'ho.required' => 'Vui lòng nhập họ.',
        'ten.required' => 'Vui lòng nhập tên.',
        'so_dien_thoai.required' => 'Vui lòng nhập số điện thoại.',
        'so_dien_thoai.regex' => 'Số điện thoại không đúng định dạng.',
        'ngay_sinh.required' => 'Vui lòng chọn ngày sinh.',
        'ngay_sinh.date' => 'Ngày sinh không hợp lệ.',
        'gioi_tinh.required' => 'Vui lòng chọn giới tính.',
        'dia_chi_hien_tai.required' => 'Vui lòng nhập địa chỉ hiện tại.',
        'dia_chi_thuong_tru.required' => 'Vui lòng nhập địa chỉ thường trú.',
        'cmnd_cccd.required' => 'Vui lòng nhập CMND/CCCD.',
        'cmnd_cccd.regex' => 'CMND/CCCD không đúng định dạng.',
        'cmnd_cccd.unique' => 'CMND/CCCD đã tồn tại trong hệ thống.',
        'tinh_trang_hon_nhan.required' => 'Vui lòng chọn tình trạng hôn nhân.',
        'anh_dai_dien.image' => 'Ảnh đại diện phải là tệp hình ảnh.',
        'anh_dai_dien.max' => 'Ảnh đại diện tối đa 2MB.',
        'sdt_khan_cap.regex' => 'SĐT khẩn cấp không đúng định dạng.',
    ]);

    // Không cho sửa các trường đặc biệt
    unset($validated['ma_nhan_vien'], $validated['nguoi_dung_id'], $validated['email_cong_ty']);

    $hoSo->update($validated);

    // Nếu có ảnh đại diện thì xử lý upload ảnh
    if ($request->hasFile('anh_dai_dien')) {
        $file = $request->file('anh_dai_dien');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $path = storage_path('app/public/anh_dai_dien/' . $filename);

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        file_put_contents($path, file_get_contents($file));

        $hoSo->anh_dai_dien = 'storage/anh_dai_dien/' . $filename;
        $hoSo->save();
    }

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
