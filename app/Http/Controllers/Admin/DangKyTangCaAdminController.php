<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TangCaApprovalMail;
use App\Models\DangKyTangCa;
use App\Models\PhongBan;
use App\Models\thucHienTangCa;
use App\Notifications\PheDuyetYeuCauTangCa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class DangKyTangCaAdminController extends Controller
{
     public function index(Request $request) {
        // dd(request()->all());
        try {
            // Get filter parameters
            $search = $request->get('search');
            $phongBan = $request->get('phong_ban');
            $trangThaiDuyet = $request->get('trang_thai');
            $tuNgay = $request->get('tu_ngay');
            $denNgay = $request->get('den_ngay');
            $perPage = $request->get('per_page', 15);

            // Build query
            $query = DangKyTangCa::with([
                'nguoiDung.hoSo',
                'nguoiDung.phongBan'
            ]);
            // Apply search filters
            if (!empty($search)) {
                $query->whereHas('nguoiDung', function ($q) use ($search) {
                    $q->where('email', 'LIKE', "%{$search}%")
                      ->orWhereHas('hoSo', function ($q2) use ($search) {
                          $q2->where('ho', 'LIKE', "%{$search}%")
                             ->orWhere('ten', 'LIKE', "%{$search}%")
                             ->orWhere(DB::raw("CONCAT(ho, ' ', ten)"), 'LIKE', "%{$search}%");
                      });
                });
            }

            /// Tìm kiếm theo phòng ban
            if ($request->filled('phong_ban_id')) {
                $query->whereHas('nguoiDung', function ($q) use ($request) {
                    $q->where('phong_ban_id', $request->get('phong_ban_id'));
                });
            }
            // Tìm kiếm theo ngày cụ thể
            if ($request->filled('ngay_tang_ca')) {
                $query->where('ngay_tang_ca', $request->get('ngay_tang_ca'));
            }
            // Filter by date range
            if (!empty($tuNgay)) {
                $query->where('ngay_tang_ca', '>=', $tuNgay);
            }
            if (!empty($denNgay)) {
                $query->where('ngay_tang_ca', '<=', $denNgay);
            }
            //trạng thái
            if (!empty($trangThaiDuyet)) {
                $query->where('trang_thai', $trangThaiDuyet);
            }
            $soLuongDangKyTangCa = $query->count();
            // Order by latest first
            $query->orderBy('ngay_tang_ca', 'desc')
                  ->orderBy('created_at', 'desc');
            // dd($query);
            // Paginate results
            $user = auth()->user();
            if ($user->coVaiTro('Admin') || $user->coVaiTro('HR')) {
                // Admin và HR xem tất cả dữ liệu, không giới hạn
            } else if ($user->coVaiTro('department')) {
                $phongBanId = $user->phong_ban_id;
                $userId = $user->id;

                // Lọc chỉ những người cùng phòng ban và không lấy user hiện tại
                $query->whereHas('nguoiDung', function ($q) use ($phongBanId, $userId) {
                    $q->where('phong_ban_id', $phongBanId)
                    ->where('id', '<>', $userId);
                });
            } else {
                // Nếu không phải Admin, HR, department thì không có quyền xem
                abort(403, 'Bạn không có quyền truy cập.');
            }
            $donTangCa = $query->paginate($perPage);
            // dd($pheDuyet);
            // Get departments for filter dropdown
            $phongBans = PhongBan::orderBy('ten_phong_ban')->get();
            $trangThaiDuyets = DangKyTangCa::TRANG_THAI;
            // dd($trangThaiDuyets);
            return view('admin.cham-cong.phe_duyet_tang_ca.index', compact('donTangCa', 'phongBans','soLuongDangKyTangCa','trangThaiDuyets'));

        } catch (\Exception $e) {
            Log::error('Error in PheDuyetController@index: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi tải dữ liệu: ' . $e->getMessage());
        }
    }

    /**
     * Hiển thị chi tiết đăng ký tăng ca
     */
    public function show($id)
    {
        try {
            $dangKyTangCa = DangKyTangCa::with([
                'nguoiDung.hoSo',
                'nguoiDung.phongBan',
                'nguoiDuyet.hoSo'
            ])->findOrFail($id);

            $user = auth()->user();

            if ($user->coVaiTro('Admin') || $user->coVaiTro('HR')) {
                // Admin và HR xem tất cả
            } elseif ($user->coVaiTro('department')) {
                $target = $dangKyTangCa->nguoiDung;

                if (
                    $target->phong_ban_id !== $user->phong_ban_id || // khác phòng ban
                    $target->id === $user->id ||                     // chính họ
                    $target->coVaiTro('Admin') ||                    // loại bỏ Admin
                    $target->coVaiTro('HR') ||                       // loại bỏ HR
                    $target->coVaiTro('department')                  // loại bỏ trưởng phòng
                ) {
                    abort(403, 'Bạn không có quyền xem bản ghi này.');
                }
            } else {
                abort(403, 'Bạn không có quyền xem bản ghi này.');
            }

            return view('admin.cham-cong.phe_duyet_tang_ca.show', compact('dangKyTangCa'));

        } catch (\Exception $e) {
            Log::error('Error in DangKyTangCaController@show: ' . $e->getMessage());
            return back()->with('error', 'Không tìm thấy đăng ký tăng ca');
        }
    }

    public function pheDuyet(Request $request, $id){
        // dd($request->trang_thai == 'huy');
        $dangKyTangCa = DangKyTangCa::where('id', $id)->first();
        $user = auth()->user();

        if ($user->coVaiTro('Admin') || $user->coVaiTro('HR')) {
            // Admin, HR xem được hết
        } else if ($user->coVaiTro('department')) {
            $target = $dangKyTangCa->nguoiDung;

                if (
                    $target->phong_ban_id !== $user->phong_ban_id || // khác phòng ban
                    $target->id === $user->id ||                     // chính họ
                    $target->coVaiTro('Admin') ||                    // loại bỏ Admin
                    $target->coVaiTro('HR') ||                       // loại bỏ HR
                    $target->coVaiTro('department')                  // loại bỏ trưởng phòng
                ) {
                    abort(403, 'Bạn không có quyền xem bản ghi này.');
                }
        } else if($user->coVaiTro('employee') && $request->trang_thai == 'huy'){
            // $target = $dangKyTangCa->nguoiDung;

        }else{
            abort(403, 'Bạn không có quyền xem bản ghi này.');
        }
         // Nếu đơn đã bị hủy -> không cho phép Admin/HR/Trưởng phòng phê duyệt
        if ($dangKyTangCa->trang_thai === 'huy' && $request->trang_thai !== 'huy') {
            return back()->with(
                'error' , 'Đơn đã bị hủy, không thể phê duyệt!'
            );
        }

        // Nếu đơn đã được duyệt -> nhân viên không thể hủy
        if ($dangKyTangCa->trang_thai === 'da_duyet' && $request->trang_thai === 'huy') {
            return back()->with(
                'error' , 'Đơn đã được phê duyệt, bạn không thể hủy!'
            );
        }
        // $trangThai = $dangKyTangCa->trang_thai;
        $thucHienTangCa = thucHienTangCa::where('dang_ky_tang_ca_id', $id)->first();
        if(!empty($thucHienTangCa)){
            return back()->with('error', 'Đăng ký tăng ca ngày ' .$dangKyTangCa->ngay_tang_ca->format('d/m/Y').' đã thực hiện chấm công không thể thay đổi');
        }

        $validated = $request->validate([
            'trang_thai' => 'required',
            'ly_do_tu_choi' => 'nullable|string'
        ]);
        // dd($validated);

        // // Nếu không có giờ ra thì đặt mặc định là 17:30
        // if (empty($chamCong->gio_ra)) {
        //     $chamCong->gio_ra = '17:30';
        // }


        DB::beginTransaction();
        try {
            $dangKyTangCa->update([
                'trang_thai' => $validated['trang_thai'],
                'nguoi_duyet_id' => auth()->id(),
                'thoi_gian_duyet' => now(),
                'ly_do_tu_choi' => $validated['ly_do_tu_choi'] ?? $dangKyTangCa->ghi_chu,
                // 'gio_ra' => $dangKyTangCa->gio_ra // Cập nhật giờ ra (có thể là mặc định)
            ]);

            // Tính toán lại số giờ làm và số công
            // $chamCong->capNhatTrangThai($trangThai);
            // $chamCong->tinhSoCong();
            $dangKyTangCa->save();
            // Gửi mail thông báo
            // dd($dangKyTangCa->nguoiDung);
            $dangKyTangCa->nguoiDung->notify(new PheDuyetYeuCauTangCa($dangKyTangCa, $validated['trang_thai'], $dangKyTangCa->ly_do_tu_choi));

            if($dangKyTangCa->trang_thai !== 'huy'){
                $this->sendApprovalNotification($dangKyTangCa, $user);

            }
            DB::commit();
            if($dangKyTangCa->trang_thai == 'tu_choi'){
                $message = 'Từ chối chấm công!';
            }elseif($dangKyTangCa->trang_thai == 'da_duyet'){
                $message = 'Phê duyệt chấm công!' ;
            }else{
                $message = 'Hủy chấm công!';
            }
            // $message = $dangKyTangCa == 'da_duyet'
            //     ? 'Phê duyệt chấm công thành công!'
            //     : 'Từ chối chấm công thành công!';

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Lỗi phê duyệt chấm công: ' . $e->getMessage());

            return back()->withErrors([
                'error' => 'Có lỗi xảy ra khi phê duyệt. Vui lòng thử lại!'
            ])->withInput();
        }
    }

    /**
     * Bulk actions for multiple records
     */
    public function bulkAction(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'ids' => 'required|json',
                'action' => 'required|in:da_duyet,tu_choi,huy',
                'reason' => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
            }

            $ids = json_decode($request->ids, true);
            if (empty($ids) || !is_array($ids)) {
                return response()->json(['success' => false, 'message' => 'Không có bản ghi nào được chọn!'], 400);
            }

            // Check if any records have been processed
            if (ThucHienTangCa::whereIn('dang_ky_tang_ca_id', $ids)->exists()) {
                return response()->json(['success' => false, 'message' => 'Có đăng ký tăng ca đã chấm công, không thể thay đổi!'], 400);
            }

            DB::beginTransaction();

            $actionTextMap = [
                'da_duyet' => 'phê duyệt',
                'tu_choi' => 'từ chối',
                'huy' => 'hủy',
                'delete' => 'xóa'
            ];

            if ($request->action === 'delete') {
                $count = DangKyTangCa::whereIn('id', $ids)->delete();
                $message = "Đã xóa {$count} bản ghi thành công!";
            } else {
                $updateData = [
                    'trang_thai' => $request->action,
                    'thoi_gian_duyet' => now(),
                    'nguoi_duyet_id' => auth()->id()
                ];

                if (in_array($request->action, ['tu_choi', 'huy']) && $request->reason) {
                    $updateData['ly_do_tu_choi'] = $request->reason;
                }

                // Lấy danh sách đăng ký trước khi update để gửi mail
                $dangKyList = DangKyTangCa::with('nguoiDung')->whereIn('id', $ids)->get();

                $count = DangKyTangCa::whereIn('id', $ids)->update($updateData);

                // Gửi mail cho từng đăng ký sau khi update thành công
                $user = auth()->user();
                foreach ($dangKyList as $dangKy) {
                    // Reload để có dữ liệu mới nhất
                    $dangKy->refresh();
                    $this->sendApprovalNotification($dangKy, $user);
                }
                $message = "Đã {$actionTextMap[$request->action]} {$count} bản ghi thành công!";

            }

            DB::commit();

            return response()->json(['success' => true, 'message' => $message]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('PheDuyetController@bulkAction: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Lỗi hệ thống, vui lòng thử lại!'], 500);
        }
    }
    /**
 * Gửi mail thông báo phê duyệt
 */
private function sendApprovalNotification($dangKyTangCa, $approver)
{
    try {
        // Lấy thông tin người đăng ký
        $nguoiDangKy = $dangKyTangCa->nguoiDung;

        // Kiểm tra email có tồn tại không
        if (!$nguoiDangKy->email) {
            \Log::warning('Không có email để gửi thông báo cho user ID: ' . $nguoiDangKy->id);
            return;
        }

        // Chuẩn bị dữ liệu cho mail
        $mailData = [
            'ten_nhan_vien' => $nguoiDangKy->hoSo->ho . ' ' . $nguoiDangKy->hoSo->ten,
            'ngay_tang_ca' => $dangKyTangCa->ngay_tang_ca->format('d/m/Y'),
            'gio_bat_dau' => $dangKyTangCa->gio_bat_dau,
            'gio_ket_thuc' => $dangKyTangCa->gio_ket_thuc,
            'trang_thai' => $dangKyTangCa->trang_thai,
            'ly_do_tu_choi' => $dangKyTangCa->ly_do_tu_choi,
            'nguoi_duyet' => $approver->hoSo->ho . ' ' . $approver->hoSo->ten,
            'thoi_gian_duyet' => $dangKyTangCa->thoi_gian_duyet
        ];

        // Gửi mail
        Mail::to($nguoiDangKy->email)->queue(new TangCaApprovalMail($mailData));

        Log::info('Đã gửi mail thông báo phê duyệt tăng ca cho: ' . $nguoiDangKy->email);

    } catch (\Exception $e) {
        Log::error('Lỗi gửi mail thông báo phê duyệt: ' . $e->getMessage());
        // Không throw exception để không ảnh hưởng đến flow chính
    }
}

    // public function destroy($id)
    // {
    //     $dangKyTangCa = DangKyTangCa::findOrFail($id);
    //     $dangKyTangCa->delete();

    //     return redirect()->route('admin.chamcong.xemPheDuyetTangCa')
    //         ->with('success', 'Xóa bản ghi chấm công thành công!');
    // }
}
