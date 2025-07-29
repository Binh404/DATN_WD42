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
use App\Exports\HopDongExport;
use Maatwebsite\Excel\Facades\Excel;

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

        // Loại trừ hợp đồng đã hủy bỏ và hợp đồng hết hạn đã được tái ký thành công
        $query->where(function($q) {
            $q->where('trang_thai_hop_dong', '!=', 'huy_bo')
              ->where(function($subQ) {
                  $subQ->where('trang_thai_hop_dong', '!=', 'het_han')
                       ->orWhere(function($innerQ) {
                           $innerQ->where('trang_thai_hop_dong', 'het_han')
                                  ->where(function($finalQ) {
                                      $finalQ->whereNull('trang_thai_tai_ky')
                                             ->orWhere('trang_thai_tai_ky', 'cho_tai_ky');
                                  });
                       });
              });
        });

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

    public function luuTru()
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

        // Lọc theo trạng thái ký
        if (request('trang_thai_ky')) {
            $query->where('trang_thai_ky', request('trang_thai_ky'));
        }

        // Chỉ lấy hợp đồng đã hủy bỏ và hợp đồng hết hạn đã được tái ký thành công
        $query->where(function($q) {
            $q->where('trang_thai_hop_dong', 'huy_bo')
              ->orWhere(function($subQ) {
                  $subQ->where('trang_thai_hop_dong', 'het_han')
                       ->where('trang_thai_tai_ky', 'da_tai_ky');
              });
        });

        $hopDongsArchive = $query->latest()->paginate(20);

        // Thống kê cho dashboard
        $now = now();
        $in30days = now()->addDays(30);

        $hieuLuc = HopDongLaoDong::where('trang_thai_hop_dong', 'hieu_luc')->count();
        $chuaCoHopDong = HoSoNguoiDung::whereDoesntHave('hopDongLaoDong')->count();
        $sapHetHan = HopDongLaoDong::where('trang_thai_hop_dong', 'hieu_luc')
            ->where('ngay_ket_thuc', '>', $now)
            ->where('ngay_ket_thuc', '<=', $in30days)
            ->count();
        $hetHanChuaTaiKy = HopDongLaoDong::where('trang_thai_tai_ky', 'cho_tai_ky')->count();

        return view('admin.hopdong.luu-tru', compact(
            'hopDongsArchive',
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
            // 'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
            'luong_co_ban' => 'required|numeric|min:0',
            'phu_cap' => 'nullable|numeric|min:0',
            'hinh_thuc_lam_viec' => 'required|string',
            'dia_diem_lam_viec' => 'required|string',
            'dieu_khoan' => 'required|string',
            'ghi_chu' => 'nullable|string',
            'file_hop_dong' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ], [
            'file_hop_dong.required' => 'Vui lòng chọn file hợp đồng.',
            'file_hop_dong.file' => 'File hợp đồng không hợp lệ.',
            'file_hop_dong.mimes' => 'File hợp đồng phải có định dạng PDF, DOC hoặc DOCX.',
            'file_hop_dong.max' => 'File hợp đồng không được vượt quá 2MB.',
        ]);

        $data = $request->all();

        // Khi tạo mới hợp đồng, mặc định ở trạng thái "tạo mới"
        $data['trang_thai_hop_dong'] = 'tao_moi';
        $data['trang_thai_ky'] = 'cho_ky';

        // Xử lý file hợp đồng
        if ($request->hasFile('file_hop_dong')) {
            $file = $request->file('file_hop_dong');
            $path = $file->store('hop_dong', 'public');
            $data['duong_dan_file'] = $path;
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
            'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
            'luong_co_ban' => 'required|numeric|min:0',
            'phu_cap' => 'nullable|numeric|min:0',
            'hinh_thuc_lam_viec' => 'required|string',
            'dia_diem_lam_viec' => 'required|string',
            'ghi_chu' => 'nullable|string',
            'trang_thai_ky' => 'required|in:cho_ky,da_ky',
            'file_hop_dong' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ], [
            'chuc_vu_id.required' => 'Vui lòng chọn chức vụ.',
            'chuc_vu_id.exists' => 'Chức vụ không tồn tại.',
            'loai_hop_dong.required' => 'Vui lòng chọn loại hợp đồng.',
            'ngay_bat_dau.required' => 'Vui lòng chọn ngày bắt đầu.',
            'ngay_bat_dau.date' => 'Ngày bắt đầu không hợp lệ.',
            'ngay_ket_thuc.required' => 'Vui lòng chọn ngày kết thúc.',
            'ngay_ket_thuc.date' => 'Ngày kết thúc không hợp lệ.',
            'ngay_ket_thuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'luong_co_ban.required' => 'Vui lòng nhập lương cơ bản.',
            'luong_co_ban.numeric' => 'Lương cơ bản phải là số.',
            'luong_co_ban.min' => 'Lương cơ bản không được âm.',
            'phu_cap.numeric' => 'Phụ cấp phải là số.',
            'phu_cap.min' => 'Phụ cấp không được âm.',
            'hinh_thuc_lam_viec.required' => 'Vui lòng chọn hình thức làm việc.',
            'dia_diem_lam_viec.required' => 'Vui lòng nhập địa điểm làm việc.',
            'trang_thai_ky.required' => 'Vui lòng chọn trạng thái ký.',
            'trang_thai_ky.in' => 'Trạng thái ký không hợp lệ.',
            'file_hop_dong.file' => 'File hợp đồng không hợp lệ.',
            'file_hop_dong.mimes' => 'File hợp đồng phải có định dạng PDF, DOC hoặc DOCX.',
            'file_hop_dong.max' => 'File hợp đồng không được vượt quá 2MB.',
        ]);

        // Kiểm tra ngày bắt đầu >= ngày hiện tại khi hợp đồng ở trạng thái "chưa hiệu lực"
        if ($hopDong->trang_thai_hop_dong === 'chua_hieu_luc') {
            $ngayBatDau = \Carbon\Carbon::parse($request->ngay_bat_dau);
            $ngayHienTai = \Carbon\Carbon::today();

            if ($ngayBatDau->lt($ngayHienTai)) {
                return redirect()->back()->withErrors(['ngay_bat_dau' => 'Ngày bắt đầu phải từ ngày hôm nay trở đi khi hợp đồng ở trạng thái chưa hiệu lực.'])->withInput();
            }
        }

        if ($hopDong->trang_thai_ky == 'da_ky' && $request->trang_thai_ky == 'cho_ky') {
            return redirect()->back()->withErrors(['trang_thai_ky' => 'Không thể thay đổi trạng thái của hợp đồng đã ký.'])->withInput();
        }

        $data = $request->except(['file_hop_dong', 'trang_thai_hop_dong']);

        // Không tự động thay đổi trạng thái hợp đồng khi update
        // Trạng thái hợp đồng chỉ thay đổi thông qua các action riêng biệt (phê duyệt, ký, hủy)

        // Xử lý file hợp đồng (bắt buộc)
        if ($request->hasFile('file_hop_dong')) {
            // Xóa file cũ nếu có
            if ($hopDong->duong_dan_file) {
                Storage::disk('public')->delete($hopDong->duong_dan_file);
            }

            $file = $request->file('file_hop_dong');
            $path = $file->store('hop_dong', 'public');
            $data['duong_dan_file'] = $path;
        } else {
            // Nếu không có file mới, giữ lại file cũ
            $data['duong_dan_file'] = $hopDong->duong_dan_file;
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

        // Cho phép hủy hợp đồng trước thời hạn nếu có lý do hợp lệ
        // Không cần kiểm tra ngày bắt đầu nữa

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

    public function pheDuyetHopDong($id)
    {
        try {
            $hopDong = HopDongLaoDong::findOrFail($id);

            // Kiểm tra quyền phê duyệt (chỉ admin và HR mới có quyền)
            $user = Auth::user();
            $userRoles = optional($user->vaiTros)->pluck('ten')->toArray();

            if (!in_array('admin', $userRoles) && !in_array('hr', $userRoles)) {
                return redirect()->back()->with('error', 'Bạn không có quyền phê duyệt hợp đồng');
            }

            if ($hopDong->trang_thai_hop_dong !== 'tao_moi') {
                return redirect()->back()->with('error', 'Hợp đồng không ở trạng thái tạo mới');
            }

            // Cập nhật trạng thái: từ "tạo mới" → "chưa hiệu lực", trạng thái ký vẫn là "chờ ký"
            $hopDong->update([
                'trang_thai_hop_dong' => 'chua_hieu_luc',
                'trang_thai_ky' => 'cho_ky'
            ]);

            $nhanVien = $hopDong->nguoiDung; // Quan hệ tới model NguoiDung
            if ($nhanVien) {
                $nhanVien->notify(new \App\Notifications\HopDongApprovedNotification($hopDong));
            }

            return redirect()->route('hopdong.show', $hopDong->id)
                ->with('success', 'Phê duyệt hợp đồng thành công! Hợp đồng đã chuyển sang trạng thái "Chưa hiệu lực" và sẵn sàng để ký.');

        } catch (\Exception $e) {
            \Log::error('Lỗi phê duyệt hợp đồng: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi phê duyệt hợp đồng: ' . $e->getMessage());
        }
    }

    // public function kyHopDong($id)
    // {
    //     try {
    //         $hopDong = HopDongLaoDong::findOrFail($id);
            
    //         // Kiểm tra quyền ký (chỉ admin và HR mới có quyền)
    //         $user = Auth::user();
    //         $userRoles = optional($user->vaiTros)->pluck('ten')->toArray();
            
    //         if (!in_array('admin', $userRoles) && !in_array('hr', $userRoles)) {
    //             return redirect()->back()->with('error', 'Bạn không có quyền ký hợp đồng');
    //         }
            
    //         if ($hopDong->trang_thai_hop_dong !== 'chua_hieu_luc') {
    //             return redirect()->back()->with('error', 'Hợp đồng phải ở trạng thái "Chưa hiệu lực" để có thể ký');
    //         }

    //         if ($hopDong->trang_thai_ky !== 'cho_ky') {
    //             return redirect()->back()->with('error', 'Hợp đồng đã được ký trước đó');
    //         }

    //         // Cập nhật trạng thái: từ "chưa hiệu lực" → "hiệu lực", trạng thái ký từ "chờ ký" → "đã ký"
    //         $hopDong->update([
    //             'trang_thai_hop_dong' => 'hieu_luc',
    //             'trang_thai_ky' => 'da_ky',
    //             'nguoi_ky_id' => Auth::id(),
    //             'thoi_gian_ky' => now()
    //         ]);

    //         $hrUsers = \App\Models\NguoiDung::whereHas('vaiTros', function($q) {
    //             $q->where('ten', 'hr');
    //         })->get();

    //         foreach ($hrUsers as $hr) {
    //             $hr->notify(new \App\Notifications\HopDongSignedNotification($hopDong));
    //         }

    //         return redirect()->route('hopdong.show', $hopDong->id)
    //             ->with('success', 'Ký hợp đồng thành công! Hợp đồng đã chuyển sang trạng thái "Hiệu lực".');
                
    //     } catch (\Exception $e) {
    //         \Log::error('Lỗi ký hợp đồng: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'Có lỗi xảy ra khi ký hợp đồng: ' . $e->getMessage());
    //     }
    // }



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

    public function export(Request $request)
    {
        $query = HopDongLaoDong::with(['hoSoNguoiDung', 'chucVu', 'nguoiHuy.hoSo']);

        // Áp dụng các bộ lọc tương tự như trong method index
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('so_hop_dong', 'like', "%{$search}%")
                  ->orWhereHas('hoSoNguoiDung', function($q) use ($search) {
                      $q->where('ma_nhan_vien', 'like', "%{$search}%")
                        ->orWhere('ho', 'like', "%{$search}%")
                        ->orWhere('ten', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->loai_hop_dong) {
            $query->where('loai_hop_dong', $request->loai_hop_dong);
        }

        if ($request->trang_thai_hop_dong) {
            $query->where('trang_thai_hop_dong', $request->trang_thai_hop_dong);
        }

        if ($request->trang_thai_ky) {
            $query->where('trang_thai_ky', $request->trang_thai_ky);
        }

        // Loại trừ hợp đồng đã hủy bỏ và hợp đồng hết hạn đã được tái ký thành công
        $query->where(function($q) {
            $q->where('trang_thai_hop_dong', '!=', 'huy_bo')
              ->where(function($subQ) {
                  $subQ->where('trang_thai_hop_dong', '!=', 'het_han')
                       ->orWhere(function($innerQ) {
                           $innerQ->where('trang_thai_hop_dong', 'het_han')
                                  ->where(function($finalQ) {
                                      $finalQ->whereNull('trang_thai_tai_ky')
                                             ->orWhere('trang_thai_tai_ky', 'cho_tai_ky');
                                  });
                       });
              });
        });

        $hopDongs = $query->latest()->get();

        $fileName = 'danh_sach_hop_dong_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new HopDongExport($hopDongs), $fileName);
    }

    public function exportLuuTru(Request $request)
    {
        $query = HopDongLaoDong::with(['hoSoNguoiDung', 'chucVu', 'nguoiHuy.hoSo']);

        // Áp dụng các bộ lọc
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('so_hop_dong', 'like', "%{$search}%")
                  ->orWhereHas('hoSoNguoiDung', function($q) use ($search) {
                      $q->where('ma_nhan_vien', 'like', "%{$search}%")
                        ->orWhere('ho', 'like', "%{$search}%")
                        ->orWhere('ten', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->loai_hop_dong) {
            $query->where('loai_hop_dong', $request->loai_hop_dong);
        }

        if ($request->trang_thai_ky) {
            $query->where('trang_thai_ky', $request->trang_thai_ky);
        }

        // Chỉ export hợp đồng đã hủy bỏ và hợp đồng hết hạn đã được tái ký thành công
        $query->where(function($q) {
            $q->where('trang_thai_hop_dong', 'huy_bo')
              ->orWhere(function($subQ) {
                  $subQ->where('trang_thai_hop_dong', 'het_han')
                       ->where('trang_thai_tai_ky', 'da_tai_ky');
              });
        });

        $hopDongs = $query->latest()->get();

        $fileName = 'hop_dong_luu_tru_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new HopDongExport($hopDongs), $fileName);
    }

    private function getLoaiHopDongText($loaiHopDong)
    {
        switch ($loaiHopDong) {
            case 'thu_viec':
                return 'Thử việc';
            case 'xac_dinh_thoi_han':
                return 'Xác định thời hạn';
            case 'khong_xac_dinh_thoi_han':
                return 'Không xác định thời hạn';
            case 'mua_vu':
                return 'Mùa vụ';
            default:
                return 'Không xác định';
        }
    }

    private function getTrangThaiHopDongText($trangThai)
    {
        switch ($trangThai) {
            case 'tao_moi':
                return 'Tạo mới';
            case 'hieu_luc':
                return 'Đang hiệu lực';
            case 'chua_hieu_luc':
                return 'Chưa hiệu lực';
            case 'het_han':
                return 'Hết hạn';
            case 'huy_bo':
                return 'Đã hủy';
            default:
                return 'Không xác định';
        }
    }

    private function getTrangThaiKyText($trangThaiKy)
    {
        switch ($trangThaiKy) {
            case 'cho_ky':
                return 'Chờ ký';
            case 'da_ky':
                return 'Đã ký';
            default:
                return 'Không xác định';
        }
    }
}
