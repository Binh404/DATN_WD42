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
        return view('homePage.detailJob', compact('tuyenDung', 'relateJob'));
    }

    public function createFromRequest($id)
    {
        $yeuCau = YeuCauTuyenDung::with('phongBan', 'chucVu')->findOrFail($id);
        $phongBans = PhongBan::all();
        $vaiTros = VaiTro::whereRaw('LOWER(ten) != ?', ['admin'])->get();
        return view("admin.tintuyendung.create", compact('yeuCau', 'phongBans', 'vaiTros'));
    }

    private function generateUniqueMa()
    {
        do {
            $code = 'TTD' . mt_rand(100000, 999999);
        } while (TinTuyenDung::where('ma', $code)->exists());

        return $code;
    }

    public function store(Request $request)
    {
        $request->merge([
            'ky_nang_yeu_cau' => array_filter(array_map('trim', explode(',', $request->input('ky_nang_yeu_cau'))))
        ]);
        $validated = $request->validate([
            'tieu_de' => 'required|string|max:255',
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
            'yeu_cau_id' => 'required|integer|exists:yeu_cau_tuyen_dung,id',
        ], [
            'tieu_de.required' => 'Vui lòng điền tiêu đề.',
            'tieu_de.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'tieu_de.string' => 'Tiêu đề phải là chuỗi ký tự.',

            'phong_ban_id.required' => 'Vui lòng chọn phòng ban.',
            'phong_ban_id.integer' => 'Phòng ban phải là một số nguyên.',
            'phong_ban_id.exists' => 'Phòng ban không tồn tại.',

            'chuc_vu_id.required' => 'Vui lòng chọn chức vụ.',
            'chuc_vu_id.integer' => 'Chức vụ phải là một số nguyên.',
            'chuc_vu_id.exists' => 'Chức vụ không tồn tại.',

            'vai_tro_id.required' => 'Vui lòng chọn vai trò.',
            'vai_tro_id.integer' => 'Vai trò phải là một số nguyên.',
            'vai_tro_id.exists' => 'Vai trò không tồn tại.',

            'chi_nhanh_id.integer' => 'Chi nhánh phải là một số nguyên.',
            'chi_nhanh_id.exists' => 'Chi nhánh không tồn tại.',

            'loai_hop_dong.required' => 'Vui lòng chọn loại hợp đồng.',
            'loai_hop_dong.in' => 'Loại hợp đồng không hợp lệ.',

            'cap_do_kinh_nghiem.required' => 'Vui lòng chọn cấp độ kinh nghiệm.',
            'cap_do_kinh_nghiem.in' => 'Cấp độ kinh nghiệm không hợp lệ.',

            'kinh_nghiem_toi_thieu.required' => 'Vui lòng nhập kinh nghiệm tối thiểu.',
            'kinh_nghiem_toi_thieu.integer' => 'Kinh nghiệm tối thiểu phải là số nguyên.',
            'kinh_nghiem_toi_thieu.min' => 'Kinh nghiệm tối thiểu không được âm.',

            'kinh_nghiem_toi_da.required' => 'Vui lòng nhập kinh nghiệm tối đa.',
            'kinh_nghiem_toi_da.integer' => 'Kinh nghiệm tối đa phải là số nguyên.',
            'kinh_nghiem_toi_da.min' => 'Kinh nghiệm tối đa không được âm.',
            'kinh_nghiem_toi_da.gte' => 'Kinh nghiệm tối đa phải lớn hơn hoặc bằng kinh nghiệm tối thiểu.',

            'luong_toi_thieu.numeric' => 'Lương tối thiểu phải là số.',
            'luong_toi_thieu.min' => 'Lương tối thiểu không được âm.',

            'luong_toi_da.numeric' => 'Lương tối đa phải là số.',
            'luong_toi_da.min' => 'Lương tối đa không được âm.',
            'luong_toi_da.gte' => 'Lương tối đa phải lớn hơn hoặc bằng lương tối thiểu.',

            'so_vi_tri.required' => 'Vui lòng nhập số lượng vị trí tuyển dụng.',
            'so_vi_tri.integer' => 'Số vị trí phải là số nguyên.',
            'so_vi_tri.min' => 'Phải tuyển ít nhất một vị trí.',

            'mo_ta_cong_viec.required' => 'Vui lòng nhập mô tả công việc.',
            'yeu_cau.required' => 'Vui lòng nhập yêu cầu công việc.',

            // 'ky_nang_yeu_cau.array' => 'Kỹ năng yêu cầu phải là một mảng.',
            'ky_nang_yeu_cau.*.string' => 'Mỗi kỹ năng phải là một chuỗi ký tự.',

            'trinh_do_hoc_van.string' => 'Trình độ học vấn phải là chuỗi ký tự.',
            'trinh_do_hoc_van.max' => 'Trình độ học vấn không được vượt quá 255 ký tự.',

            'han_nop_ho_so.required' => 'Vui lòng nhập hạn nộp hồ sơ.',
            'han_nop_ho_so.date' => 'Hạn nộp hồ sơ không đúng định dạng ngày.',
            'han_nop_ho_so.after_or_equal' => 'Hạn nộp hồ sơ phải là các ngày trong tương lai.',

            'lam_viec_tu_xa.boolean' => 'Làm việc từ xa phải là true hoặc false.',
            'tuyen_gap.boolean' => 'Tuyển gấp phải là true hoặc false.',

            'yeu_cau_id.required' => 'Vui lòng chọn yêu cầu tuyển dụng liên quan.',
            'yeu_cau_id.integer' => 'Yêu cầu tuyển dụng phải là số nguyên.',
            'yeu_cau_id.exists' => 'Yêu cầu tuyển dụng không tồn tại.',
        ]);


        $validated['ma'] = $this->generateUniqueMa();
        // Xử lý checkbox
        $validated['lam_viec_tu_xa'] = $request->has('lam_viec_tu_xa') ? 1 : 0;
        $validated['tuyen_gap'] = $request->has('tuyen_gap') ? 1 : 0;

        $validated['nguoi_dang_id'] = Auth::id();
        $validated['thoi_gian_dang'] = now();
        $validated['trang_thai'] = 'dang_tuyen';


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

    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->coVaiTro('HR')) {
            $query = TinTuyenDung::with('chucVu', 'phongBan')->orderBy("id", "desc");
            // $tinTuyenDungs = TinTuyenDung::all();
            if ($request->filled('search')) {
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
