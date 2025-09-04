<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HopDongLaoDong;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\User;
use App\Notifications\NewMessageNotification;
class NotificationController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem thông báo!');
        }
        $notification = $user->notifications()->findOrFail($id);

        // Đánh dấu thông báo đã đọc
        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        $hopdongId = $notification->data['hopdong_id'] ?? null;
        $hopdong = $hopdongId ? HopDongLaoDong::with(['nguoiGuiHopDong.hoSo'])->find($hopdongId) : null;

        return view('notifications.show', compact('notification', 'hopdong'));
    }

    public function xacNhanKy(Request $request, $id)
    {
        $hopdong = \App\Models\HopDongLaoDong::findOrFail($id);

        // Chuẩn bị dữ liệu cập nhật
        $updateData = [
            'trang_thai_ky' => 'da_ky',
            'nguoi_ky_id' => \Illuminate\Support\Facades\Auth::id(),
            'thoi_gian_ky' => now(),
        ];

        // Tự động chuyển trạng thái hợp đồng thành "hiệu lực" khi ký
        if (in_array($hopdong->trang_thai_hop_dong, ['tao_moi', 'chua_hieu_luc'])) {
            $updateData['trang_thai_hop_dong'] = 'hieu_luc';
        }

        // Cập nhật thông tin hợp đồng
        $hopdong->update($updateData);

        // Tạo bản ghi lương cơ bản khi nhân viên ký hợp đồng thành công
        try {
            // Kiểm tra xem đã có bản ghi lương chưa
            $existingLuong = \App\Models\Luong::where('hop_dong_lao_dong_id', $hopdong->id)->first();

            if (!$existingLuong) {
                // Tạo mới bản ghi lương
                \App\Models\Luong::create([
                    'nguoi_dung_id' => $hopdong->nguoi_dung_id,
                    'hop_dong_lao_dong_id' => $hopdong->id,
                    'luong_co_ban' => $hopdong->luong_co_ban,
                    'phu_cap' => $hopdong->phu_cap ?? 0,
                ]);
            } else {
                // Cập nhật bản ghi lương nếu có thay đổi
                $existingLuong->update([
                    'luong_co_ban' => $hopdong->luong_co_ban,
                    'phu_cap' => $hopdong->phu_cap ?? 0,
                ]);
            }
        } catch (\Exception $e) {
            // Log lỗi nhưng không dừng quá trình ký hợp đồng
            \Log::error('Lỗi tạo/cập nhật bản ghi lương khi ký hợp đồng: ' . $e->getMessage());
        }

        // Gửi thông báo cho HR và Admin
        $hrUsers = NguoiDung::whereHas('vaiTros', function ($q) {
            $q->where('name', 'hr');
        })->get();

        $adminUsers = \App\Models\NguoiDung::whereHas('vaiTros', function ($q) {
            $q->where('name', 'admin');
        })->get();

        // Gửi thông báo cho HR
        foreach ($hrUsers as $hr) {
            $hr->notify(new \App\Notifications\HopDongSignedNotification($hopdong));
        }

        // Gửi thông báo cho Admin
        foreach ($adminUsers as $admin) {
            $admin->notify(new \App\Notifications\HopDongSignedNotification($hopdong));
        }
        return redirect()->route('notifications.show', $request->notification_id ?? $id)
            ->with('success', 'Bạn đã ký hợp đồng thành công!');
    }

    public function tuChoiKy(Request $request, $id)
    {
        $hopdong = \App\Models\HopDongLaoDong::find($id);
        if ($hopdong) {
            $hopdong->update([
                'trang_thai_ky' => 'tu_choi_ky',
            ]);

            // Gửi thông báo cho HR và Admin
            $hrUsers = \App\Models\NguoiDung::whereHas('vaiTros', function ($q) {
                $q->where('name', 'hr');
            })->get();

            $adminUsers = \App\Models\NguoiDung::whereHas('vaiTros', function ($q) {
                $q->where('name', 'admin');
            })->get();

            // Gửi thông báo cho HR
            foreach ($hrUsers as $hr) {
                $hr->notify(new \App\Notifications\HopDongRefusedNotification($hopdong));
            }

            // Gửi thông báo cho Admin
            foreach ($adminUsers as $admin) {
                $admin->notify(new \App\Notifications\HopDongRefusedNotification($hopdong));
            }

            return redirect()->back()->with('success', 'Bạn đã từ chối ký hợp đồng!');
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy hợp đồng!');
        }
    }


}
