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
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = YeuCauTuyenDung::with('chucVu')->orderBy("id", "desc");

        if ($user->coVaiTro('DEPARTMENT')) {
            $query->where('phong_ban_id', $user->phong_ban_id);
            $yeuCauTuyenDungs = $query->paginate(10);
            return view("admin.yeucautuyendung.index", compact('yeuCauTuyenDungs'));
        }

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

        $chucVus = ChucVu::where('phong_ban_id', $user->phong_ban_id)->get();

        return view("admin.yeucautuyendung.create", compact('chucVus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ma' => 'required|string|max:20|unique:yeu_cau_tuyen_dung,ma',
            'so_luong' => 'required|integer|min:1',
            'chuc_vu_id' => 'required|exists:chuc_vu,id',
            'loai_hop_dong' => 'required|in:thu_viec,chinh_thuc,thoi_vu,thoi_han',
            'trinh_do_hoc_van' => 'nullable|string|max:100',

            'luong_toi_thieu' => 'nullable|numeric|min:0',
            'luong_toi_da' => 'nullable|numeric|gte:luong_toi_thieu',

            'kinh_nghiem_toi_thieu' => 'nullable|numeric|min:0',
            'kinh_nghiem_toi_da' => 'nullable|numeric|gte:kinh_nghiem_toi_thieu',

            'mo_ta_cong_viec' => 'nullable|string',
            'yeu_cau' => 'nullable|string',
            'ky_nang_yeu_cau' => 'nullable|string',
            'ghi_chu' => 'nullable|string',
        ]);

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
    public function show(string $id)
    {

        $tuyenDung = YeuCauTuyenDung::with('phongBan', 'chucVu', 'nguoiTao')->findOrFail($id);
        return view("admin.captrenthongbao.tuyendung.show", compact('tuyenDung'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $yeuCau = YeuCauTuyenDung::findOrFail($id);

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
            'trinh_do_hoc_van' => 'nullable|string|max:100',

            'luong_toi_thieu' => 'nullable|numeric|min:0',
            'luong_toi_da' => 'nullable|numeric|gte:luong_toi_thieu',

            'kinh_nghiem_toi_thieu' => 'nullable|numeric|min:0',
            'kinh_nghiem_toi_da' => 'nullable|numeric|gte:kinh_nghiem_toi_thieu',

            'mo_ta_cong_viec' => 'nullable|string',
            'yeu_cau' => 'nullable|string',
            'ky_nang_yeu_cau' => 'nullable|string',
            'ghi_chu' => 'nullable|string',
        ]);

        $yeuCau->update($validated);

        return redirect()->route('department.yeucautuyendung.index')
            ->with('success', 'Cập nhật yêu cầu tuyển dụng thành công!');
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
