<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HopDongLaoDong;
use App\Models\NguoiDung;
use App\Models\ChucVu;
use App\Models\HoSoNguoiDung;
use App\Models\PhuLucHopDong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class HopDongLaoDongController extends Controller
{
    public function index()
    {
        $query = HopDongLaoDong::with(['hoSoNguoiDung', 'nguoiKy', 'chucVu']);

        // Tìm kiếm theo từ khóa
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('so_hop_dong', 'like', "%{$search}%")
                  ->orWhereHas('hoSoNguoiDung', function($q) use ($search) {
                      $q->where('ma_nhan_vien', 'like', "%{$search}%")
                        ->orWhere('ho', 'like', "%{$search}%")
                        ->orWhere('ten', 'like', "%{$search}%");
                  });
            });
        }

        // Lọc theo loại hợp đồng
        if (request('loai_hop_dong')) {
            $query->where('loai_hop_dong', request('loai_hop_dong'));
        }

        // Lọc theo trạng thái hợp đồng
        if (request('trang_thai_hop_dong')) {
            $query->where('trang_thai_hop_dong', request('trang_thai_hop_dong'));
        }

        // Lọc theo trạng thái ký
        if (request('trang_thai_ky')) {
            $query->where('trang_thai_ky', request('trang_thai_ky'));
        }

        $hopDongs = $query->latest()->paginate(20);

        foreach ($hopDongs as $hopDong) {
            if (
                $hopDong->ngay_ket_thuc &&
                \Carbon\Carbon::parse($hopDong->ngay_ket_thuc)->lt(now()) &&
                $hopDong->trang_thai_hop_dong !== 'het_han'
            ) {
                $hopDong->trang_thai_hop_dong = 'het_han';
                if (!$hopDong->trang_thai_tai_ky || $hopDong->trang_thai_tai_ky === 'cho_tai_ky') {
                    $hopDong->trang_thai_tai_ky = 'cho_tai_ky';
                }
                $hopDong->save();
            }
        }

        $now = now();
        $in30days = now()->addDays(30);

        $hieuLuc = HopDongLaoDong::where('trang_thai_hop_dong', 'hieu_luc')->count();
        $chuaCoHopDong = HoSoNguoiDung::whereDoesntHave('hopDongLaoDong')->count();
        $sapHetHan = HopDongLaoDong::where('trang_thai_hop_dong', 'hieu_luc')
            ->where('ngay_ket_thuc', '>', $now)
            ->where('ngay_ket_thuc', '<=', $in30days)
            ->count();
        $hetHanChuaTaiKy = HopDongLaoDong::where('trang_thai_tai_ky', 'cho_tai_ky')->count();

        return view('admin.hopdong.index', compact(
            'hopDongs',
            'hieuLuc',
            'chuaCoHopDong',
            'sapHetHan',
            'hetHanChuaTaiKy'
        ));
    }

    public function create(Request $request)
    {
        $selectedNhanVienId = $request->input('nguoi_dung_id');

        // Lấy danh sách nhân viên có hồ sơ và không có hợp đồng nào đang hiệu lực hoặc chờ hiệu lực.
        $nhanViens = NguoiDung::whereHas('hoSo')
            ->whereDoesntHave('hopDongLaoDong', function ($query) {
                $query->whereIn('trang_thai_hop_dong', ['hieu_luc', 'chua_hieu_luc']);
            })
            ->with('hoSo')
            ->get();

        // Nếu có một nhân viên được chỉ định để tái ký nhưng không nằm trong danh sách trên
        // (trường hợp hiếm), hãy thêm họ vào danh sách.
        if ($selectedNhanVienId && !$nhanViens->contains('id', $selectedNhanVienId)) {
            $nhanVienTaiKy = NguoiDung::with('hoSo')->find($selectedNhanVienId);
            if ($nhanVienTaiKy) {
                $nhanViens->push($nhanVienTaiKy);
            }
        }

        $chucVus = ChucVu::all();

        return view('admin.hopdong.create', compact('nhanViens', 'chucVus', 'selectedNhanVienId'));
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
            'ghi_chu' => 'nullable|string',
            'trang_thai_ky' => 'required|in:cho_ky,da_ky',
            'file_hop_dong' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->all();

        // Tự động cập nhật trạng thái hợp đồng dựa trên trạng thái ký
        if ($request->trang_thai_ky === 'da_ky') {
            $data['trang_thai_hop_dong'] = 'dang_hieu_luc';
        } else {
            $data['trang_thai_hop_dong'] = 'chua_hieu_luc';
        }

        $nguoiDungId = $request->nguoi_dung_id;
        $hopDong = HopDongLaoDong::create($data);

        // Cập nhật trạng thái tái ký cho các hợp đồng đã hết hạn trước đó
        HopDongLaoDong::where('nguoi_dung_id', $nguoiDungId)
            ->where('id', '!=', $hopDong->id) // Loại trừ hợp đồng vừa tạo
            ->where('trang_thai_hop_dong', 'het_han')
            ->where('trang_thai_tai_ky', 'cho_tai_ky')
            ->update(['trang_thai_tai_ky' => 'da_tai_ky']);

        return redirect()->route('hopdong.index')->with('success', 'Hợp đồng đã được tạo thành công.');
    }

    public function show($id)
    {
        $hopDong = HopDongLaoDong::with([
            'hoSoNguoiDung',
            'nguoiDung.phongBan',
            'nguoiKy.hoSo',
            'chucVu',
            'nguoiHuy.hoSo',
            'phuLucs' => function($query) {
                $query->orderBy('ngay_hieu_luc', 'desc');
            }
        ])->findOrFail($id);

        return view('admin.hopdong.show', compact('hopDong'));
    }

    public function edit($id)
    {
        $hopDong = HopDongLaoDong::with([
            'hoSoNguoiDung',
            'chucVu',
            'phuLucs' => function($query) {
                $query->orderBy('ngay_hieu_luc', 'desc');
            }
        ])->findOrFail($id);

        $nhanViens = NguoiDung::with('hoSo')->whereHas('hoSo')->get();
        $chucVus = ChucVu::all();
        return view('admin.hopdong.edit', compact('hopDong', 'nhanViens', 'chucVus'));
    }

    public function update(Request $request, $id)
    {
        $hopDong = HopDongLaoDong::findOrFail($id);

        $request->validate([
            'chuc_vu_id' => 'required|exists:chuc_vu,id',
            'loai_hop_dong' => 'required|string',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'nullable|date|after:ngay_bat_dau',
            'luong_co_ban' => 'required|numeric|min:0',
            'phu_cap' => 'nullable|numeric|min:0',
            'hinh_thuc_lam_viec' => 'required|string',
            'dia_diem_lam_viec' => 'required|string',
            'ghi_chu' => 'nullable|string',
            'trang_thai_ky' => 'required|in:cho_ky,da_ky',
            'file_hop_dong' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($hopDong->trang_thai_ky == 'da_ky' && $request->trang_thai_ky == 'cho_ky') {
            return redirect()->back()->withErrors(['trang_thai_ky' => 'Không thể thay đổi trạng thái của hợp đồng đã ký.'])->withInput();
        }

        $data = $request->except(['file_hop_dong', 'trang_thai_hop_dong']);

        // Tự động map trạng thái hợp đồng theo trạng thái ký
        if ($request->trang_thai_ky === 'cho_ky') {
            $data['trang_thai_hop_dong'] = 'chua_hieu_luc';
        } elseif ($request->trang_thai_ky === 'da_ky') {
            $data['trang_thai_hop_dong'] = 'hieu_luc';
        }

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

    public function huyHopDong(Request $request, $id)
    {
        $request->validate([
            'ly_do_huy' => 'required|string|max:1000',
        ], [
            'ly_do_huy.required' => 'Vui lòng nhập lý do hủy hợp đồng.',
            'ly_do_huy.max' => 'Lý do hủy không được vượt quá 1000 ký tự.',
        ]);

        $hopDong = HopDongLaoDong::findOrFail($id);

        // Kiểm tra xem hợp đồng đã bị hủy chưa
        if ($hopDong->trang_thai_hop_dong === 'huy_bo') {
            return redirect()->back()->with('error', 'Hợp đồng này đã được hủy trước đó');
        }

        // Kiểm tra xem hợp đồng có thể được hủy không
        if ($hopDong->trang_thai_hop_dong === 'het_han') {
            return redirect()->back()->with('error', 'Không thể hủy hợp đồng đã hết hạn');
        }

        // Kiểm tra xem hợp đồng có đang trong thời gian hiệu lực không
        if ($hopDong->ngay_bat_dau && $hopDong->ngay_bat_dau->gt(now())) {
            return redirect()->back()->with('error', 'Không thể hủy hợp đồng chưa đến ngày hiệu lực');
        }

        // Kiểm tra quyền hủy hợp đồng (chỉ admin và HR mới có quyền)
        $user = Auth::user();
        $userRoles = optional($user->vaiTros)->pluck('ten')->toArray();

        if (!in_array('admin', $userRoles) && !in_array('hr', $userRoles)) {
            return redirect()->back()->with('error', 'Bạn không có quyền hủy hợp đồng');
        }

        try {
            // Cập nhật thông tin hủy hợp đồng
            $hopDong->update([
                'trang_thai_hop_dong' => 'huy_bo',
                'ly_do_huy' => $request->ly_do_huy,
                'nguoi_huy_id' => Auth::id(),
                'thoi_gian_huy' => now(),
            ]);

            return redirect()->route('hopdong.show', $hopDong->id)
                ->with('success', 'Hủy hợp đồng thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi hủy hợp đồng. Vui lòng thử lại.');
        }
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
            'trang_thai_hop_dong' => 'hieu_luc',
            'thoi_gian_ky' => Carbon::now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Ký hợp đồng thành công'
        ]);
    }

    public function createPhuLuc(HopDongLaoDong $hopDong)
    {
        $chucVus = ChucVu::all();
        return view('admin.hopdong.phuluc.create', compact('hopDong', 'chucVus'));
    }

    public function storePhuLuc(Request $request, HopDongLaoDong $hopDong)
    {
        $validatedData = $request->validate([
            'so_phu_luc' => 'required|string|unique:phu_luc_hop_dong,so_phu_luc',
            'ten_phu_luc' => 'nullable|string|max:255',
            'ngay_ky' => 'required|date',
            'ngay_hieu_luc_pl' => 'required|date|after_or_equal:ngay_ky',
            'trang_thai_ky' => 'required|in:cho_ky,da_ky',
            'chuc_vu_id' => 'required|exists:chuc_vu,id',
            'loai_hop_dong' => 'required|string',
            'ngay_het_han_moi' => 'required|date|after:ngay_hieu_luc_pl',
            'luong_co_ban_moi' => 'required|numeric|min:0',
            'phu_cap_moi' => 'required|numeric|min:0',
            'hinh_thuc_lam_viec' => 'required|string|max:255',
            'dia_diem_lam_viec' => 'required|string|max:255',
            'tep_dinh_kem' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'noi_dung_thay_doi' => 'required|string',
            'ghi_chu' => 'nullable|string',
        ]);

        // 1. Create and save the appendix
        $phuLuc = new PhuLucHopDong([
            'so_phu_luc' => $validatedData['so_phu_luc'],
            'ten_phu_luc' => $validatedData['ten_phu_luc'],
            'ngay_ky' => $validatedData['ngay_ky'],
            'ngay_hieu_luc' => $validatedData['ngay_hieu_luc_pl'],
            'trang_thai_ky' => $validatedData['trang_thai_ky'],
            'hop_dong_id' => $hopDong->id,
            'nguoi_tao_id' => Auth::id(),
            'chuc_vu_id' => $validatedData['chuc_vu_id'],
            'loai_hop_dong' => $validatedData['loai_hop_dong'],
            'ngay_ket_thuc' => $validatedData['ngay_het_han_moi'],
            'luong_co_ban' => $validatedData['luong_co_ban_moi'],
            'phu_cap' => $validatedData['phu_cap_moi'],
            'hinh_thuc_lam_viec' => $validatedData['hinh_thuc_lam_viec'],
            'dia_diem_lam_viec' => $validatedData['dia_diem_lam_viec'],
            'noi_dung_thay_doi' => $validatedData['noi_dung_thay_doi'],
            'ghi_chu' => $validatedData['ghi_chu'],
        ]);

        if ($request->hasFile('tep_dinh_kem')) {
            $path = $request->file('tep_dinh_kem')->store('phu_luc', 'public');
            $phuLuc->tep_dinh_kem = $path;
        }
        $phuLuc->save();

        // 2. Update the original contract if the appendix is signed
        if ($phuLuc->trang_thai_ky === 'da_ky') {
            $hopDong->update([
                'chuc_vu_id' => $phuLuc->chuc_vu_id,
                'loai_hop_dong' => $phuLuc->loai_hop_dong,
                'ngay_ket_thuc' => $phuLuc->ngay_ket_thuc,
                'luong_co_ban' => $phuLuc->luong_co_ban,
                'phu_cap' => $phuLuc->phu_cap,
                'hinh_thuc_lam_viec' => $phuLuc->hinh_thuc_lam_viec,
                'dia_diem_lam_viec' => $phuLuc->dia_diem_lam_viec,
            ]);
        }

        return redirect()->route('hopdong.show', $hopDong->id)
            ->with('success', 'Tạo phụ lục hợp đồng thành công!');
    }
}
