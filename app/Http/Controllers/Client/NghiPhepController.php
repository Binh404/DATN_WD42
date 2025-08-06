<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DonXinNghi;
use App\Models\LichSuDuyetDonNghi;
use App\Models\LoaiNghiPhep;
use App\Models\NguoiDung;
use App\Models\SoDuNghiPhepNhanVien;
use App\Models\VaiTro;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NghiPhepController extends Controller
{

    // danh sách của người gửi
    public function index()
    {
        $user = auth()->user();
        $donXinNghis = DonXinNghi::with('loaiNghiPhep', 'banGiaoCho')->where('nguoi_dung_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('employe.nghiphep.index', compact('donXinNghis'));
    }

    public function create()
    {
        $user = auth()->user();
        $namHienTai = Carbon::now()->year;
        $soDus = SoDuNghiPhepNhanVien::with('loaiNghiPhep')->where('nguoi_dung_id', $user->id)
            ->where('nam', $namHienTai)->get();
        if ($soDus->count() == 0) {
            return redirect()->route('nghiphep.index')->with('error', 'Bạn không có số dư nghỉ phép nào!');
        }

        $nguoiBanGiaos = NguoiDung::where('phong_ban_id', $user->phong_ban_id)->where('id', '!=', $user->id)->get();

        return view('employe.nghiphep.create', compact('soDus', 'nguoiBanGiaos'));
    }

    private function generateUniqueMaDonNghi()
    {
        do {
            $code = 'DXN' . mt_rand(100000, 999999);
        } while (DonXinNghi::where('ma_don_nghi', $code)->exists());

        return $code;
    }


    public function store(Request $request)
    {

        $user = auth()->user();

        $validated = $request->validate([
            'loai_nghi_phep_id' => 'required|exists:loai_nghi_phep,id',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after_or_equal:ngay_bat_dau',
            'ly_do' => 'required|string',
            'lien_he_khan_cap' => 'required|string|max:255',
            'sdt_khan_cap' => ['required', 'regex:/^0[0-9]{9}$/'],
            'ban_giao_cho_id' => 'nullable|exists:nguoi_dung,id',
            'ghi_chu_ban_giao' => 'nullable|string',
        ], [
            'loai_nghi_phep_id.required' => 'Vui lòng chọn loại nghỉ phép.',
            'loai_nghi_phep_id.exists' => 'Loại nghỉ phép không hợp lệ.',

            'ngay_bat_dau.required' => 'Vui lòng chọn ngày bắt đầu nghỉ.',
            'ngay_bat_dau.date' => 'Ngày bắt đầu nghỉ không đúng định dạng ngày.',

            'ngay_ket_thuc.required' => 'Vui lòng chọn ngày kết thúc nghỉ.',
            'ngay_ket_thuc.date' => 'Ngày kết thúc nghỉ không đúng định dạng ngày.',
            'ngay_ket_thuc.after_or_equal' => 'Ngày kết thúc phải bằng hoặc sau ngày bắt đầu.',

            'ly_do.required' => 'Vui lòng nhập lý do nghỉ.',
            'ly_do.string' => 'Lý do nghỉ phải là chuỗi ký tự.',

            'lien_he_khan_cap.required' => 'Vui lòng nhập thông tin liên hệ khẩn cấp.',
            'lien_he_khan_cap.string' => 'Liên hệ khẩn cấp phải là chuỗi ký tự.',
            'lien_he_khan_cap.max' => 'Liên hệ khẩn cấp không được vượt quá 255 ký tự.',

            'sdt_khan_cap.required' => 'Vui lòng nhập số điện thoại khẩn cấp.',
            'sdt_khan_cap.regex' => 'Số điện thoại phải có 10 chữ số và bắt đầu bằng số 0.',

            'ban_giao_cho_id.exists' => 'Người được bàn giao không tồn tại.',

            'ghi_chu_ban_giao.string' => 'Ghi chú bàn giao phải là chuỗi ký tự.',
        ]);

        // Tạo mã đơn không trùng
        $validated['ma_don_nghi'] = $this->generateUniqueMaDonNghi();


        // Xử lý upload nhiều file tài liệu hỗ trợ (nếu có)
        $taiLieuPaths = [];
        if ($request->hasFile('tai_lieu_ho_tro')) {
            foreach ($request->file('tai_lieu_ho_tro') as $file) {
                $path = $file->store('don_xin_nghi/tai_lieu', 'public');
                $taiLieuPaths[] = $path;
            }
        }

        $ngayHienTai = Carbon::today();
        $namHienTai = Carbon::today()->year;
        $ngayBatDau = Carbon::parse($validated['ngay_bat_dau']);
        $ngayKetThuc = Carbon::parse($validated['ngay_ket_thuc']);
        $soNgayNghi = $ngayBatDau->diffInDays($ngayKetThuc, false) + 1;

        // kiểm tra số dư nghỉ phép
        $soDuNghiPhep = SoDuNghiPhepNhanVien::where('nguoi_dung_id', $user->id)
            ->where('loai_nghi_phep_id', $validated['loai_nghi_phep_id'])
            ->where('nam', $namHienTai)
            ->first();

        if (!$soDuNghiPhep || $soDuNghiPhep->so_ngay_con_lai < $soNgayNghi) {
            return redirect()->route('nghiphep.create')->with('error', 'Số dư nghỉ phép không đủ!');
        }

        // kiểm tra số ngày báo trước
        $loaiNghiPhep = LoaiNghiPhep::where('id', $validated['loai_nghi_phep_id'])->first();
        $soNgayBaoTruoc = $loaiNghiPhep->so_ngay_bao_truoc;
        $khoangCachNgayBao = $ngayHienTai->diffInDays($ngayBatDau, false);

        if ($soNgayBaoTruoc && $khoangCachNgayBao < $soNgayBaoTruoc) {
            return redirect()->route('nghiphep.create')->with('error', 'Số ngày báo trước phải là ' . $soNgayBaoTruoc . ' ngày!');
        }

        // Gán dữ liệu mặc định
        $validated['nguoi_dung_id'] = $user->id;
        $validated['so_ngay_nghi'] = $soNgayNghi;
        $validated['trang_thai'] = 'cho_duyet';
        $validated['tai_lieu_ho_tro'] = $taiLieuPaths;

        if ($user->coVaiTro('department')) {
            $validated['cap_duyet_hien_tai'] = 2;
        } elseif ($user->coVaiTro('hr')) {
            $validated['cap_duyet_hien_tai'] = 3;
        } else {
            $validated['cap_duyet_hien_tai'] = 1;
        }

        $don = DonXinNghi::create($validated);

        // tạo thông báo
        if ($don->cap_duyet_hien_tai == 1) {
            $truongPhong = NguoiDung::where('phong_ban_id', $user->phong_ban_id)
                ->whereHas('vaiTros', function ($query) {
                    $query->where('ten', 'department');
                })
                ->get();
            foreach ($truongPhong as $tp) {
                $tp->notify(new \App\Notifications\TaoDonXinNghi($don));
            }
        } elseif ($don->cap_duyet_hien_tai == 2) {
            $hrUsers = NguoiDung::whereHas('vaiTros', function ($q) {
                $q->where('ten', 'hr');
            })->get();
            foreach ($hrUsers as $hr) {
                $hr->notify(new \App\Notifications\TaoDonXinNghi($don));
            }
        } else {
            $admin = NguoiDung::whereHas('vaiTros', function ($query) {
                $query->where('ten', 'admin');
            })
                ->get();
            foreach ($admin as $adm) {
                $adm->notify(new \App\Notifications\TaoDonXinNghi($don));
            }
        }

        // cập nhật số ngày còn lại, ...
        SoDuNghiPhepNhanVien::where('nguoi_dung_id', $user->id)
            ->where('loai_nghi_phep_id', $validated['loai_nghi_phep_id'])
            ->update([
                'so_ngay_con_lai'   => DB::raw("so_ngay_con_lai - {$validated['so_ngay_nghi']}"),
                'so_ngay_cho_duyet' => DB::raw("so_ngay_cho_duyet + {$validated['so_ngay_nghi']}"),

            ]);

        return redirect()->route('nghiphep.index')->with('success', 'Tạo đơn xin nghỉ thành công!');
    }

    public function show($id)
    {
        $donNghiPhep = DonXinNghi::with('loaiNghiPhep', 'banGiaoCho', 'lichSuDuyet')->findOrFail($id);
        $lichSuTruongPhong = $donNghiPhep->lichSuDuyet->firstWhere('cap_duyet', 1);

        return view('employe.nghiphep.show', compact('donNghiPhep', 'lichSuTruongPhong'));
    }

    public function chiTiet($id)
    {
        $user = auth()->user();
        $vaiTro = VaiTro::where('id', $user->vai_tro_id)->first();
        $donNghiPhep = DonXinNghi::with('loaiNghiPhep', 'banGiaoCho', 'lichSuDuyet')->findOrFail($id);

        return view('admin.duyetdontu.donxinnghi.show', compact('donNghiPhep', 'vaiTro'));
    }

    public function huyDonXinNghi($id)
    {
        $user = auth()->user();

        $donXinNghi = DonXinNghi::find($id);
        $nam = Carbon::today()->year;
        $lichSuDuyet = LichSuDuyetDonNghi::where('don_xin_nghi_id', $id)->get();
        if ($lichSuDuyet->isNotEmpty() || $donXinNghi->trang_thai == 'huy_bo') {
            return redirect()->route('nghiphep.index')->with('error', 'Đơn đang trong quá trình duyệt hoặc đã hủy trước đó!');
        }

        DonXinNghi::where('id', $id)->update([
            'trang_thai' => 'huy_bo'
        ]);
        $soDu = SoDuNghiPhepNhanVien::where('nguoi_dung_id', $user->id)
            ->where('loai_nghi_phep_id', $donXinNghi->loai_nghi_phep_id)
            ->where('nam', $nam)
            ->first();

        if ($soDu) {
            $soDu->update([
                'so_ngay_cho_duyet' => $soDu->so_ngay_cho_duyet - $donXinNghi->so_ngay_nghi,
                'so_ngay_con_lai' => $soDu->so_ngay_con_lai + $donXinNghi->so_ngay_nghi,
            ]);
        }

        return redirect()->route('nghiphep.index')->with('success', 'Hủy đơn xin nghỉ thành công!');
    }



    public function soDuNghiPhep()
    {
        $user = auth()->user();
        $namHienTai = Carbon::now()->year;

        $soDuNghiPhep = SoDuNghiPhepNhanVien::with('loaiNghiPhep')
            ->where('nguoi_dung_id', $user->id)
            ->where('nam', $namHienTai)
            ->whereHas('loaiNghiPhep', function ($query) {
                $query->where('trang_thai', 1);
            })
            ->get();

        $soNgayDuocCap = SoDuNghiPhepNhanVien::where('nguoi_dung_id', $user->id)
            ->where('nam', $namHienTai)
            ->whereHas('loaiNghiPhep', function ($query) {
                $query->where('trang_thai', 1);
            })
            ->sum('so_ngay_duoc_cap');

        $soNgayDaDung = SoDuNghiPhepNhanVien::where('nguoi_dung_id', $user->id)
            ->where('nam', $namHienTai)
            ->whereHas('loaiNghiPhep', function ($query) {
                $query->where('trang_thai', 1);
            })
            ->sum('so_ngay_da_dung');

        $soNgayChoDuyet = SoDuNghiPhepNhanVien::where('nguoi_dung_id', $user->id)
            ->where('nam', $namHienTai)
            ->whereHas('loaiNghiPhep', function ($query) {
                $query->where('trang_thai', 1);
            })
            ->sum('so_ngay_cho_duyet');

        $soNgayConLai = SoDuNghiPhepNhanVien::where('nguoi_dung_id', $user->id)
            ->where('nam', $namHienTai)
            ->whereHas('loaiNghiPhep', function ($query) {
                $query->where('trang_thai', 1);
            })
            ->sum('so_ngay_con_lai');

        return view('employe.nghiphep.soDuNghiPhep', compact('soDuNghiPhep', 'soNgayDuocCap', 'soNgayDaDung', 'soNgayChoDuyet', 'soNgayConLai'));
    }

    // Danh sách của người duyệt
    public function donXinNghi()
    {
        $user = auth()->user();
        $vaiTro = VaiTro::where('id', $user->vai_tro_id)->first();

        // Khai báo mặc định để tránh lỗi
        $donXinNghis = collect();
        $thongKe = [];
        $soDonChuaDuyet = 0;

        if ($vaiTro->ten == 'department') {

            $donXinNghis = DonXinNghi::with([
                'nguoiDung.phongBan',
                'nguoiDung.hoSo',
                'loaiNghiPhep',
                'banGiaoCho',
                'lichSuDuyet'
            ])
                ->whereHas('nguoiDung', function ($query) use ($user) {
                    $query->where('phong_ban_id', $user->phong_ban_id)
                        ->whereHas('vaiTro', function ($q) {
                            $q->where('ten', '!=', 'department');
                        });
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);


            $thongKe = LichSuDuyetDonNghi::select('ket_qua', DB::raw('count(*) as tong'))
                ->where('cap_duyet', 1)
                ->groupBy('ket_qua')
                ->pluck('tong', 'ket_qua');

            $soDonChuaDuyet = DonXinNghi::whereDoesntHave('lichSuDuyet', function ($query) {
                $query->where('cap_duyet', 1);
            })
                ->whereHas('nguoiDung', function ($query) {
                    $query->whereHas('vaiTro', function ($q) {
                        $q->where('ten', '!=', 'department');
                    });
                })
                ->count();
        } elseif ($vaiTro->ten == 'hr') {
            $donXinNghis = DonXinNghi::with('nguoiDung.phongBan', 'nguoiDung.hoSo', 'loaiNghiPhep', 'banGiaoCho', 'lichSuDuyet')
                ->where('cap_duyet_hien_tai', 2)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $thongKe = LichSuDuyetDonNghi::select('ket_qua', DB::raw('count(*) as tong'))
                ->where('cap_duyet', 2)
                ->groupBy('ket_qua')
                ->pluck('tong', 'ket_qua');

            $soDonChuaDuyet = DonXinNghi::whereDoesntHave('lichSuDuyet', function ($query) {
                $query->where('cap_duyet', 2);
            })->where('cap_duyet_hien_tai', 2)
                ->whereHas('nguoiDung', function ($query) {
                    $query->whereHas('vaiTro', function ($q) {
                        $q->where('ten', '!=', 'hr');
                    });
                })
                ->count();
        } elseif ($vaiTro->ten == 'admin') {
            $donXinNghis = DonXinNghi::with('nguoiDung.phongBan', 'nguoiDung.hoSo', 'loaiNghiPhep', 'banGiaoCho', 'lichSuDuyet')
                ->where('cap_duyet_hien_tai', 3)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $thongKe = LichSuDuyetDonNghi::select('ket_qua', DB::raw('count(*) as tong'))
                ->where('cap_duyet', 3)
                ->groupBy('ket_qua')
                ->pluck('tong', 'ket_qua');

            $soDonChuaDuyet = DonXinNghi::whereDoesntHave('lichSuDuyet', function ($query) {
                $query->where('cap_duyet', 3);
            })->where('cap_duyet_hien_tai', 3)
                ->count();
        }

        return view('admin.duyetdontu.donxinnghi.index', compact('vaiTro', 'thongKe', 'soDonChuaDuyet', 'donXinNghis'));
    }
}
