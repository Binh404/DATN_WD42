<?php

namespace App\Http\Controllers\employee;

use Illuminate\Http\Request;
use App\Models\HoSoNguoiDung;
use App\Http\Controllers\Controller;
use App\Models\NguoiDung;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show()
    {

        $nguoiDungId = Auth::id();
        $hoSo = HoSoNguoiDung::where('nguoi_dung_id', $nguoiDungId)->first();
        $taiKhoan = NguoiDung::findOrFail(Auth::id());
        $phongbans = NguoiDung::findOrFail(Auth::id());
        if (!$hoSo) {
            return redirect()->back()->with('error', 'Chưa có hồ sơ.');
        }

        return view('employe.profile', compact('hoSo', 'taiKhoan', 'phongbans'));
    }
    public function capNhatTaiKhoan(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'ten_dang_nhap' => [
                'required',
                'string',
                'max:255',
                Rule::unique('nguoi_dung')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('nguoi_dung')->ignore($user->id),
            ],
        ], [
            'ten_dang_nhap.required' => 'Tên đăng nhập là bắt buộc.',
            'ten_dang_nhap.unique' => 'Tên đăng nhập đã tồn tại.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
        ]);

        $user->ten_dang_nhap = $request->ten_dang_nhap;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Cập nhật tài khoản thành công!');
    }
    public function capNhatMatKhau(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Bạn phải nhập mật khẩu hiện tại.',
            'new_password.required' => 'Mật khẩu mới là bắt buộc.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }

    public function update(Request $request)
    {

        $nguoiDungId = Auth::id();
        $hoSo = HoSoNguoiDung::where('nguoi_dung_id', $nguoiDungId)->first();

        if (!$hoSo) {
            return redirect()->back()->with('error', 'Không tìm thấy hồ sơ.');
        }

        $request->validate([
            'ho' => 'required|string|max:50',
            'ten' => 'required|string|max:50',
            'so_dien_thoai' => 'nullable|string|max:20|regex:/^[0-9]{9,15}$/',
            'ngay_sinh' => 'nullable|date',
            'gioi_tinh' => 'nullable|in:nam,nu,khac',
            'dia_chi_hien_tai' => 'nullable|string|max:255',
            'dia_chi_thuong_tru' => 'nullable|string|max:255',
            'cmnd_cccd' => 'nullable|string|max:20|regex:/^[0-9]{9,12}$/|unique:ho_so_nguoi_dung,cmnd_cccd,' . $hoSo->id,
            'so_ho_chieu' => 'nullable|string|max:20',
            'tinh_trang_hon_nhan' => 'nullable|in:doc_than,da_ket_hon,ly_hon,goa',
            'anh_dai_dien' => 'nullable|image|max:2048',
            'lien_he_khan_cap' => 'nullable|string|max:100',
            'sdt_khan_cap' => 'nullable|string|max:20|regex:/^[0-9]{9,15}$/',
            'quan_he_khan_cap' => 'nullable|string|max:50',
            'email_cong_ty' => 'required|email|max:255',
        ], [
            'ho.required' => 'Vui lòng nhập họ.',
            'ten.required' => 'Vui lòng nhập tên.',
            'so_dien_thoai.regex' => 'Số điện thoại không đúng định dạng.',
            'ngay_sinh.date' => 'Ngày sinh không hợp lệ.',
            'gioi_tinh.in' => 'Giới tính không hợp lệ.',
            'cmnd_cccd.regex' => 'CMND/CCCD không đúng định dạng.',
            'cmnd_cccd.unique' => 'CMND/CCCD đã tồn tại trong hệ thống.',
            'sdt_khan_cap.regex' => 'SĐT khẩn cấp không đúng định dạng.',
            'email_cong_ty.required' => 'Email công ty là bắt buộc.',
            'email_cong_ty.email' => 'Email công ty không đúng định dạng.',
        ]);


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
