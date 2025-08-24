<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HopDongLaoDong;
use App\Models\NguoiDung;
use App\Models\ChucVu;
use App\Models\HoSoNguoiDung;
// PhuLucHopDong model đã được xóa
use App\Models\PhongBan;
use App\Models\Luong;
use App\Models\VaiTro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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

        // Loại trừ hợp đồng đã hủy bỏ, hợp đồng hết hạn đã được tái ký thành công, và hợp đồng từ chối ký
        $query->where(function($q) {
            $q->where('trang_thai_hop_dong', '!=', 'huy_bo')
              ->where('trang_thai_ky', '!=', 'tu_choi_ky') // Loại trừ hợp đồng từ chối ký
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

    public function cuaToi()
    {
        $user = Auth::user();

        // Chỉ lấy hợp đồng đã được HR gửi (trạng thái: hieu_luc, chua_hieu_luc, het_han)
        // Loại trừ hợp đồng: tao_moi (chưa gửi), huy_bo (đã hủy)
        $hopDongs = HopDongLaoDong::with([
            'hoSoNguoiDung',
            'nguoiDung.phongBan',
            'nguoiKy.hoSo',
            'chucVu',
            'nguoiHuy.hoSo',
            // Phụ lục đã được xóa
        ])->where('nguoi_dung_id', $user->id)
          ->whereIn('trang_thai_hop_dong', ['hieu_luc', 'chua_hieu_luc', 'het_han'])
          ->orderBy('created_at', 'desc')
          ->get();

        // Lấy hợp đồng hiện tại (ưu tiên hợp đồng hiệu lực)
        $hopDong = $hopDongs->where('trang_thai_hop_dong', 'hieu_luc')->first();

        if (!$hopDong) {
            // Nếu không có hợp đồng hiệu lực, lấy hợp đồng chưa hiệu lực
            $hopDong = $hopDongs->where('trang_thai_hop_dong', 'chua_hieu_luc')->first();
        }

        if (!$hopDong) {
            // Nếu không có hợp đồng chưa hiệu lực, lấy hợp đồng hết hạn
            $hopDong = $hopDongs->where('trang_thai_hop_dong', 'het_han')->first();
        }

        if (!$hopDong) {
            return view('admin.hopdong.cua-toi', compact('hopDong'))->with('message', 'Bạn chưa có hợp đồng nào được HR gửi.');
        }

        return view('admin.hopdong.cua-toi', compact('hopDong'));
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

        // Chỉ lấy hợp đồng đã hủy bỏ, hợp đồng hết hạn đã được tái ký thành công, và hợp đồng từ chối ký
        $query->where(function($q) {
            $q->where('trang_thai_hop_dong', 'huy_bo')
              ->orWhere('trang_thai_ky', 'tu_choi_ky') // Thêm hợp đồng từ chối ký
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

        // Lấy danh sách nhân viên:
        // 1. Có hồ sơ (hoSo)
        // 2. Đang làm việc (trang_thai = 1)
        // 3. KHÔNG có vai trò admin
        // 4. KHÔNG có hợp đồng với các trạng thái:
        //    - trạng thái ký = 'cho_ky' và trạng thái hợp đồng = 'tao_moi'
        //    - trạng thái ký = 'da_ky' và trạng thái hợp đồng = 'hieu_luc'
        //    - trạng thái ký = 'cho_ky' và trạng thái hợp đồng = 'chua_hieu_luc'
        // 5. HOẶC có hợp đồng đã từ chối ký (trang_thai_ky = 'tu_choi_ky')

        // Lấy tất cả nhân viên trước
        $allNhanViens = NguoiDung::whereHas('hoSo')
            ->where('trang_thai', 1)
            ->whereDoesntHave('vaiTros', function ($query) {
                $query->where('name', 'admin');
            })
            ->with(['hoSo', 'hopDongLaoDong'])
            ->get();

        // Lọc nhân viên theo điều kiện
        $nhanViens = $allNhanViens->filter(function ($nhanVien) {
            // Nhân viên chưa có hợp đồng nào
            if ($nhanVien->hopDongLaoDong->isEmpty()) {
                return true;
            }

            // Kiểm tra từng hợp đồng của nhân viên
            foreach ($nhanVien->hopDongLaoDong as $hopDong) {
                // Nếu có hợp đồng với trạng thái không được phép, loại trừ
                if (($hopDong->trang_thai_ky == 'cho_ky' && $hopDong->trang_thai_hop_dong == 'tao_moi') ||
                    ($hopDong->trang_thai_ky == 'da_ky' && $hopDong->trang_thai_hop_dong == 'hieu_luc') ||
                    ($hopDong->trang_thai_ky == 'cho_ky' && $hopDong->trang_thai_hop_dong == 'chua_hieu_luc')) {
                    return false;
                }
            }

            // Nếu không có hợp đồng nào bị loại trừ, cho phép
            return true;
        });

        // Debug: In ra danh sách nhân viên để kiểm tra
        // Log::info('Danh sách nhân viên được chọn:', $nhanViens->pluck('id')->toArray());

        // Debug: In ra chi tiết từng nhân viên và hợp đồng của họ
        // foreach ($nhanViens as $nhanVien) {
        //     Log::info("Nhân viên: {$nhanVien->hoSo->ho} {$nhanVien->hoSo->ten} (ID: {$nhanVien->id})");
        //     if ($nhanVien->hopDongLaoDong->isNotEmpty()) {
        //         foreach ($nhanVien->hopDongLaoDong as $hopDong) {
        //             Log::info("  - Hợp đồng: {$hopDong->so_hop_dong}, Trạng thái ký: {$hopDong->trang_thai_ky}, Trạng thái hợp đồng: {$hopDong->trang_thai_hop_dong}");
        //         }
        //     } else {
        //         Log::info("  - Không có hợp đồng nào");
        //     }
        // }

        // Nếu có một nhân viên được chỉ định để tái ký nhưng không nằm trong danh sách trên
        // (trường hợp hiếm), hãy thêm họ vào danh sách.
        if ($selectedNhanVienId && !$nhanViens->contains('id', $selectedNhanVienId)) {
            $nhanVienTaiKy = NguoiDung::with('hoSo')->find($selectedNhanVienId);
            if ($nhanVienTaiKy) {
                $nhanViens->push($nhanVienTaiKy);
            }
        }

        $chucVus = ChucVu::all();

        // Tạo số hợp đồng tự động
        $soHopDongTuDong = $this->generateSoHopDong();

        return view('admin.hopdong.create', compact('nhanViens', 'chucVus', 'selectedNhanVienId', 'soHopDongTuDong'));
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
            // 'hinh_thuc_lam_viec' => 'required|string', // Đã bỏ trường hình thức làm việc
            'dia_diem_lam_viec' => 'required|string',
            'dieu_khoan' => 'required|string',
            'ghi_chu' => 'nullable|string',
            'file_hop_dong' => 'required|array|min:1',
            'file_hop_dong.*' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'file_dinh_kem' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ], [
            'so_hop_dong.required' => 'Số hợp đồng không được để trống.',
            'so_hop_dong.unique' => 'Số hợp đồng đã tồn tại.',
            'file_hop_dong.required' => 'Vui lòng chọn file hợp đồng.',
            'file_hop_dong.array' => 'File hợp đồng không hợp lệ.',
            'file_hop_dong.min' => 'Vui lòng chọn ít nhất 1 file hợp đồng.',
            'file_hop_dong.*.required' => 'File hợp đồng không hợp lệ.',
            'file_hop_dong.*.file' => 'File hợp đồng không hợp lệ.',
            'file_hop_dong.*.mimes' => 'File hợp đồng phải có định dạng PDF, DOC hoặc DOCX.',
            'file_hop_dong.*.max' => 'File hợp đồng không được vượt quá 2MB.',
            'file_dinh_kem.file' => 'File đính kèm không hợp lệ.',
            'file_dinh_kem.mimes' => 'File đính kèm phải có định dạng PDF, DOC, DOCX, JPG, JPEG hoặc PNG.',
            'file_dinh_kem.max' => 'File đính kèm không được vượt quá 2MB.',
        ]);

        $data = $request->all();

        // Khi tạo mới hợp đồng, mặc định ở trạng thái "tạo mới"
        $data['trang_thai_hop_dong'] = 'tao_moi';
        $data['trang_thai_ky'] = 'cho_ky';
        $data['created_by'] = Auth::id(); // Lưu ID người tạo hợp đồng

        // Xử lý file hợp đồng - upload nhiều file
        if ($request->hasFile('file_hop_dong')) {
            $filePaths = [];
            $files = $request->file('file_hop_dong');

            foreach ($files as $file) {
                $path = $file->store('hop_dong', 'public');
                $filePaths[] = $path;
            }
            $data['duong_dan_file'] = implode(';', $filePaths);
        }

        // Xử lý file đính kèm
        if ($request->hasFile('file_dinh_kem')) {
            $file = $request->file('file_dinh_kem');
            $path = $file->store('file_dinh_kem', 'public');
            $data['file_dinh_kem'] = $path;
        }

        $nguoiDungId = $request->nguoi_dung_id;
        $hopDong = HopDongLaoDong::create($data);

        // Tạo bản ghi lương tương ứng với hợp đồng vừa tạo
        try {
            Luong::create([
                'nguoi_dung_id' => $nguoiDungId,
                'hop_dong_lao_dong_id' => $hopDong->id,
                'luong_co_ban' => $request->luong_co_ban,
                'phu_cap' => $request->phu_cap ?? 0,
            ]);
        } catch (\Exception $e) {
            // Nếu tạo bản ghi lương thất bại, xóa hợp đồng vừa tạo và trả về lỗi
            $hopDong->delete();
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo bản ghi lương: ' . $e->getMessage())->withInput();
        }

        // Cập nhật trạng thái tái ký cho các hợp đồng đã hết hạn trước đó
        HopDongLaoDong::where('nguoi_dung_id', $nguoiDungId)
            ->where('id', '!=', $hopDong->id) // Loại trừ hợp đồng vừa tạo
            ->where('trang_thai_hop_dong', 'het_han')
            ->where('trang_thai_tai_ky', 'cho_tai_ky')
            ->update(['trang_thai_tai_ky' => 'da_tai_ky']);

        return redirect()->route('hopdong.index')->with('success', 'Hợp đồng đã được tạo thành công và bản ghi lương đã được tạo.');
    }

    public function show($id)
    {
        $hopDong = HopDongLaoDong::with([
            'hoSoNguoiDung',
            'nguoiDung.phongBan',
            'nguoiKy.hoSo',
            'chucVu',
            'nguoiHuy.hoSo',
            // Phụ lục đã được xóa
        ])->findOrFail($id);

        return view('admin.hopdong.show', compact('hopDong'));
    }

    public function edit($id)
    {
        $hopDong = HopDongLaoDong::with([
            'hoSoNguoiDung',
            'chucVu',
            // Phụ lục đã được xóa
        ])->findOrFail($id);

        // Kiểm tra điều kiện không cho phép sửa đổi
        if (($hopDong->trang_thai_ky === 'cho_ky' && $hopDong->trang_thai_hop_dong === 'chua_hieu_luc') ||
            $hopDong->trang_thai_ky === 'tu_choi_ky') {
            $errorMessage = $hopDong->trang_thai_ky === 'tu_choi_ky'
                ? 'Không thể sửa đổi hợp đồng đã bị từ chối ký.'
                : 'Không thể sửa đổi hợp đồng khi đã gửi hợp đồng đó cho nhân viên.';
            return redirect()->route('hopdong.index')->with('error', $errorMessage);
        }

        // Lấy danh sách nhân viên tương tự như create, nhưng bao gồm cả nhân viên hiện tại của hợp đồng

        // Lấy tất cả nhân viên trước
        $allNhanViens = NguoiDung::whereHas('hoSo')
            ->where('trang_thai', 1)
            ->whereDoesntHave('vaiTros', function ($query) {
                $query->where('name', 'admin');
            })
            ->with(['hoSo', 'hopDongLaoDong'])
            ->get();

        // Lọc nhân viên theo điều kiện
        $nhanViens = $allNhanViens->filter(function ($nhanVien) use ($hopDong) {
            // Luôn cho phép nhân viên hiện tại của hợp đồng đang chỉnh sửa
            if ($nhanVien->id == $hopDong->nguoi_dung_id) {
                return true;
            }

            // Nhân viên chưa có hợp đồng nào
            if ($nhanVien->hopDongLaoDong->isEmpty()) {
                return true;
            }

            // Kiểm tra từng hợp đồng của nhân viên
            foreach ($nhanVien->hopDongLaoDong as $hopDongItem) {
                // Nếu có hợp đồng với trạng thái không được phép, loại trừ
                if (($hopDongItem->trang_thai_ky == 'cho_ky' && $hopDongItem->trang_thai_hop_dong == 'tao_moi') ||
                    ($hopDongItem->trang_thai_ky == 'da_ky' && $hopDongItem->trang_thai_hop_dong == 'hieu_luc') ||
                    ($hopDongItem->trang_thai_ky == 'cho_ky' && $hopDongItem->trang_thai_hop_dong == 'chua_hieu_luc')) {
                    return false;
                }
            }

            // Nếu không có hợp đồng nào bị loại trừ, cho phép
            return true;
        });
        $chucVus = ChucVu::all();
        return view('admin.hopdong.edit', compact('hopDong', 'nhanViens', 'chucVus'));
    }

    public function update(Request $request, $id)
    {
        $hopDong = HopDongLaoDong::findOrFail($id);

        // Kiểm tra điều kiện không cho phép sửa đổi
        if (($hopDong->trang_thai_ky === 'cho_ky' && $hopDong->trang_thai_hop_dong === 'chua_hieu_luc') ||
            $hopDong->trang_thai_ky === 'tu_choi_ky') {
            $errorMessage = $hopDong->trang_thai_ky === 'tu_choi_ky'
                ? 'Không thể sửa đổi hợp đồng đã bị từ chối ký.'
                : 'Không thể sửa đổi hợp đồng khi đã gửi hợp đồng đó cho nhân viên.';
            return redirect()->route('hopdong.index')->with('error', $errorMessage);
        }

        $validationRules = [
            'chuc_vu_id' => 'required|exists:chuc_vu,id',
            'loai_hop_dong' => 'required|string',
            'ngay_bat_dau' => 'required|date',
            'luong_co_ban' => 'required|numeric|min:0',
            'phu_cap' => 'nullable|numeric|min:0',
            'dia_diem_lam_viec' => 'required|string',
            'ghi_chu' => 'nullable|string',
            'trang_thai_ky' => 'required|in:cho_ky,da_ky',
            'file_hop_dong' => 'nullable|array|min:1',
            'file_hop_dong.*' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'file_dinh_kem' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ];

        // Chỉ bắt buộc ngày kết thúc nếu không phải hợp đồng không xác định thời hạn
        if ($request->loai_hop_dong !== 'khong_xac_dinh_thoi_han') {
            $validationRules['ngay_ket_thuc'] = 'required|date|after:ngay_bat_dau';
        } else {
            $validationRules['ngay_ket_thuc'] = 'nullable|date|after:ngay_bat_dau';
        }

        $request->validate($validationRules, [
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
            'dia_diem_lam_viec.required' => 'Vui lòng nhập địa điểm làm việc.',
            'trang_thai_ky.required' => 'Vui lòng chọn trạng thái ký.',
            'trang_thai_ky.in' => 'Trạng thái ký không hợp lệ.',
            'file_hop_dong.array' => 'File hợp đồng không hợp lệ.',
            'file_hop_dong.min' => 'Vui lòng chọn ít nhất 1 file hợp đồng.',
            'file_hop_dong.*.required' => 'File hợp đồng không hợp lệ.',
            'file_hop_dong.*.file' => 'File hợp đồng không hợp lệ.',
            'file_hop_dong.*.mimes' => 'File hợp đồng phải có định dạng PDF, DOC hoặc DOCX.',
            'file_hop_dong.*.max' => 'File hợp đồng không được vượt quá 2MB.',
            'file_dinh_kem.file' => 'File đính kèm không hợp lệ.',
            'file_dinh_kem.mimes' => 'File đính kèm phải có định dạng PDF, DOC, DOCX, JPG, JPEG hoặc PNG.',
            'file_dinh_kem.max' => 'File đính kèm không được vượt quá 2MB.',
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

        $data = $request->except(['file_hop_dong', 'file_dinh_kem', 'trang_thai_hop_dong']);

        // Không tự động thay đổi trạng thái hợp đồng khi update
        // Trạng thái hợp đồng chỉ thay đổi thông qua các action riêng biệt (gửi, ký, hủy)

        // Xử lý file hợp đồng - upload nhiều file
        if ($request->hasFile('file_hop_dong')) {
            // Xóa file cũ nếu có
            if ($hopDong->duong_dan_file) {
                $oldFiles = explode(';', $hopDong->duong_dan_file);
                foreach ($oldFiles as $oldFile) {
                    if (trim($oldFile)) {
                        Storage::disk('public')->delete(trim($oldFile));
                    }
                }
            }

            $filePaths = [];
            $files = $request->file('file_hop_dong');

            foreach ($files as $file) {
                $path = $file->store('hop_dong', 'public');
                $filePaths[] = $path;
            }
            $data['duong_dan_file'] = implode(';', $filePaths);
        } else {
            // Nếu không có file mới, giữ lại file cũ
            $data['duong_dan_file'] = $hopDong->duong_dan_file;
        }

        // Xử lý file đính kèm
        if ($request->hasFile('file_dinh_kem')) {
            // Xóa file đính kèm cũ nếu có
            if ($hopDong->file_dinh_kem) {
                Storage::disk('public')->delete($hopDong->file_dinh_kem);
            }

            $file = $request->file('file_dinh_kem');
            $path = $file->store('file_dinh_kem', 'public');
            $data['file_dinh_kem'] = $path;
        } else {
            // Nếu không có file đính kèm mới, giữ lại file cũ
            $data['file_dinh_kem'] = $hopDong->file_dinh_kem;
        }

        $hopDong->update($data);

        // Cập nhật bản ghi lương tương ứng nếu lương cơ bản hoặc phụ cấp thay đổi
        try {
            $luong = Luong::where('hop_dong_lao_dong_id', $hopDong->id)->first();

            if ($luong) {
                // Chỉ cập nhật nếu có thay đổi về lương cơ bản hoặc phụ cấp
                if ($luong->luong_co_ban != $request->luong_co_ban || $luong->phu_cap != ($request->phu_cap ?? 0)) {
                    $luong->update([
                        'luong_co_ban' => $request->luong_co_ban,
                        'phu_cap' => $request->phu_cap ?? 0,
                    ]);
                }
            } else {
                // Nếu chưa có bản ghi lương, tạo mới
                Luong::create([
                    'nguoi_dung_id' => $hopDong->nguoi_dung_id,
                    'hop_dong_lao_dong_id' => $hopDong->id,
                    'luong_co_ban' => $request->luong_co_ban,
                    'phu_cap' => $request->phu_cap ?? 0,
                ]);
            }
        } catch (\Exception $e) {
            // Log lỗi nhưng không dừng quá trình cập nhật hợp đồng
            \Log::error('Lỗi cập nhật bản ghi lương: ' . $e->getMessage());
        }

        return redirect()->route('hopdong.index')
            ->with('success', 'Cập nhật hợp đồng thành công');
    }

    public function destroy($id)
    {
        $hopDong = HopDongLaoDong::findOrFail($id);

        // Xóa bản ghi lương tương ứng trước
        try {
            Luong::where('hop_dong_lao_dong_id', $hopDong->id)->delete();
        } catch (\Exception $e) {
            \Log::error('Lỗi xóa bản ghi lương: ' . $e->getMessage());
        }

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
        $userRoles = optional($user->vaiTros)->pluck('name')->toArray();

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

            // Gửi thông báo cho nhân viên
            $nhanVien = $hopDong->nguoiDung;
            if ($nhanVien) {
                $nhanVien->notify(new \App\Notifications\HopDongCancelledNotification($hopDong));
            }

            return redirect()->route('hopdong.show', $hopDong->id)
                ->with('success', 'Hủy hợp đồng thành công. Thông báo đã được gửi đến nhân viên.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi hủy hợp đồng. Vui lòng thử lại.');
        }
    }

    public function pheDuyetHopDong($id)
    {
        try {
            $hopDong = HopDongLaoDong::findOrFail($id);

            // Kiểm tra quyền gửi hợp đồng (chỉ admin và HR mới có quyền)
            $user = Auth::user();
            $userRoles = optional($user->vaiTros)->pluck('name')->toArray();

            if (!in_array('admin', $userRoles) && !in_array('hr', $userRoles)) {
                return redirect()->back()->with('error', 'Bạn không có quyền gửi hợp đồng cho nhân viên');
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
                ->with('success', 'Gửi hợp đồng cho nhân viên thành công! Hợp đồng đã chuyển sang trạng thái "Chưa hiệu lực" và sẵn sàng để ký.');

        } catch (\Exception $e) {
            \Log::error('Lỗi gửi hợp đồng cho nhân viên: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi gửi hợp đồng cho nhân viên: ' . $e->getMessage());
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



    // Methods phụ lục đã được xóa

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

        // Chỉ export hợp đồng đã hủy bỏ, hợp đồng hết hạn đã được tái ký thành công, và hợp đồng từ chối ký
        $query->where(function($q) {
            $q->where('trang_thai_hop_dong', 'huy_bo')
              ->orWhere('trang_thai_ky', 'tu_choi_ky') // Thêm hợp đồng từ chối ký
              ->orWhere(function($subQ) {
                  $subQ->where('trang_thai_hop_dong', 'het_han')
                       ->where('trang_thai_tai_ky', 'da_tai_ky');
              });
        });

        $hopDongs = $query->latest()->get();

        $fileName = 'hop_dong_luu_tru_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new HopDongExport($hopDongs), $fileName);
    }

    public function thongKe(Request $request)
    {
        // Lấy tham số thời gian từ request
        $tuNgay = $request->input('tu_ngay');
        $denNgay = $request->input('den_ngay');

        // Tạo query builder cơ bản
        $query = HopDongLaoDong::query();

        // Áp dụng filter thời gian nếu có
        if ($tuNgay && $denNgay) {
            $query->whereBetween('hop_dong_lao_dong.created_at', [$tuNgay . ' 00:00:00', $denNgay . ' 23:59:59']);
        }

        // Thống kê tổng quan
        $tongHopDong = (clone $query)->count();
        $hopDongHieuLuc = (clone $query)->where('hop_dong_lao_dong.trang_thai_hop_dong', 'hieu_luc')->count();
        $hopDongChuaHieuLuc = (clone $query)->where('hop_dong_lao_dong.trang_thai_hop_dong', 'chua_hieu_luc')->count();
        $hopDongHetHan = (clone $query)->where('hop_dong_lao_dong.trang_thai_hop_dong', 'het_han')->count();
        $hopDongHuyBo = (clone $query)->where('hop_dong_lao_dong.trang_thai_hop_dong', 'huy_bo')->count();
        $hopDongTaoMoi = (clone $query)->where('hop_dong_lao_dong.trang_thai_hop_dong', 'tao_moi')->count();

        // Thống kê theo loại hợp đồng
        $thongKeLoaiHopDong = (clone $query)->selectRaw('hop_dong_lao_dong.loai_hop_dong, COUNT(*) as so_luong')
            ->groupBy('hop_dong_lao_dong.loai_hop_dong')
            ->get()
            ->keyBy('loai_hop_dong');

        // Thống kê theo trạng thái ký
        $thongKeTrangThaiKy = (clone $query)->selectRaw('hop_dong_lao_dong.trang_thai_ky, COUNT(*) as so_luong')
            ->groupBy('hop_dong_lao_dong.trang_thai_ky')
            ->get()
            ->keyBy('trang_thai_ky');

        // Thống kê theo tháng trong năm hiện tại hoặc năm được chọn
        $namHienTai = $tuNgay ? date('Y', strtotime($tuNgay)) : now()->year;
        $thongKeTheoThang = (clone $query)->selectRaw('MONTH(hop_dong_lao_dong.created_at) as thang, COUNT(*) as so_luong')
            ->whereYear('hop_dong_lao_dong.created_at', $namHienTai)
            ->groupBy('thang')
            ->orderBy('thang')
            ->get();

        // Thống kê theo phòng ban
        $thongKeTheoPhongBan = (clone $query)->join('nguoi_dung', 'hop_dong_lao_dong.nguoi_dung_id', '=', 'nguoi_dung.id')
            ->join('phong_ban', 'nguoi_dung.phong_ban_id', '=', 'phong_ban.id')
            ->selectRaw('phong_ban.ten_phong_ban, COUNT(*) as so_luong')
            ->groupBy('phong_ban.id', 'phong_ban.ten_phong_ban')
            ->orderBy('so_luong', 'desc')
            ->get();

        // Thống kê hợp đồng sắp hết hạn (30 ngày tới)
        $hopDongSapHetHan = HopDongLaoDong::where('trang_thai_hop_dong', 'hieu_luc')
            ->where('ngay_ket_thuc', '>', now())
            ->where('ngay_ket_thuc', '<=', now()->addDays(30))
            ->with(['hoSoNguoiDung', 'chucVu'])
            ->get();

        // Thống kê hợp đồng mới trong tháng
        $hopDongMoiTrongThang = (clone $query)->whereMonth('hop_dong_lao_dong.created_at', now()->month)
            ->whereYear('hop_dong_lao_dong.created_at', now()->year)
            ->count();

        // Thống kê hợp đồng hết hạn trong tháng
        $hopDongHetHanTrongThang = (clone $query)->whereMonth('hop_dong_lao_dong.ngay_ket_thuc', now()->month)
            ->whereYear('hop_dong_lao_dong.ngay_ket_thuc', now()->year)
            ->where('hop_dong_lao_dong.trang_thai_hop_dong', 'het_han')
            ->count();

        // Thống kê lương trung bình theo loại hợp đồng
        $luongTrungBinhTheoLoai = (clone $query)->selectRaw('hop_dong_lao_dong.loai_hop_dong, AVG(hop_dong_lao_dong.luong_co_ban) as luong_trung_binh')
            ->groupBy('hop_dong_lao_dong.loai_hop_dong')
            ->get();

        // Thống kê theo năm
        $thongKeTheoNam = HopDongLaoDong::selectRaw('YEAR(created_at) as nam, COUNT(*) as so_luong')
            ->groupBy('nam')
            ->orderBy('nam', 'desc')
            ->get();

        return view('admin.hopdong.thong-ke', compact(
            'tongHopDong',
            'hopDongHieuLuc',
            'hopDongChuaHieuLuc',
            'hopDongHetHan',
            'hopDongHuyBo',
            'hopDongTaoMoi',
            'thongKeLoaiHopDong',
            'thongKeTrangThaiKy',
            'thongKeTheoThang',
            'thongKeTheoPhongBan',
            'hopDongSapHetHan',
            'hopDongMoiTrongThang',
            'hopDongHetHanTrongThang',
            'luongTrungBinhTheoLoai',
            'thongKeTheoNam',
            'namHienTai',
            'tuNgay',
            'denNgay'
        ));
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

    /**
     * Tạo số hợp đồng tự động không trùng lặp
     */
    private function generateSoHopDong()
    {
        $year = date('Y');
        $prefix = 'HD';

        do {
            // Tạo số ngẫu nhiên 4 chữ số
            $randomNumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $soHopDong = $prefix . $randomNumber . '-' . $year;

            // Kiểm tra xem số hợp đồng đã tồn tại chưa
            $exists = HopDongLaoDong::where('so_hop_dong', $soHopDong)->exists();
        } while ($exists);

        return $soHopDong;
    }

    /**
     * Hiển thị form để nhân viên ký hợp đồng
     */
    public function kyHopDong($id)
    {
        $hopDong = HopDongLaoDong::with(['hoSoNguoiDung', 'nguoiKy', 'chucVu', 'nguoiGuiHopDong.hoSo'])->findOrFail($id);

        // Kiểm tra quyền: chỉ nhân viên sở hữu hợp đồng mới được ký
        if ($hopDong->nguoi_dung_id !== Auth::id()) {
            return redirect()->route('hopdong.cua-toi')->with('error', 'Bạn không có quyền ký hợp đồng này.');
        }

        // Kiểm tra trạng thái hợp đồng - chỉ cho phép ký hợp đồng đã được HR phê duyệt
        if (!in_array($hopDong->trang_thai_hop_dong, ['hieu_luc', 'chua_hieu_luc', 'het_han'])) {
            return redirect()->route('hopdong.cua-toi')->with('error', 'Hợp đồng này chưa được HR phê duyệt. Vui lòng chờ phê duyệt trước khi ký.');
        }

        // Kiểm tra trạng thái ký
        if ($hopDong->trang_thai_ky === 'da_ky') {
            return redirect()->route('hopdong.cua-toi')->with('error', 'Hợp đồng này đã được ký.');
        }

        return view('admin.hopdong.ky-hop-dong', compact('hopDong'));
    }

    /**
     * Xử lý việc nhân viên ký hợp đồng và upload file
     */
    public function xuLyKyHopDong(Request $request, $id)
    {
        $request->validate([
            'file_hop_dong_da_ky' => 'required|array',
            'file_hop_dong_da_ky.*' => 'file|mimes:pdf,jpg,jpeg,png|max:10240', // Max 10MB per file
        ], [
            'file_hop_dong_da_ky.required' => 'BẮT BUỘC: Vui lòng upload file hợp đồng đã được ký. Không thể ký hợp đồng mà không có file.',
            'file_hop_dong_da_ky.array' => 'Vui lòng chọn ít nhất một file hợp đồng đã ký.',
            'file_hop_dong_da_ky.*.file' => 'File không hợp lệ. Vui lòng chọn file hợp đồng đã ký.',
            'file_hop_dong_da_ky.*.mimes' => 'File phải có định dạng PDF, JPG, JPEG hoặc PNG.',
            'file_hop_dong_da_ky.*.max' => 'File không được lớn hơn 10MB.',
        ]);

        $hopDong = HopDongLaoDong::findOrFail($id);

        // Kiểm tra quyền
        if ($hopDong->nguoi_dung_id !== Auth::id()) {
            return redirect()->route('hopdong.cua-toi')->with('error', 'Bạn không có quyền ký hợp đồng này.');
        }

        // Kiểm tra trạng thái hợp đồng - chỉ cho phép ký hợp đồng đã được HR phê duyệt
        if (!in_array($hopDong->trang_thai_hop_dong, ['hieu_luc', 'chua_hieu_luc', 'het_han'])) {
            return redirect()->route('hopdong.cua-toi')->with('error', 'Hợp đồng này chưa được HR phê duyệt. Vui lòng chờ phê duyệt trước khi ký.');
        }

        // Kiểm tra trạng thái ký
        if ($hopDong->trang_thai_ky === 'da_ky') {
            return redirect()->route('hopdong.cua-toi')->with('error', 'Hợp đồng này đã được ký.');
        }

        try {
            // Upload nhiều file hợp đồng đã ký
            if ($request->hasFile('file_hop_dong_da_ky')) {
                $files = $request->file('file_hop_dong_da_ky');
                $uploadedFiles = [];

                // Kiểm tra tổng kích thước file (tối đa 50MB)
                $totalSize = 0;
                foreach ($files as $file) {
                    $totalSize += $file->getSize();
                }

                if ($totalSize > 50 * 1024 * 1024) { // 50MB
                    return redirect()->back()->with('error', 'Tổng kích thước file quá lớn! Tối đa 50MB cho tất cả file.');
                }

                // Upload từng file
                foreach ($files as $index => $file) {
                    $fileName = 'hop_dong_da_ky_' . $hopDong->so_hop_dong . '_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('hop_dong_da_ky', $fileName, 'public');
                    $uploadedFiles[] = $filePath;
                }

                // Lưu danh sách file (cách nhau bằng dấu chấm phẩy)
                $filePathsString = implode(';', $uploadedFiles);

                // Chuẩn bị dữ liệu cập nhật
                $updateData = [
                    'file_hop_dong_da_ky' => $filePathsString,
                    'trang_thai_ky' => 'da_ky',
                    'nguoi_ky_id' => Auth::id(),
                    'thoi_gian_ky' => now(),
                ];

                // Tự động chuyển trạng thái hợp đồng thành "hiệu lực" khi ký
                if (in_array($hopDong->trang_thai_hop_dong, ['tao_moi', 'chua_hieu_luc'])) {
                    $updateData['trang_thai_hop_dong'] = 'hieu_luc';
                }

                // Cập nhật thông tin hợp đồng
                $hopDong->update($updateData);

                $fileCount = count($uploadedFiles);
                $successMessage = "Ký hợp đồng thành công! Đã upload {$fileCount} file hợp đồng đã ký vào hệ thống.";

                // Thêm thông báo nếu trạng thái hợp đồng đã thay đổi
                if (isset($updateData['trang_thai_hop_dong']) && $updateData['trang_thai_hop_dong'] === 'hieu_luc') {
                    $successMessage .= ' Hợp đồng đã chuyển sang trạng thái hiệu lực.';
                }

                // Gửi thông báo cho HR và Admin
                $hrUsers = NguoiDung::whereHas('vaiTros', function ($q) {
                    $q->where('name', 'hr');
                })->get();

                $adminUsers = NguoiDung::whereHas('vaiTros', function ($q) {
                    $q->where('name', 'admin');
                })->get();

                // Gửi thông báo cho HR
                foreach ($hrUsers as $hr) {
                    $hr->notify(new \App\Notifications\HopDongSignedNotification($hopDong));
                }

                // Gửi thông báo cho Admin
                foreach ($adminUsers as $admin) {
                    $admin->notify(new \App\Notifications\HopDongSignedNotification($hopDong));
                }

                return redirect()->route('hopdong.cua-toi')->with('success', $successMessage);
            } else {
                return redirect()->back()->with('error', 'Không có file nào được upload.');
            }
        } catch (\Exception $e) {
            return redirect()->route('hopdong.cua-toi')->with('error', 'Có lỗi xảy ra khi upload file: ' . $e->getMessage());
        }

        return redirect()->route('hopdong.cua-toi')->with('error', 'Có lỗi xảy ra khi ký hợp đồng.');
    }

    /**
     * Xử lý việc từ chối ký hợp đồng
     */
    public function tuChoiKy(Request $request, $id)
    {
        $request->validate([
            'ly_do_tu_choi' => 'required|string|min:10|max:1000',
        ], [
            'ly_do_tu_choi.required' => 'Vui lòng nhập lý do từ chối ký.',
            'ly_do_tu_choi.min' => 'Lý do từ chối phải có ít nhất 10 ký tự.',
            'ly_do_tu_choi.max' => 'Lý do từ chối không được quá 1000 ký tự.',
        ]);

        $hopDong = HopDongLaoDong::findOrFail($id);

        // Kiểm tra quyền
        if ($hopDong->nguoi_dung_id !== Auth::id()) {
            return redirect()->route('hopdong.cua-toi')->with('error', 'Bạn không có quyền từ chối ký hợp đồng này.');
        }

        // Kiểm tra trạng thái hợp đồng - chỉ cho phép từ chối hợp đồng đã được HR phê duyệt
        if (!in_array($hopDong->trang_thai_hop_dong, ['hieu_luc', 'chua_hieu_luc', 'het_han'])) {
            return redirect()->route('hopdong.cua-toi')->with('error', 'Hợp đồng này chưa được HR phê duyệt.');
        }

        // Kiểm tra trạng thái ký
        if ($hopDong->trang_thai_ky === 'da_ky') {
            return redirect()->route('hopdong.cua-toi')->with('error', 'Hợp đồng này đã được ký.');
        }

        if ($hopDong->trang_thai_ky === 'tu_choi_ky') {
            return redirect()->route('hopdong.cua-toi')->with('error', 'Hợp đồng này đã được từ chối ký.');
        }

        try {
            // Cập nhật thông tin hợp đồng
            $hopDong->update([
                'trang_thai_ky' => 'tu_choi_ky',
                'ghi_chu' => 'Từ chối ký: ' . $request->ly_do_tu_choi,
            ]);

            // Gửi thông báo cho HR và Admin
            $hrUsers = NguoiDung::whereHas('vaiTros', function ($q) {
                $q->where('name', 'hr');
            })->get();

            $adminUsers = NguoiDung::whereHas('vaiTros', function ($q) {
                $q->where('name', 'admin');
            })->get();

            // Gửi thông báo cho HR
            foreach ($hrUsers as $hr) {
                $hr->notify(new \App\Notifications\HopDongRefusedNotification($hopDong));
            }

            // Gửi thông báo cho Admin
            foreach ($adminUsers as $admin) {
                $admin->notify(new \App\Notifications\HopDongRefusedNotification($hopDong));
            }

            return redirect()->route('hopdong.cua-toi')->with('success', 'Đã từ chối ký hợp đồng thành công. Lý do từ chối đã được gửi đến phòng Nhân sự.');
        } catch (\Exception $e) {
            return redirect()->route('hopdong.cua-toi')->with('error', 'Có lỗi xảy ra khi từ chối ký hợp đồng: ' . $e->getMessage());
        }
    }

    /**
     * Ẩn hợp đồng khỏi danh sách chính
     */
    public function anKhoiDanhSach(Request $request)
    {
        $request->validate([
            'hop_dong_id' => 'required|exists:hop_dong_lao_dong,id',
        ], [
            'hop_dong_id.required' => 'ID hợp đồng không được để trống.',
            'hop_dong_id.exists' => 'Hợp đồng không tồn tại.',
        ]);

        $hopDong = HopDongLaoDong::findOrFail($request->hop_dong_id);

        // Kiểm tra quyền - chỉ admin và hr mới có thể ẩn hợp đồng
        $user = Auth::user();
        if (!in_array($user->vaiTro->name, ['admin', 'hr'])) {
            return redirect()->back()->with('error', 'Bạn không có quyền thực hiện hành động này.');
        }

        // Chỉ cho phép ẩn hợp đồng hết hạn
        if ($hopDong->trang_thai_hop_dong !== 'het_han') {
            return redirect()->back()->with('error', 'Chỉ có thể ẩn hợp đồng đã hết hạn.');
        }

        try {
            // Cập nhật trạng thái tái ký để ẩn khỏi danh sách chính
            $hopDong->update([
                'trang_thai_tai_ky' => 'da_tai_ky',
                'ghi_chu' => 'Đã ẩn khỏi danh sách chính bởi ' . $user->email . ' vào ' . now()->format('d/m/Y H:i:s'),
            ]);

            return redirect()->back()->with('success', 'Đã ẩn hợp đồng khỏi danh sách chính thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi ẩn hợp đồng: ' . $e->getMessage());
        }
    }
}
