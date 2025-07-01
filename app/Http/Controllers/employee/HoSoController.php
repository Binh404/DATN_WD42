<?php

namespace App\Http\Controllers\Employee;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HoSoNguoiDung;


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
        $hoSo = HoSoNguoiDung::where('nguoi_dung_id', $user->id)->first();

        return view('employe.complete-profile', compact('hoSo'));
    }

    /**
     * Lưu thông tin hồ sơ
     */
    protected function generateMaNhanVien()
    {
        // Lấy mã lớn nhất hiện tại
        $last = HoSoNguoiDung::orderByDesc('id')->first();

        $so = 1;
        if ($last && preg_match('/HR(\d+)/', $last->ma_nhan_vien, $matches)) {
            $so = intval($matches[1]) + 1;
        }

        return 'HR' . str_pad($so, 6, '0', STR_PAD_LEFT); // HR000001
    }
    public function store(Request $request)
    {
        $user = Auth::user();

    $validated = $request->validate([
        'ho' => 'required|string|max:50',
        'ten' => 'required|string|max:50',
        'email_cong_ty' => 'nullable|email|unique:ho_so_nguoi_dung,email_cong_ty,' . $user->id . ',nguoi_dung_id',
        'so_dien_thoai' => 'nullable|string|max:20',
        'ngay_sinh' => 'nullable|date',
        'gioi_tinh' => 'nullable|in:nam,nu,khac',
        'dia_chi_hien_tai' => 'nullable|string|max:255',
        'dia_chi_thuong_tru' => 'nullable|string|max:255',
        'cmnd_cccd' => 'nullable|string|max:20|unique:ho_so_nguoi_dung,cmnd_cccd,' . $user->id . ',nguoi_dung_id',
        'so_ho_chieu' => 'nullable|string|max:20',
        'tinh_trang_hon_nhan' => 'nullable|in:doc_than,da_ket_hon,ly_hon,goa',
        'anh_dai_dien' => 'nullable|image|max:2048',
        'lien_he_khan_cap' => 'nullable|string|max:100',
        'sdt_khan_cap' => 'nullable|string|max:20',
        'quan_he_khan_cap' => 'nullable|string|max:50',
    ]);

    // Tự động tạo mã nhân viên
    $validated['ma_nhan_vien'] = $this->generateMaNhanVien();

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

    HoSoNguoiDung::updateOrCreate(
        ['nguoi_dung_id' => $user->id],
        $validated
    );

    $user->da_hoan_thanh_ho_so = true;
    $user->save();

    return redirect()->route('employee.dashboard')->with('success', 'Bạn đã cập nhật hồ sơ thành công.');
    }
}