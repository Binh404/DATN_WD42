<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\PhongBan;
use App\Models\TinTuyenDung;
use App\Models\VaiTro;
use App\Models\YeuCauTuyenDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TinTuyenDungController extends Controller
{
    //
    public function getJob()
    {
        $tuyenDung = TinTuyenDung::get();
        return view('homePage.job', compact('tuyenDung'));
    }
    public function getJobDetail($id)
    {
        $tuyenDung = TinTuyenDung::findOrFail($id);

        $relateJob = TinTuyenDung::where('id', '!=', $id) // Loại trừ tin hiện tại
        ->orderByDesc('luong_toi_da') // Sắp xếp lương giảm dần
        ->take(3)
        ->get();
        return view('homePage.detailJob', compact('tuyenDung','relateJob'));
    }

    public function createFromRequest($id)
    {
        $yeuCau = YeuCauTuyenDung::with('phongBan', 'chucVu')->findOrFail($id);
        $phongBans = PhongBan::all();
        $vaiTros = VaiTro::whereRaw('LOWER(ten) != ?', ['admin'])->get();
        return view("admin.tintuyendung.create", compact('yeuCau', 'phongBans', 'vaiTros'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tieu_de' => 'required|string|max:255',
            'ma' => 'required|string|max:255|unique:tin_tuyen_dung,ma',
            'phong_ban_id' => 'required|integer|exists:phong_ban,id',
            'chuc_vu_id' => 'required|integer|exists:chuc_vu,id',
            'vai_tro_id' => 'required|integer|exists:vai_tro,id',
            'chi_nhanh_id' => 'nullable|integer|exists:chi_nhanh,id',
            'loai_hop_dong' => 'required|in:thu_viec,xac_dinh_thoi_han,khong_xac_dinh_thoi_han',
            'cap_do_kinh_nghiem' => 'required|in:intern,fresher,junior,middle,senior',
            'kinh_nghiem_toi_thieu' => 'required|integer|min:0',
            'kinh_nghiem_toi_da' => 'required|integer|min:0|gte:kinh_nghiem_toi_thieu',
            'luong_toi_thieu' => 'nullable|numeric|min:0',
            'luong_toi_da' => 'nullable|numeric|min:0|gte:luong_toi_thieu',
            'so_vi_tri' => 'required|integer|min:1',
            'mo_ta_cong_viec' => 'required|string',
            'yeu_cau' => 'required|string',
            'phuc_loi' => 'nullable|string',
            'ky_nang_yeu_cau' => 'nullable|array',
            'ky_nang_yeu_cau.*' => 'string',
            'trinh_do_hoc_van' => 'nullable|string|max:255',
            'han_nop_ho_so' => 'required|date|after_or_equal:today',
            'lam_viec_tu_xa' => 'nullable|boolean',
            'tuyen_gap' => 'nullable|boolean',
            'trang_thai' => 'required|in:nhap,dang_tuyen,tam_dung,ket_thuc',
            'yeu_cau_id' => 'required|integer|exists:yeu_cau_tuyen_dung,id', // Thêm này
        ]);

        // Xử lý checkbox
        $validated['lam_viec_tu_xa'] = $request->has('lam_viec_tu_xa') ? 1 : 0;
        $validated['tuyen_gap'] = $request->has('tuyen_gap') ? 1 : 0;

        $validated['nguoi_dang_id'] = Auth::id();
        $validated['thoi_gian_dang'] = now();

        if (isset($validated['yeu_cau'])) {
            $validated['yeu_cau'] = array_map('trim', explode(',', $validated['yeu_cau']));
        }

        if (isset($validated['phuc_loi'])) {
            $validated['phuc_loi'] = array_map('trim', explode(',', $validated['phuc_loi']));
        }

        $yeuCauId = $validated['yeu_cau_id']; // Sử dụng từ validated data
        $yeuCau = YeuCauTuyenDung::findOrFail($yeuCauId);

        $tuyenDung = TinTuyenDung::create($validated);

        $yeuCau->trang_thai_dang = 'da_dang';
        $yeuCau->save();

        return redirect()->route('hr.tintuyendung.index')
            ->with('success', 'Tạo tin tuyển dụng thành công!');
    }

    public function index(Request $request){
        $user = auth()->user();

        if ($user->coVaiTro('HR')) {
            $query = TinTuyenDung::with('chucVu', 'phongBan')->orderBy("id", "desc");
            // $tinTuyenDungs = TinTuyenDung::all();
            if($request->filled('search')) {
                $query->where('tieu_de', 'like', '%' . $request->search . '%');
            }
            $tinTuyenDungs = $query->paginate(20);
            return view("admin.tintuyendung.index", compact('tinTuyenDungs'));
        }
        abort(403, 'Bạn không có quyền truy cập trang này.');
    }

    public function show(string $id)
    {
        $user = auth()->user();

        if ($user->coVaiTro('HR')) {
            $tuyenDung = TinTuyenDung::with('chucVu', 'phongBan')->findOrFail($id);
            return view("admin.tintuyendung.show", compact('tuyenDung'));
        }
        abort(403, 'Bạn không có quyền truy cập trang này.');
    }
}
