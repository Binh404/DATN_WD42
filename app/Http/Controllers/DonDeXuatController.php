<?php

namespace App\Http\Controllers;

use App\Mail\DonDeXuatNotification;
use App\Models\DonDeXuat;
use App\Models\NguoiDung;
use App\Models\VaiTro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
class DonDeXuatController extends Controller
{
    // Hiển thị danh sách đề xuất
    public function index()
    {
        $user = auth()->user();
        $deXuat = DonDeXuat::with(['nguoiTao', 'nguoiDuocDeXuat.phongBan','nguoiDuocDeXuat.hoSo', 'nguoiDuyet']);
        $deXuatCuaToi = $deXuat->where('nguoi_tao_id', $user->id)->latest()->paginate(10);

        if( $user->coVaiTro('HR')) {

            $danhSachNhanVien = NguoiDung::whereHas('hoSo')
            // ->where('id', '!=', $user->id)
            ->whereDoesntHave('vaiTros', function ($query) {
                $query->whereIn('name', ['HR', 'admin']);
            })
            ->get();
            $loaiDeXuat = [
                // 'xin_nghi' => 'Xin nghi',
                'de_cu_truong_phong' => 'Đề cử trưởng phòng',
                'mien_nhiem_nhan_vien' => 'Miễn nhiễm nhân viên',
                'mien_nhiem_truong_phong' => 'Miễn nhiễm trưởng phòng',

            ];
            return view('employe.de-xuat.index', compact('deXuatCuaToi', 'danhSachNhanVien', 'loaiDeXuat'));
        }elseif($user->coVaiTro('department')) {
            $danhSachNhanVien = NguoiDung::whereHas('hoSo')
            ->where('phong_ban_id', $user->phong_ban_id)
            ->whereDoesntHave('vaiTros', function ($query) {
                $query->whereIn('name', ['HR', 'admin', 'department']);
            })
            ->get();
            $loaiDeXuat = [
                // 'xin_nghi' => 'Xin nghi',
                // 'de_cu_truong_phong' => 'Đề cử trưởng phòng',
                'mien_nhiem_nhan_vien' => 'Miễn nhiễm nhân viên',
                // 'mien_nhiem_truong_phong' => 'Miễn nhiễm trưởng phòng',
            ];
            return view('employe.de-xuat.index', compact('deXuatCuaToi', 'danhSachNhanVien', 'loaiDeXuat'));
        }else if($user->coVaiTro('admin')) {
            $deXuatAll = DonDeXuat::with(['nguoiTao', 'nguoiDuocDeXuat.phongBan','nguoiDuocDeXuat.hoSo', 'nguoiDuyet'])
            ->latest()
            ->paginate(10);
            // dd($deXuatCuaToi);
            return view('admin.de-xuat.index', compact('deXuatAll'));
        }

        // dd($deXuatCuaToi);

    }
    public function store(Request $request)
{
    // Validate request
    $validatedData = $request->validate([
        'loai_de_xuat' => 'required|in:xin_nghi,de_cu_truong_phong,mien_nhiem_nhan_vien,mien_nhiem_truong_phong',
        'nguoi_duoc_de_xuat_id' => 'required|exists:nguoi_dung,id',
        'ghi_chu' => 'required|string|min:10|max:1000',
        'ngay_nghi_tu' => 'nullable|date|after_or_equal:today',
        'ngay_nghi_den' => 'nullable|date|after_or_equal:ngay_nghi_tu',
    ], [
        'loai_de_xuat.required' => 'Vui lòng chọn loại đề xuất',
        'loai_de_xuat.in' => 'Loại đề xuất không hợp lệ',
        'nguoi_duoc_de_xuat_id.required' => 'Vui lòng chọn người được đề xuất',
        'nguoi_duoc_de_xuat_id.exists' => 'Người được đề xuất không tồn tại',
        'ghi_chu.required' => 'Vui lòng nhập ghi chú',
        'ghi_chu.min' => 'Ghi chú phải có ít nhất 10 ký tự',
        'ghi_chu.max' => 'Ghi chú không được vượt quá 1000 ký tự',
        'ngay_nghi_tu.after_or_equal' => 'Ngày nghỉ không được trong quá khứ',
        'ngay_nghi_den.after_or_equal' => 'Ngày kết thúc phải sau ngày bắt đầu',
    ]);

    // Validate ngày nghỉ nếu là đề xuất xin nghỉ
    if ($validatedData['loai_de_xuat'] === 'xin_nghi') {
        if (empty($validatedData['ngay_nghi_tu']) || empty($validatedData['ngay_nghi_den'])) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng chọn ngày nghỉ',
                'errors' => [
                    'ngay_nghi_tu' => ['Vui lòng chọn ngày nghỉ từ'],
                    'ngay_nghi_den' => ['Vui lòng chọn ngày nghỉ đến'],
                ]
            ], 422);
        }
    }

    // Kiểm tra quyền của người tạo đề xuất
    $nguoiTao = auth()->user();
    $nguoiDuocDeXuat = NguoiDung::find($validatedData['nguoi_duoc_de_xuat_id']);

    // Validate logic nghiệp vụ
    $validationResult = $this->validateBusinessLogic($nguoiTao, $nguoiDuocDeXuat, $validatedData['loai_de_xuat']);
    if (!$validationResult['success']) {
        return response()->json([
            'success' => false,
            'message' => $validationResult['message']
        ], 422);
    }

    try {
        // Tạo đơn đề xuất
        $donDeXuat = DonDeXuat::create([
            'nguoi_tao_id' => $nguoiTao->id,
            'nguoi_duoc_de_xuat_id' => $validatedData['nguoi_duoc_de_xuat_id'],
            'loai_de_xuat' => $validatedData['loai_de_xuat'],
            'vai_tro_nguoi_tao' => $nguoiTao->vaiTro->ten_hien_thi ?? 'N/A',
            'trang_thai' => 'cho_duyet',
            'ghi_chu' => $validatedData['ghi_chu'],
            'ngay_nghi_du_kien' => $validatedData['loai_de_xuat'] === 'xin_nghi'
                ? $validatedData['ngay_nghi_tu']
                : null,
        ]);

        // Gửi thông báo cho HR/Admin (tùy chọn)
        // $this->sendNotificationToApprovers($donDeXuat);

        return response()->json([
            'success' => true,
            'message' => 'Đơn đề xuất đã được gửi thành công và đang chờ phê duyệt.',
            'data' => [
                'id' => $donDeXuat->id,
                'loai_de_xuat' => $donDeXuat->loai_de_xuat,
                'trang_thai' => $donDeXuat->trang_thai,
            ]
        ]);

    } catch (\Exception $e) {

        Log::error('Lỗi khi tạo đơn đề xuất: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi tạo đơn đề xuất. Vui lòng thử lại.'
        ], 500);
    }
}
 private function validateBusinessLogic($nguoiTao, $nguoiDuocDeXuat, $loaiDeXuat)
    {
        // Lấy vai trò của người tạo và người được đề xuất
        $vaiTroNguoiTao = $nguoiTao->vaiTro->ten ?? '';
        $vaiTroNguoiDuocDeXuat = $nguoiDuocDeXuat->vaiTro->ten ?? '';

        switch ($loaiDeXuat) {
            case 'xin_nghi':
                // Chỉ cho phép đề xuất xin nghỉ cho chính mình hoặc nhân viên dưới quyền
                if ($nguoiTao->id !== $nguoiDuocDeXuat->id) {
                    // Kiểm tra quan hệ cấp trên - cấp dưới
                    if (!$this->isManager($nguoiTao, $nguoiDuocDeXuat)) {
                        return [
                            'success' => false,
                            'message' => 'Bạn chỉ có thể đề xuất xin nghỉ cho chính mình hoặc nhân viên dưới quyền.'
                        ];
                    }
                }
                break;

            case 'de_cu_truong_phong':
                // Chỉ HR hoặc quản lý cấp cao mới được đề cử lên trưởng phòng
                if (!in_array($vaiTroNguoiTao, ['hr', 'admin'])) {
                    return [
                        'success' => false,
                        'message' => 'Chỉ HR hoặc quản lý cấp cao mới có thể đề cử lên trưởng phòng.'
                    ];
                }

                // Người được đề cử không được là trưởng phòng hiện tại
                if (strpos($vaiTroNguoiDuocDeXuat, 'department') !== false) {
                    return [
                        'success' => false,
                        'message' => 'Người được chọn đã là trưởng phòng.'
                    ];
                }
                break;

            case 'mien_nhiem_nhan_vien':
                // Chỉ HR hoặc Admin mới được miễn nhiệm
                if (!in_array($vaiTroNguoiTao, ['hr', 'admin' , 'department'])) {
                    return [
                        'success' => false,
                        'message' => 'Chỉ HR hoặc quản lý cấp cao mới có thể đề xuất miễn nhiệm.'
                    ];
                }


                // Không thể tự miễn nhiệm chính mình
                if ($nguoiTao->id === $nguoiDuocDeXuat->id) {
                    return [
                        'success' => false,
                        'message' => 'Không thể tự đề xuất miễn nhiệm chính mình.'
                    ];
                }
                break;
            case 'mien_nhiem_truong_phong':
                if (strpos($vaiTroNguoiDuocDeXuat, 'department') !== true) {
                    return [
                        'success' => false,
                        'message' => 'Người đề xuất không phải là trưởng phòng'
                    ];
                }
                // Chỉ HR hoặc Admin mới được miễn nhiệm
                if (!in_array($vaiTroNguoiTao, ['hr', 'admin'])) {
                    return [
                        'success' => false,
                        'message' => 'Chỉ HR hoặc quản lý cấp cao mới có thể đề xuất miễn nhiệm.'
                    ];
                }


                // Không thể tự miễn nhiệm chính mình
                if ($nguoiTao->id === $nguoiDuocDeXuat->id) {
                    return [
                        'success' => false,
                        'message' => 'Không thể tự đề xuất miễn nhiệm chính mình.'
                    ];
                }
                break;
        }

        // Kiểm tra đã có đề xuất chưa duyệt cho người này chưa
        $existingProposal = DonDeXuat::where('nguoi_duoc_de_xuat_id', $nguoiDuocDeXuat->id)
            ->where('loai_de_xuat', $loaiDeXuat)
            ->where('trang_thai', 'cho_duyet')
            ->first();

        if ($existingProposal) {
            return [
                'success' => false,
                'message' => 'Đã có đề xuất cùng loại cho người này đang chờ phê duyệt.'
            ];
        }

        return ['success' => true];
    }

    /**
     * Kiểm tra quan hệ quản lý
     */
    private function isManager($nguoiTao, $nguoiDuocDeXuat)
    {
        // Logic kiểm tra quan hệ cấp trên - cấp dưới
        $vaiTroNguoiTao = $nguoiTao->vaiTro->ten ?? '';

        // Nếu người tạo là HR, Admin, Giám đốc thì có quyền với tất cả
        if (in_array($vaiTroNguoiTao, ['HR', 'Admin'])) {
            return true;
        }

        // Nếu là trưởng phòng, kiểm tra cùng phòng ban
        if (strpos($vaiTroNguoiTao, 'department') !== false) {
            return $nguoiTao->phong_ban_id === $nguoiDuocDeXuat->phong_ban_id;
        }

        return false;
    }
    public function pheDuyet(Request $request, $id)
{
    $DonDeXuat = DonDeXuat::where('id', $id)->firstOrFail();
    $user = auth()->user();
    $NguoiDeXuat = NguoiDung::where('id', $DonDeXuat->nguoi_duoc_de_xuat_id)->firstOrFail();

    // Xác định vai trò và trạng thái hoạt động
    $trangThaiHoatDong = $NguoiDeXuat->trang_thai ?? 1;
    $vaiTroNguoiDuocDeXuatId = $NguoiDeXuat->vai_tro_id ?? 3;

    if ($request->trang_thai === 'da_duyet' ) {
        if( $DonDeXuat->loai_de_xuat === 'de_cu_truong_phong'){
            $trangThaiHoatDong = 1;
            $vaiTroNguoiDuocDeXuatId = VaiTro::where('name', 'department')->first()->id ?? $vaiTroNguoiDuocDeXuatId;
        }elseif($DonDeXuat->loai_de_xuat === 'mien_nhiem_truong_phong'){
            $trangThaiHoatDong = 1;
            $vaiTroNguoiDuocDeXuatId = VaiTro::where('name', 'employee')->first()->id ?? $vaiTroNguoiDuocDeXuatId;
        }elseif($DonDeXuat->loai_de_xuat === 'mien_nhiem_nhan_vien'){
            $trangThaiHoatDong = 0;
        }

    }
    // dd($trangThaiHoatDong, $vaiTroNguoiDuocDeXuatId);
    // Validate dữ liệu
    $validated = $request->validate([
        'trang_thai' => 'required|in:da_duyet,tu_choi,huy',
        'ly_do_tu_choi' => 'nullable|string|max:255'
    ]);

    DB::beginTransaction();
    try {
        // Cập nhật đơn đề xuất
        $DonDeXuat->update([
            'trang_thai' => $validated['trang_thai'],
            'nguoi_duyet_id' => $user->id,
            'thoi_gian_duyet' => now(),
            'ly_do_tu_choi' => $validated['ly_do_tu_choi'] ?? $DonDeXuat->ly_do_tu_choi,
        ]);

        // Cập nhật thông tin người được đề xuất
        $NguoiDeXuat->update([
            'vai_tro_id' => $vaiTroNguoiDuocDeXuatId,
            'trang_thai' => $trangThaiHoatDong
        ]);
        // === LOGIC GỬI EMAIL  ===

        // 1. Gửi email thông báo cho NGƯỜI TẠO ĐƠN (trong mọi trường hợp: duyệt, từ chối, hủy)
        if ($DonDeXuat->nguoiTao->email && $validated['trang_thai'] !== 'huy') {
            $notificationForCreator = new DonDeXuatNotification(
                $DonDeXuat,
                $validated['trang_thai'],
                $validated['ly_do_tu_choi'] ?? null,
                $user,
                true // isForCreator = true
            );
            Mail::to($DonDeXuat->nguoiTao->email)->queue($notificationForCreator);
        }

        // 2. Gửi email cho NGƯỜI ĐƯỢC ĐỀ XUẤT (chỉ khi được DUYỆT)
        if ($validated['trang_thai'] === 'da_duyet' && $NguoiDeXuat->email) {
            $notificationForNominee = new DonDeXuatNotification(
                $DonDeXuat,
                $validated['trang_thai'],
                null, // Người được đề xuất không cần biết lý do từ chối
                $user,
                false // isForCreator = false
            );
            Mail::to($NguoiDeXuat->email)->queue($notificationForNominee);
        }

        DB::commit();

        // Xác định thông báo
        $message = match ($validated['trang_thai']) {
            'da_duyet' => 'Phê duyệt đơn đề xuất thành công!',
            'tu_choi' => 'Từ chối đơn đề xuất thành công!',
            'huy' => 'Hủy đơn đề xuất thành công!',
            default => 'Cập nhật đơn đề xuất thành công!'
        };

        return redirect()->back()->with('success', $message);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Lỗi phê duyệt đơn đề xuất: ' . $e->getMessage());

        return back()->withErrors([
            'error' => 'Có lỗi xảy ra khi phê duyệt. Vui lòng thử lại!'
        ])->withInput();
    }
}

}
