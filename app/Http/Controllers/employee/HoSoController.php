<?php

namespace App\Http\Controllers\Employee;


use App\Models\NguoiDung;
use App\Models\LoaiNghiPhep;
use Illuminate\Http\Request;
use App\Models\HoSoNguoiDung;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\SoDuNghiPhepNhanVien;
use Illuminate\Support\Facades\Auth;


class HoSoController extends Controller
{
    public function form()
    {
        $user = Auth::user();

        // Kiểm tra nếu đã hoàn thành hồ sơ thì chuyển hướng về dashboard
        if ($user->da_hoan_thanh_ho_so) {
            // dd($user);
            return redirect()->route('employee.dashboard');
        }
        // dd($user);
        // Nếu chưa có hồ sơ thì hiển thị form trống
        $hoSo = HoSoNguoiDung::with('nguoiDung')->where('nguoi_dung_id', $user->id)->first();
        // dd($hoSo);
        return view('employe.complete-profile', compact('hoSo'));
    }

    /**
     * Lưu thông tin hồ sơ
     */
    protected function generateMaNhanVien($prefix)
{
    // Tìm hồ sơ có mã nhân viên bắt đầu bằng prefix, sắp xếp theo ID giảm dần
    $last = HoSoNguoiDung::where('ma_nhan_vien', 'like', $prefix . '%')
                ->orderByDesc('id')
                ->first();

    $so = 1;
    if ($last && preg_match('/' . $prefix . '(\d+)/', $last->ma_nhan_vien, $matches)) {
        $so = intval($matches[1]) + 1;
    }

    return $prefix . str_pad($so, 6, '0', STR_PAD_LEFT);
}

    public function store(Request $request)
    {
        $user = Auth::user();

    $validated = $request->validate([
    'ho' => 'required|string|max:50',
    'ten' => 'required|string|max:50',
    'so_dien_thoai' => [
                            'required',
                            'string',
                            'regex:/^0[0-9]{8,9}$/',
                            Rule::unique('ho_so_nguoi_dung', 'so_dien_thoai')->ignore($user->id, 'nguoi_dung_id'),
                        ],
    'ngay_sinh' => [
                        'required',
                        'date',
                        'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
                        'after_or_equal:' . now()->subYears(50)->format('Y-m-d'),
                    ],

    'gioi_tinh' => 'required|in:nam,nu,khac',
    'dia_chi_hien_tai' => 'required|string|max:255',
    'dia_chi_thuong_tru' => 'required|string|max:255',
    'cmnd_cccd' => 'required|string|max:20|regex:/^[0-9]{9,12}$/|unique:ho_so_nguoi_dung,cmnd_cccd,' . $user->id . ',nguoi_dung_id',
    'so_ho_chieu' => 'nullable|string|max:20',
    'tinh_trang_hon_nhan' => 'required|in:doc_than,da_ket_hon,ly_hon,goa',
    'anh_dai_dien' => 'nullable|image|max:2048',
    'anh_cccd_truoc' => 'nullable|image|max:2048',
    'anh_cccd_sau' => 'nullable|image|max:2048',
    'lien_he_khan_cap' => 'nullable|string|max:100',
    'sdt_khan_cap' => [
    'nullable',
    'string',
    'regex:/^[0-9]{9,15}$/',
    function ($attribute, $value, $fail) use ($request) {
        if ($value && $value === $request->so_dien_thoai) {
            $fail('Số điện thoại khẩn cấp không được trùng với số điện thoại chính.');
        }
    }
],
'quan_he_khan_cap' => 'nullable|string|max:50',
    'email_cong_ty' => 'required|email|max:255',
], [
    'ho.required' => 'Vui lòng nhập họ.',
    'ten.required' => 'Vui lòng nhập tên.',
    'so_dien_thoai.required' => 'Vui lòng nhập số điện thoại.',
    'so_dien_thoai.regex' => 'Số điện thoại không đúng định dạng.',
    'ngay_sinh.required' => 'Vui lòng chọn ngày sinh.',
    'ngay_sinh.date' => 'Ngày sinh không hợp lệ.',
    'ngay_sinh.before_or_equal' => 'Người dùng phải từ 18 tuổi trở lên.',
    'ngay_sinh.after_or_equal' => 'Người dùng không được quá 50 tuổi.',
    'gioi_tinh.required' => 'Vui lòng chọn giới tính.',
    'dia_chi_hien_tai.required' => 'Vui lòng nhập địa chỉ hiện tại.',
    'dia_chi_thuong_tru.required' => 'Vui lòng nhập địa chỉ thường trú.',
    'cmnd_cccd.required' => 'Vui lòng nhập CMND/CCCD.',
    'cmnd_cccd.regex' => 'CMND/CCCD không đúng định dạng.',
    'cmnd_cccd.unique' => 'CMND/CCCD đã tồn tại trong hệ thống.',
    'so_dien_thoai.unique' => 'Số điện thoại đã tồn tại trong hệ thống.',
    'tinh_trang_hon_nhan.required' => 'Vui lòng chọn tình trạng hôn nhân.',
    'email_cong_ty.required' => 'Email công ty là bắt buộc.',
    'email_cong_ty.email' => 'Email công ty không đúng định dạng.',
    'anh_dai_dien.image' => 'Ảnh đại diện phải là tệp hình ảnh.',
    'anh_dai_dien.max' => 'Ảnh đại diện tối đa 2MB.',
    'anh_cccd_truoc.image' => 'Ảnh căn cước phải là tệp hình ảnh.',
    'anh_cccd_truoc.max' => 'Ảnh đại diện tối đa 2MB.',
    'anh_cccd_sau.image' => 'Ảnh căn cước phải là tệp hình ảnh.',
    'anh_cccd_sau.max' => 'Ảnh đại diện tối đa 2MB.',
    'sdt_khan_cap.regex' => 'SĐT khẩn cấp không đúng định dạng.',
]);

     $prefix = $user->chucVu->ma ?? 'NV'; // fallback là NV nếu không có
    // Tự động tạo mã nhân viên
   $validated['ma_nhan_vien'] = $this->generateMaNhanVien($prefix);
    $validated['email_cong_ty'] = $user->email;
    // Upload ảnh nếu có
    if ($request->hasFile('anh_dai_dien')) {
        $file = $request->file('anh_dai_dien');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $path = storage_path('app/public/anh_dai_dien/' . $filename);

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        file_put_contents($path, file_get_contents($file));
        $validated['anh_dai_dien'] = 'storage/anh_dai_dien/' . $filename;
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

            $validated['anh_cccd_truoc'] = 'storage/cccd/' . $filename;
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

            $validated['anh_cccd_sau'] = 'storage/cccd/' . $filename;
        }

    HoSoNguoiDung::updateOrCreate(
        ['nguoi_dung_id' => $user->id],
        $validated
    );

    $user->da_hoan_thanh_ho_so = true;
    $user->save();

    // Kiểm tra giới tính để giữ hoặc xóa loại nghỉ phép thai sản
        $gioiTinh = $validated['gioi_tinh'];

        if ($gioiTinh === 'nam') {
            // Lấy ID loại nghỉ phép "nghỉ thai sản"
            $thaiSanId = LoaiNghiPhep::whereRaw('LOWER(ten) = ?', ['nghỉ thai sản'])->value('id');

            if ($thaiSanId) {
                // Xóa số dư nghỉ phép "nghỉ thai sản" của user hiện tại
                SoDuNghiPhepNhanVien::where('nguoi_dung_id', $user->id)
                    ->where('loai_nghi_phep_id', $thaiSanId)
                    ->delete();
            }
        }

    // trỏ về dashboard theo vai trò
    if ($user->coVaiTro('admin')) {
        return redirect()->route('admin.dashboard')->with('success', 'Bạn đã cập nhật hồ sơ thành công.');
    } elseif ($user->coVaiTro('employee')) {
        return redirect()->route('employee.dashboard')->with('success', 'Bạn đã cập nhật hồ sơ thành công.');
    } elseif ($user->coVaiTro('hr')) {
        return redirect()->route('hr.dashboard')->with('success', 'Bạn đã cập nhật hồ sơ thành công.');
    } else if ($user->coVaiTro('department')) {
        return redirect()->route('department.dashboard')->with('success', 'Bạn đã cập nhật hồ sơ thành công.');
    }


    }
}
