<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DangKyTangCa;
use App\Models\PhongBan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

            // Kiểm tra quyền xem
            // if (!Auth::user()->is_admin && $dangKyTangCa->nguoi_dung_id !== Auth::id()) {
            //     return back()->with('error', 'Bạn không có quyền xem đăng ký này');
            // }

            return view('admin.cham-cong.phe_duyet_tang_ca.show', compact('dangKyTangCa'));

        } catch (\Exception $e) {
            Log::error('Error in DangKyTangCaController@show: ' . $e->getMessage());
            return back()->with('error', 'Không tìm thấy đăng ký tăng ca');
        }
    }
    public function pheDuyet(Request $request, $id){
        // dd($request->all());
        $dangKyTangCa = DangKyTangCa::where('id', $id)->first();
        // $trangThai = $dangKyTangCa->trang_thai;
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
    // public function destroy($id)
    // {
    //     $dangKyTangCa = DangKyTangCa::findOrFail($id);
    //     $dangKyTangCa->delete();

    //     return redirect()->route('admin.chamcong.xemPheDuyetTangCa')
    //         ->with('success', 'Xóa bản ghi chấm công thành công!');
    // }
    /**
     * Bulk actions for multiple records
     */
    public function bulkAction(Request $request)
    {
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'ids' => 'required|json',
                'action' => 'required|in:da_duyet,tu_choi,delete',
                'reason' => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ!'
                ], 400);
            }

            $ids = json_decode($request->ids, true);
            $action = $request->action;
            $reason = $request->reason;

            if (empty($ids) || !is_array($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có bản ghi nào được chọn!'
                ], 400);
            }

            DB::beginTransaction();

            // if ($action === 'delete') {
            //     // Bulk delete
            //     $deletedCount = DangKyTangCa::whereIn('id', $ids)->delete();
            //     $message = "Đã xóa {$deletedCount} bản ghi thành công!";
            // } else {
                // Bulk approve/reject
                $updateData = [
                    'trang_thai' =>  $action,
                    'thoi_gian_duyet' => now(),
                    'nguoi_duyet_id' => auth()->id()
                ];

                if (($action == 'tu_choi' && $reason) || ($action == 'hủy' && $reason)) {
                    $updateData['ly_do_tu_choi'] = $reason;
                }

                $updatedCount = DangKyTangCa::whereIn('id', $ids)->update($updateData);

                // $actionText = $action == 1 ? 'phê duyệt' : 'từ chối';
                if($action == 'tu_choi'){
                    $actionText = 'từ chối';
                }elseif($action == 'da_duyet'){
                    $actionText = 'phê duyệt';
                }else{
                    $actionText = 'hủy';
                }
                $message = "Đã {$actionText} {$updatedCount} bản ghi thành công!";
            // }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in PheDuyetController@bulkAction: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
