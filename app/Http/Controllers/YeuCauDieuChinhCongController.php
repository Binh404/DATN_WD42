<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\YeuCauDieuChinhCong;
use App\Models\NguoiDung;

class YeuCauDieuChinhCongController extends Controller
{
    /**
     * Hiển thị danh sách yêu cầu điều chỉnh công của nhân viên
     */
    public function index()
    {
        $nguoiDungId = Auth::id();

        $yeuCauList = YeuCauDieuChinhCong::with(['nguoiDung', 'nguoiDuyet'])
            ->where('nguoi_dung_id', $nguoiDungId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Thống kê số lượng theo trạng thái
        $thongKe = YeuCauDieuChinhCong::where('nguoi_dung_id', $nguoiDungId)
            ->selectRaw('trang_thai, COUNT(*) as so_luong')
            ->groupBy('trang_thai')
            ->pluck('so_luong', 'trang_thai')
            ->toArray();

        $thongKe = array_merge([
            'cho_duyet' => 0,
            'da_duyet' => 0,
            'tu_choi' => 0
        ], $thongKe);

        return view('employe.yeu-cau-dieu-chinh-cong.index', [
            'yeuCauList' => $yeuCauList,
            'thongKe' => $thongKe
        ]);
    }

    /**
     * Hiển thị form tạo yêu cầu mới
     */
    public function create()
    {
        return view('employe.yeu-cau-dieu-chinh-cong.create');
    }

    /**
     * Lưu yêu cầu điều chỉnh công mới
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ngay' => 'required|date',
            'gio_vao' => 'nullable|date_format:H:i',
            'gio_ra' => 'nullable|date_format:H:i|after:gio_vao',
            'ly_do' => 'required|string|min:10|max:500',
            'tep_dinh_kem' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120' // 5MB
        ], [
            'ngay.required' => 'Vui lòng chọn ngày cần điều chỉnh',
            // 'ngay.after_or_equal' => 'Ngày điều chỉnh phải từ hôm nay trở đi',
            'gio_vao.date_format' => 'Định dạng giờ vào không hợp lệ (HH:MM)',
            'gio_ra.date_format' => 'Định dạng giờ ra không hợp lệ (HH:MM)',
            'gio_ra.after' => 'Giờ ra phải sau giờ vào',
            'ly_do.required' => 'Vui lòng nhập lý do điều chỉnh',
            'ly_do.min' => 'Lý do phải có ít nhất 10 ký tự',
            'ly_do.max' => 'Lý do không được vượt quá 500 ký tự',
            'tep_dinh_kem.mimes' => 'Chỉ chấp nhận file PDF, JPG, PNG, DOC, DOCX',
            'tep_dinh_kem.max' => 'Kích thước file không được vượt quá 5MB'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Kiểm tra xem đã có yêu cầu nào cho ngày này chưa
        $existingRequest = YeuCauDieuChinhCong::where('nguoi_dung_id', Auth::id())
            ->where('ngay', $request->ngay)
            ->whereIn('trang_thai', ['cho_duyet', 'da_duyet'])
            ->exists();

        if ($existingRequest) {
            return redirect()->back()
                ->withErrors(['ngay' => 'Bạn đã có yêu cầu điều chỉnh cho ngày này'])
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $tepDinhKem = null;

            // Xử lý upload file
            if ($request->hasFile('tep_dinh_kem')) {
                $file = $request->file('tep_dinh_kem');
                $fileName = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
                $tepDinhKem = $file->storeAs('yeu-cau-dieu-chinh-cong', $fileName, 'public');
            }

            YeuCauDieuChinhCong::create([
                'nguoi_dung_id' => Auth::id(),
                'ngay' => $request->ngay,
                'gio_vao' => $request->gio_vao,
                'gio_ra' => $request->gio_ra,
                'ly_do' => $request->ly_do,
                'tep_dinh_kem' => $tepDinhKem,
                'trang_thai' => 'cho_duyet'
            ]);

            DB::commit();

            return redirect()->route('yeu-cau-dieu-chinh-cong.index')
                ->with('success', 'Tạo yêu cầu điều chỉnh công thành công!');

        } catch (\Exception $e) {
            DB::rollback();

            // Xóa file đã upload nếu có lỗi
            if ($tepDinhKem) {
                Storage::disk('public')->delete($tepDinhKem);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Có lỗi xảy ra, vui lòng thử lại'])
                ->withInput();
        }
    }

    /**
     * Hiển thị chi tiết yêu cầu
     */
    public function show($id)
    {
        $yeuCau = YeuCauDieuChinhCong::with(['nguoiDung', 'nguoiDuyet.hoSo','nguoiDung.phongBan','nguoiDung.hoSo','nguoiDuyet'])
            ->where('nguoi_dung_id', Auth::id())
            ->findOrFail($id);

        return view('employe.yeu-cau-dieu-chinh-cong.show', [
            'yeuCau' => $yeuCau
        ]);
    }

    /**
     * Hiển thị form sửa yêu cầu
     */
    public function edit($id)
    {
        $yeuCau = YeuCauDieuChinhCong::where('nguoi_dung_id', Auth::id())
            ->where('trang_thai', 'cho_duyet')
            ->findOrFail($id);

        return view('employe.yeu-cau-dieu-chinh-cong.edit', [
            'yeuCau' => $yeuCau
        ]);
    }

    /**
     * Cập nhật yêu cầu điều chỉnh công
     */
    public function update(Request $request, $id)
    {
        $yeuCau = YeuCauDieuChinhCong::where('nguoi_dung_id', Auth::id())
            ->where('trang_thai', 'cho_duyet')
            ->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'ngay' => 'required|date',
            'gio_vao' => 'nullable|date_format:H:i',
            'gio_ra' => 'nullable|date_format:H:i|after:gio_vao',
            'ly_do' => 'required|string|min:10|max:500',
            'tep_dinh_kem' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120'
        ], [
            'ngay.required' => 'Vui lòng chọn ngày cần điều chỉnh',
            // 'ngay.after_or_equal' => 'Ngày điều chỉnh phải từ hôm nay trở đi',
            'gio_vao.date_format' => 'Định dạng giờ vào không hợp lệ (HH:MM)',
            'gio_ra.date_format' => 'Định dạng giờ ra không hợp lệ (HH:MM)',
            'gio_ra.after' => 'Giờ ra phải sau giờ vào',
            'ly_do.required' => 'Vui lòng nhập lý do điều chỉnh',
            'ly_do.min' => 'Lý do phải có ít nhất 10 ký tự',
            'ly_do.max' => 'Lý do không được vượt quá 500 ký tự',
            'tep_dinh_kem.mimes' => 'Chỉ chấp nhận file PDF, JPG, PNG, DOC, DOCX',
            'tep_dinh_kem.max' => 'Kích thước file không được vượt quá 5MB'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Kiểm tra trùng ngày (trừ bản ghi hiện tại)
        $existingRequest = YeuCauDieuChinhCong::where('nguoi_dung_id', Auth::id())
            ->where('ngay', $request->ngay)
            ->where('id', '!=', $id)
            ->whereIn('trang_thai', ['cho_duyet', 'da_duyet'])
            ->exists();

        if ($existingRequest) {
            return redirect()->back()
                ->withErrors(['ngay' => 'Bạn đã có yêu cầu điều chỉnh cho ngày này'])
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $tepDinhKemCu = $yeuCau->tep_dinh_kem;
            $tepDinhKemMoi = $tepDinhKemCu;

            // Xử lý upload file mới
            if ($request->hasFile('tep_dinh_kem')) {
                $file = $request->file('tep_dinh_kem');
                $fileName = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
                $tepDinhKemMoi = $file->storeAs('yeu-cau-dieu-chinh-cong', $fileName, 'public');

                // Xóa file cũ
                if ($tepDinhKemCu) {
                    Storage::disk('public')->delete($tepDinhKemCu);
                }
            }

            $yeuCau->update([
                'ngay' => $request->ngay,
                'gio_vao' => $request->gio_vao,
                'gio_ra' => $request->gio_ra,
                'ly_do' => $request->ly_do,
                'tep_dinh_kem' => $tepDinhKemMoi,
            ]);

            DB::commit();

            return redirect()->route('yeu-cau-dieu-chinh-cong.index')
                ->with('success', 'Cập nhật yêu cầu thành công!');

        } catch (\Exception $e) {
            DB::rollback();

            // Xóa file mới nếu có lỗi
            if (isset($tepDinhKemMoi) && $tepDinhKemMoi !== $tepDinhKemCu) {
                Storage::disk('public')->delete($tepDinhKemMoi);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Có lỗi xảy ra, vui lòng thử lại'])
                ->withInput();
        }
    }

    /**
     * Xóa yêu cầu điều chỉnh công
     */
    public function destroy($id)
    {
        $yeuCau = YeuCauDieuChinhCong::where('nguoi_dung_id', Auth::id())
            ->where('trang_thai', 'cho_duyet')
            ->findOrFail($id);

        DB::beginTransaction();

        try {
            // Xóa file đính kèm nếu có
            if ($yeuCau->tep_dinh_kem) {
                Storage::disk('public')->delete($yeuCau->tep_dinh_kem);
            }

            $yeuCau->delete();

            DB::commit();

            return redirect()->route('yeu-cau-dieu-chinh-cong.index')
                ->with('success', 'Xóa yêu cầu thành công!');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withErrors(['error' => 'Có lỗi xảy ra, vui lòng thử lại']);
        }
    }

    /**
     * Download file đính kèm
     */
    public function downloadFile($id)
    {
        $yeuCau = YeuCauDieuChinhCong::where('nguoi_dung_id', Auth::id())
            ->findOrFail($id);

        if (!$yeuCau->tep_dinh_kem || !Storage::disk('public')->exists($yeuCau->tep_dinh_kem)) {
            abort(404, 'File không tồn tại');
        }

        $filePath = Storage::disk('public')->path($yeuCau->tep_dinh_kem);
        $fileName = basename($yeuCau->tep_dinh_kem);

        return response()->download($filePath, $fileName);
    }

    /**
     * Lấy dữ liệu JSON cho Ajax
     */
    public function getAjaxData()
    {
        $nguoiDungId = Auth::id();

        $yeuCauList = YeuCauDieuChinhCong::with(['nguoiDung', 'nguoiDuyet'])
            ->where('nguoi_dung_id', $nguoiDungId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($yeuCau) {
                return [
                    'id' => $yeuCau->id,
                    'ngay' => $yeuCau->ngay,
                    'gio_vao' => $yeuCau->gio_vao,
                    'gio_ra' => $yeuCau->gio_ra,
                    'ly_do' => $yeuCau->ly_do,
                    'tep_dinh_kem' => $yeuCau->tep_dinh_kem ? basename($yeuCau->tep_dinh_kem) : null,
                    'trang_thai' => $yeuCau->trang_thai,
                    'duyet_boi' => $yeuCau->nguoiDuyet->ho_ten ?? null,
                    'duyet_vao' => $yeuCau->duyet_vao,
                    'created_at' => $yeuCau->created_at->format('Y-m-d H:i:s'),
                    'can_edit' => $yeuCau->trang_thai === 'cho_duyet'
                ];
            });

        $thongKe = YeuCauDieuChinhCong::where('nguoi_dung_id', $nguoiDungId)
            ->selectRaw('trang_thai, COUNT(*) as so_luong')
            ->groupBy('trang_thai')
            ->pluck('so_luong', 'trang_thai')
            ->toArray();

        return response()->json([
            'yeuCauList' => $yeuCauList,
            'thongKe' => array_merge([
                'cho_duyet' => 0,
                'da_duyet' => 0,
                'tu_choi' => 0
            ], $thongKe)
        ]);
    }
}
