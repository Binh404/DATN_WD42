<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DonXinNghi;
use App\Models\LichSuDuyetDonNghi;
use App\Models\LoaiNghiPhep;
use App\Models\NguoiDung;
use App\Models\SoDuNghiPhepNhanVien;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NghiPhepController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $donXinNghis = DonXinNghi::with('loaiNghiPhep', 'banGiaoCho')->where('nguoi_dung_id', $user->id)->get();

        return view('employe.nghiphep.index', compact('donXinNghis'));
    }

    public function create()
    {
        $user = auth()->user();
        $soDus = SoDuNghiPhepNhanVien::with('loaiNghiPhep')->where('nguoi_dung_id', $user->id)->get();

        $nguoiBanGiaos = NguoiDung::where('phong_ban_id', $user->phong_ban_id)->where('id', '!=', $user->id)->get();

        return view('employe.nghiphep.create', compact('soDus', 'nguoiBanGiaos'));
    }

    public function store(Request $request)
    {

        $user = auth()->user();

        $validated = $request->validate([
            'ma_don_nghi' => 'required|string|max:255|unique:don_xin_nghi,ma_don_nghi',
            'loai_nghi_phep_id' => 'required|exists:loai_nghi_phep,id',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after_or_equal:ngay_bat_dau',
            'ly_do' => 'required|string',
            'lien_he_khan_cap' => 'nullable|string|max:255',
            'sdt_khan_cap' => 'nullable|string|max:255',
            'ban_giao_cho_id' => 'nullable|exists:nguoi_dung,id',
            'ghi_chu_ban_giao' => 'nullable|string',
        ]);


        // Xử lý upload nhiều file tài liệu hỗ trợ (nếu có)
        $taiLieuPaths = [];
        if ($request->hasFile('tai_lieu_ho_tro')) {
            foreach ($request->file('tai_lieu_ho_tro') as $file) {
                $path = $file->store('don_xin_nghi/tai_lieu', 'public');
                $taiLieuPaths[] = $path;
            }
        }

        $ngayHienTai = Carbon::today();
        $ngayBatDau = Carbon::parse($validated['ngay_bat_dau']);
        $ngayKetThuc = Carbon::parse($validated['ngay_ket_thuc']);
        $soNgayNghi = $ngayBatDau->diffInDays($ngayKetThuc, false) + 1;

        // kiểm tra số dư nghỉ phép
        $soDuNghiPhep = SoDuNghiPhepNhanVien::where('nguoi_dung_id', $user->id)
            ->where('loai_nghi_phep_id', $validated['loai_nghi_phep_id'])
            ->first();

        if (!$soDuNghiPhep || $soDuNghiPhep->so_ngay_con_lai < $soNgayNghi) {
            return redirect()->route('nghiphep.create')->with('error', 'Số dư nghỉ phép không đủ!');
        }

        // kiểm tra số ngày báo trước
        $loaiNghiPhep = LoaiNghiPhep::where('id', $validated['loai_nghi_phep_id'])->first();
        $soNgayBaoTruoc = $loaiNghiPhep->so_ngay_bao_truoc;
        $khoangCachNgayBao = $ngayHienTai->diffInDays($ngayBatDau, false);

        if ($soNgayBaoTruoc && $khoangCachNgayBao < $soNgayBaoTruoc) {
            return redirect()->route('nghiphep.create')->with('error', 'Số ngày báo trước phải là '. $soNgayBaoTruoc .' ngày!' );
        }

        // Gán dữ liệu mặc định
        $validated['nguoi_dung_id'] = $user->id;
        $validated['so_ngay_nghi'] = $soNgayNghi;
        $validated['trang_thai'] = 'cho_duyet';
        $validated['cap_duyet_hien_tai'] = 1;
        $validated['tai_lieu_ho_tro'] = $taiLieuPaths;
        // dd($validated);

        $don = DonXinNghi::create($validated);

        // cập nhật số ngày còn lại, ...
        SoDuNghiPhepNhanVien::where('nguoi_dung_id', $user->id)
            ->where('loai_nghi_phep_id', $validated['loai_nghi_phep_id'])
            ->update([
                'so_ngay_con_lai'   => DB::raw("so_ngay_con_lai - {$validated['so_ngay_nghi']}"),
                'so_ngay_cho_duyet' => DB::raw("so_ngay_cho_duyet + {$validated['so_ngay_nghi']}"),

            ]);

        return redirect()->route('nghiphep.index')->with('success', 'Tạo đơn xin nghỉ thành công!');
    }

    

    public function huyDonXinNghi($id){
        $lichSuDuyet = LichSuDuyetDonNghi::where('don_xin_nghi_id ', $id)->get();
        if($lichSuDuyet){
            
        }
    }


    public function soDuNghiPhep()
    {
        $user = auth()->user();
        $soDuNghiPhep = SoDuNghiPhepNhanVien::with('loaiNghiPhep')
            ->where('nguoi_dung_id', $user->id)
            ->whereHas('loaiNghiPhep', function ($query) {
                $query->where('trang_thai', 1);
            })
            ->get();

        $soNgayDuocCap = SoDuNghiPhepNhanVien::where('nguoi_dung_id', $user->id)
            ->whereHas('loaiNghiPhep', function ($query) {
                $query->where('trang_thai', 1);
            })
            ->sum('so_ngay_duoc_cap');

        $soNgayDaDung = SoDuNghiPhepNhanVien::where('nguoi_dung_id', $user->id)
            ->whereHas('loaiNghiPhep', function ($query) {
                $query->where('trang_thai', 1);
            })
            ->sum('so_ngay_da_dung');

        $soNgayChoDuyet = SoDuNghiPhepNhanVien::where('nguoi_dung_id', $user->id)
            ->whereHas('loaiNghiPhep', function ($query) {
                $query->where('trang_thai', 1);
            })
            ->sum('so_ngay_cho_duyet');

        $soNgayConLai = SoDuNghiPhepNhanVien::where('nguoi_dung_id', $user->id)
            ->whereHas('loaiNghiPhep', function ($query) {
                $query->where('trang_thai', 1);
            })
            ->sum('so_ngay_con_lai');

        return view('employe.nghiphep.soDuNghiPhep', compact('soDuNghiPhep', 'soNgayDuocCap', 'soNgayDaDung', 'soNgayChoDuyet', 'soNgayConLai'));
    }
}
