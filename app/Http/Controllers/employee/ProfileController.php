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
        $phongbans = NguoiDung::with('phongBan')->findOrFail(Auth::id());
        $chucvus = NguoiDung::with('chucVu')->findOrFail(Auth::id());
        $vaitros = NguoiDung::with('vaiTro')->findOrFail(Auth::id());

        if (!$hoSo) {
            return redirect()->back()->with('error', 'Chưa có hồ sơ.');
        }

        return view('employe.profile', compact('hoSo', 'taiKhoan', 'phongbans', 'chucvus', 'vaitros'));
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

        $validated = $request->validate([
            // Bắt buộc nhập
            'ho'                  => ['required', 'string', 'max:50'],
            'ten'                 => ['required', 'string', 'max:50'],
            'so_dien_thoai'       => [
                'required',
                'regex:/^0[0-9]{9}$/',
                Rule::unique('ho_so_nguoi_dung', 'so_dien_thoai')->ignore($hoSo->id)
            ],                     // 10 số, bắt đầu 0
            'ngay_sinh'           => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
                'after_or_equal:' . now()->subYears(50)->format('Y-m-d'),
            ],
            'gioi_tinh'           => ['required', Rule::in(['nam', 'nu', 'khac'])],
            'dia_chi_hien_tai'    => ['required', 'string', 'max:255'],
            'dia_chi_thuong_tru'  => ['required', 'string', 'max:255'],
            'cmnd_cccd'           => [
                'required',
                'regex:/^(?:[0-9]{12}|[0-9]{9})$/',                                         // 12 số (CCCD) hoặc 9 số (CMND)
                Rule::unique('ho_so_nguoi_dung', 'cmnd_cccd')->ignore($hoSo->id),
            ],
            'tinh_trang_hon_nhan' => ['required', Rule::in(['doc_than', 'da_ket_hon', 'ly_hon', 'goa'])],
            'email_cong_ty'       => ['required', 'email', 'max:255'],

        // Cho phép bỏ trống nhưng phải đúng định dạng khi có
        'so_ho_chieu'         => ['nullable','string','max:20'],
        'anh_dai_dien'        => ['nullable','image','max:2048'],
        'anh_cccd_truoc' => ['nullable','image','max:2048'],
        'anh_cccd_sau' => ['nullable','image','max:2048'],
        'lien_he_khan_cap'    => ['nullable','string','max:100'],
        'sdt_khan_cap'        => ['nullable','regex:/^0[0-9]{9}$/',
                                    function ($attribute, $value, $fail) use ($request) {
                                        if ($value && $value === $request->so_dien_thoai) {
                                            $fail('Số điện thoại khẩn cấp không được trùng với số điện thoại chính.');
                                        }
                                    }],                    // nếu nhập thì phải 10 số bắt đầu 0
        'quan_he_khan_cap'    => ['nullable','string','max:50'],
    ],[
        'ho.required'                 => 'Vui lòng nhập họ.',
        'ten.required'                => 'Vui lòng nhập tên.',
        'so_dien_thoai.required'      => 'Vui lòng nhập số điện thoại.',
        'so_dien_thoai.regex'         => 'Số điện thoại phải gồm 10 chữ số và bắt đầu bằng 0.',
        'so_dien_thoai.unique' => 'Số điện thoại đã tồn tại trong hệ thống.',
        'ngay_sinh.required'          => 'Vui lòng chọn ngày sinh.',
        'ngay_sinh.before_or_equal' => 'Người dùng phải từ 18 tuổi trở lên.',
        'ngay_sinh.after_or_equal' => 'Người dùng không được quá 50 tuổi.',
        'gioi_tinh.required'          => 'Vui lòng chọn giới tính.',
        'dia_chi_hien_tai.required'   => 'Vui lòng nhập địa chỉ hiện tại.',
        'dia_chi_thuong_tru.required' => 'Vui lòng nhập địa chỉ thường trú.',
        'cmnd_cccd.required'          => 'Vui lòng nhập số CCCD/CMND.',
        'cmnd_cccd.regex'             => 'CCCD phải gồm 12 chữ số (hoặc CMND 9 chữ số).',
        'cmnd_cccd.unique'            => 'Số CCCD/CMND đã tồn tại trong hệ thống.',
        'tinh_trang_hon_nhan.required'=> 'Vui lòng chọn tình trạng hôn nhân.',
        'email_cong_ty.required'      => 'Email công ty là bắt buộc.',
        'email_cong_ty.email'         => 'Email công ty không đúng định dạng.',
        'sdt_khan_cap.regex'          => 'SĐT khẩn cấp phải gồm 10 chữ số và bắt đầu bằng 0.',
        'anh_dai_dien.image'          => 'Ảnh đại diện phải là tệp hình ảnh (jpg, png, gif…).',
        'anh_dai_dien.max'            => 'Ảnh đại diện tối đa 2 MB.',
        'anh_cccd_truoc.image' => 'Ảnh căn cước phải là tệp hình ảnh.',
        'anh_cccd_truoc.max' => 'Ảnh đại diện tối đa 2MB.',
        'anh_cccd_sau.image' => 'Ảnh căn cước phải là tệp hình ảnh.',
        'anh_cccd_sau.max' => 'Ảnh đại diện tối đa 2MB.',
    ]);
        // Ép email công ty = email của user đang đăng nhập
        $validated['email_cong_ty'] = Auth::user()->email;

        // Chỉ fill dữ liệu hợp lệ (đã validate), bỏ qua ảnh vì xử lý riêng
        $hoSo->fill(collect($validated)->except('anh_dai_dien')->toArray());


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


        // Nếu có CCCD mặt trước
        if ($request->hasFile('anh_cccd_truoc')) {
            $file = $request->file('anh_cccd_truoc');
            $filename = time() . '_front.' . $file->getClientOriginalExtension();
            $path = storage_path('app/public/cccd/' . $filename);

            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0777, true);
            }

            file_put_contents($path, file_get_contents($file));

            $hoSo->anh_cccd_truoc = 'storage/cccd/' . $filename;
        }

        // Nếu có CCCD mặt sau
        if ($request->hasFile('anh_cccd_sau')) {
            $file = $request->file('anh_cccd_sau');
            $filename = time() . '_back.' . $file->getClientOriginalExtension();
            $path = storage_path('app/public/cccd/' . $filename);

            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0777, true);
            }

            file_put_contents($path, file_get_contents($file));

            $hoSo->anh_cccd_sau = 'storage/cccd/' . $filename;
        }
        $hoSo->save();

        return redirect()->back()->with('success', 'Cập nhật hồ sơ thành công.');
    }
    /**
     * Delete the user's account.
     */
}
