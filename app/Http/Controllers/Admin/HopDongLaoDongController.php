<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HopDongLaoDong;
use App\Models\NguoiDung;
use App\Models\ChucVu;
use App\Models\HoSoNguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class HopDongLaoDongController extends Controller
{
    public function index()
    {
        $hopDongs = HopDongLaoDong::with(['hoSoNguoiDung', 'nguoiKy', 'chucVu'])->latest()->get();

        foreach ($hopDongs as $hopDong) {
            if (
                $hopDong->ngay_ket_thuc &&
                \Carbon\Carbon::parse($hopDong->ngay_ket_thuc)->lt(now()) &&
                $hopDong->trang_thai_hop_dong !== 'het_han'
            ) {
                $hopDong->trang_thai_hop_dong = 'het_han';
                $hopDong->save();
            }
        }

        $now = now();
        $in30days = now()->addDays(30);

        $hieuLuc = HopDongLaoDong::where('trang_thai_hop_dong', 'hieu_luc')->count();
        $chuaCoHopDong = HoSoNguoiDung::whereDoesntHave('hopDongLaoDong')->count();
        $sapHetHan = HopDongLaoDong::where('ngay_ket_thuc', '>', $now)
            ->where('ngay_ket_thuc', '<=', $in30days)
            ->count();
        $hetHanChuaTaiKy = HopDongLaoDong::where('trang_thai_hop_dong', 'het_han')->count();

        return view('admin.hopdong.index', compact(
            'hopDongs',
            'hieuLuc',
            'chuaCoHopDong',
            'sapHetHan',
            'hetHanChuaTaiKy'
        ));
    }

    public function create()
    {
        // Lấy danh sách nhân viên có hồ sơ nhưng chưa có bất kỳ hợp đồng lao động nào
        $nhanViens = NguoiDung::whereHas('hoSo')
            ->whereDoesntHave('hopDongLaoDong')
            ->with('hoSo')
            ->get();

        // Lấy danh sách chức vụ
        $chucVus = ChucVu::all();

        return view('admin.hopdong.create', compact('nhanViens', 'chucVus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nguoi_dung_id' => 'required|exists:nguoi_dung,id',
            'chuc_vu_id' => 'required|exists:chuc_vu,id',
            'so_hop_dong' => 'required|string|unique:hop_dong_lao_dong,so_hop_dong',
            'loai_hop_dong' => 'required|string',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
            'luong_co_ban' => 'required|numeric|min:0',
            'phu_cap' => 'nullable|numeric|min:0',
            'hinh_thuc_lam_viec' => 'required|string',
            'dia_diem_lam_viec' => 'required|string',
            'dieu_khoan' => 'required|string',
            'file_hop_dong' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->except('file_hop_dong');
        $data['nguoi_ky_id'] = Auth::id();
        $data['trang_thai_hop_dong'] = $request->trang_thai_hop_dong;
        $data['trang_thai_ky'] = $request->trang_thai_ky;

        if ($request->hasFile('file_hop_dong')) {
            $file = $request->file('file_hop_dong');
            $path = $file->store('hop_dong', 'public');
            $data['duong_dan_file'] = $path;
        }

        $hopDong = HopDongLaoDong::create($data);

        return redirect()->route('hopdong.index')
            ->with('success', 'Tạo hợp đồng thành công');
    }

    public function show($id)
    {
        $hopDong = HopDongLaoDong::with(['hoSoNguoiDung', 'nguoiKy', 'chucVu'])->findOrFail($id);
        return view('admin.hopdong.show', compact('hopDong'));
    }

    public function edit($id)
    {
        $hopDong = HopDongLaoDong::findOrFail($id);
        $nhanViens = NguoiDung::with('hoSo')->whereHas('hoSo')->get();
        $chucVus = ChucVu::all();
        return view('admin.hopdong.edit', compact('hopDong', 'nhanViens', 'chucVus'));
    }

    public function update(Request $request, $id)
    {
        $hopDong = HopDongLaoDong::findOrFail($id);

        $request->validate([
            'chuc_vu' => 'sometimes|required|string',
            'loai_hop_dong' => 'sometimes|required|string',
            'ngay_bat_dau' => 'sometimes|required|date',
            'ngay_ket_thuc' => 'sometimes|required|date|after:ngay_bat_dau',
            'luong_co_ban' => 'sometimes|required|numeric|min:0',
            'phu_cap' => 'nullable|numeric|min:0',
            'hinh_thuc_lam_viec' => 'sometimes|required|string',
            'dia_diem_lam_viec' => 'sometimes|required|string',
            'dieu_khoan' => 'sometimes|required|string',
            'file_hop_dong' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->except('file_hop_dong');

        if ($request->hasFile('file_hop_dong')) {
            // Xóa file cũ nếu có
            if ($hopDong->duong_dan_file) {
                Storage::disk('public')->delete($hopDong->duong_dan_file);
            }

            $file = $request->file('file_hop_dong');
            $path = $file->store('hop_dong', 'public');
            $data['duong_dan_file'] = $path;
        }

        $hopDong->update($data);

        return redirect()->route('hopdong.index')
            ->with('success', 'Cập nhật hợp đồng thành công');
    }

    public function destroy($id)
    {
        $hopDong = HopDongLaoDong::findOrFail($id);

        // Xóa file hợp đồng nếu có
        if ($hopDong->duong_dan_file) {
            Storage::disk('public')->delete($hopDong->duong_dan_file);
        }

        $hopDong->delete();

        return redirect()->route('hopdong.index')
            ->with('success', 'Xóa hợp đồng thành công');
    }

    public function kyHopDong($id)
    {
        $hopDong = HopDongLaoDong::findOrFail($id);
        
        if ($hopDong->trang_thai_ky !== 'cho_ky') {
            return response()->json([
                'status' => 'error',
                'message' => 'Hợp đồng không ở trạng thái chờ ký'
            ], 400);
        }

        $hopDong->update([
            'trang_thai_ky' => 'da_ky',
            'thoi_gian_ky' => Carbon::now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Ký hợp đồng thành công'
        ]);
    }
} 