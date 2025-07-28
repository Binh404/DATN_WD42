<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChucVu;
use App\Models\DonTu;
use App\Models\PhongBan;
use App\Models\YeuCauTuyenDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class YeuCauTuyenDungController extends Controller
{
   
    // danh sách đã tạo của trưởng phòng
    public function danhSachYeuCauTuyenDung(Request $request)
    {
        $user = auth()->user();
        $query = YeuCauTuyenDung::with('chucVu')->orderBy("id", "desc");

        if ($user->coVaiTro('DEPARTMENT')) {
            $query->where('phong_ban_id', $user->phong_ban_id);
            $yeuCauTuyenDungs = $query->paginate(10);
            return view("admin.yeucautuyendung.index", compact('yeuCauTuyenDungs'));
        }
        abort(403, 'Bạn không có quyền truy cập trang này.');
    }

    // thông báo tới hr
    public function danhSachThongBaoTuyenDung()
    {
        $user = auth()->user();
        $query = YeuCauTuyenDung::with('chucVu')->orderBy("id", "desc");

        if ($user->coVaiTro('HR')) {
            $query->where('trang_thai', 'da_duyet');
            $TuyenDungs = $query->paginate(10);
            return view("admin.captrenthongbao.tuyendung.index", compact('TuyenDungs'));
        }
        abort(403, 'Bạn không có quyền truy cập trang này.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->coVaiTro('DEPARTMENT')) {
            $chucVus = ChucVu::where('phong_ban_id', $user->phong_ban_id)->get();
            return view("admin.yeucautuyendung.create", compact('chucVus'));
        }
        abort(403, 'Bạn không có quyền truy cập trang này.');
    }


    private function generateUniqueMaDonNghi()
    {
        do {
            $code = 'YCTD' . mt_rand(100000, 999999);
        } while (YeuCauTuyenDung::where('ma', $code)->exists());

        return $code;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'so_luong' => 'required|integer|min:1',
            'chuc_vu_id' => 'required|exists:chuc_vu,id',
            'loai_hop_dong' => 'required|in:thu_viec,xac_dinh_thoi_han,khong_xac_dinh_thoi_han',
            'trinh_do_hoc_van' => 'required|string|max:100',

            'luong_toi_thieu' => 'required|numeric|min:0',
            'luong_toi_da' => 'required|numeric|gte:luong_toi_thieu',

            'kinh_nghiem_toi_thieu' => 'required|numeric|min:0',
            'kinh_nghiem_toi_da' => 'required|numeric|gte:kinh_nghiem_toi_thieu',

            'mo_ta_cong_viec' => 'required|string',
            'yeu_cau' => 'required|string',
            'ky_nang_yeu_cau' => 'required|string',
            'ghi_chu' => 'nullable|string',
        ],  [
            'required' => ':attribute không được để trống.',
            'string' => ':attribute phải là chuỗi.',
            'integer' => ':attribute phải là số nguyên.',
            'numeric' => ':attribute phải là số.',
            'min' => ':attribute phải lớn hơn hoặc bằng :min.',
            'max' => ':attribute không được vượt quá :max ký tự.',
            'in' => ':attribute không hợp lệ.',
            'exists' => ':attribute không tồn tại trong hệ thống.',
            'gte' => ':attribute phải lớn hơn hoặc bằng :value.',
        ]);

        $validated['ma'] = $this->generateUniqueMaDonNghi();
        $validated['ky_nang_yeu_cau'] = array_map('trim', explode(',', $validated['ky_nang_yeu_cau']));

        $user = Auth::user();

        YeuCauTuyenDung::create(array_merge($validated, [
            'phong_ban_id' => $user->phong_ban_id,
            'nguoi_tao_id' => $user->id,
        ]));

        return redirect()->route('department.yeucautuyendung.index')
            ->with('success', 'Tạo yêu cầu tuyển dụng thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function chiTietThongBaoTuyenDung(string $id)
    {
        $tuyenDung = YeuCauTuyenDung::with('phongBan', 'chucVu', 'nguoiTao')->findOrFail($id);
        return view("admin.captrenthongbao.tuyendung.show", compact('tuyenDung'));
    }

    public function chiTietYeuCauTuyenDung(string $id)
    {
        $tuyenDung = YeuCauTuyenDung::with('phongBan', 'chucVu', 'nguoiTao')->findOrFail($id);
        return view("admin.yeucautuyendung.show", compact('tuyenDung'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $yeuCau = YeuCauTuyenDung::findOrFail($id);

        if ($yeuCau->trang_thai !== 'cho_duyet') {
            return redirect()->route('department.yeucautuyendung.index')
                ->with('error', 'Chỉ có thể cập nhật yêu cầu đang ở trạng thái chờ duyệt!');
        }

        $chucVus = ChucVu::where('phong_ban_id', auth()->user()->phong_ban_id)->get();

        return view('admin.yeucautuyendung.edit', compact('yeuCau', 'chucVus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $yeuCau = YeuCauTuyenDung::findOrFail($id);

        $validated = $request->validate([
            'ma' => 'required|string|max:20|unique:yeu_cau_tuyen_dung,ma,' . $yeuCau->id,
            'so_luong' => 'required|integer|min:1',
            'chuc_vu_id' => 'required|exists:chuc_vu,id',
            'loai_hop_dong' => 'required|in:thu_viec,chinh_thuc,thoi_vu,thoi_han',
            'trinh_do_hoc_van' => 'required|string|max:100',

            'luong_toi_thieu' => 'required|numeric|min:0',
            'luong_toi_da' => 'required|numeric|gte:luong_toi_thieu',

            'kinh_nghiem_toi_thieu' => 'required|numeric|min:0',
            'kinh_nghiem_toi_da' => 'required|numeric|gte:kinh_nghiem_toi_thieu',

            'mo_ta_cong_viec' => 'required|string',
            'yeu_cau' => 'required|string',
            'ky_nang_yeu_cau' => 'required|string',
            'ghi_chu' => 'nullable|string',
        ]);

        $validated['ky_nang_yeu_cau'] = array_map('trim', explode(',', $validated['ky_nang_yeu_cau']));

        if ($yeuCau->trang_thai === 'cho_duyet') {
            $yeuCau->update($validated);

            return redirect()->route('department.yeucautuyendung.index')
                ->with('success', 'Cập nhật yêu cầu tuyển dụng thành công!');
        }

        return redirect()->route('department.yeucautuyendung.index')
            ->with('error', 'Chỉ có thể cập nhật yêu cầu đang ở trạng thái chờ duyệt!');
    }

    public function cancel($id)
    {
        $yeuCau = YeuCauTuyenDung::findOrFail($id);

        if ($yeuCau->trang_thai !== 'cho_duyet') {
            return redirect()->route('department.yeucautuyendung.index')
                ->with('error', 'Chỉ có thể hủy những yêu cầu đang chờ duyệt.');
        }

        $yeuCau->update([
            'trang_thai' => 'huy_bo',
        ]);

        return redirect()->route('department.yeucautuyendung.index')
            ->with('success', 'Đã hủy yêu cầu tuyển dụng thành công!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
