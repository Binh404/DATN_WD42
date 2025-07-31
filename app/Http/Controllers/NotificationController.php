<?php

namespace App\Http\Controllers;

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
        $hopdong = $hopdongId ? HopDongLaoDong::find($hopdongId) : null;

        return view('notifications.show', compact('notification', 'hopdong'));
    }

    public function xacNhanKy(Request $request, $id)
    {
        $hopdong = \App\Models\HopDongLaoDong::findOrFail($id);
        // Cập nhật trạng thái ký
        $hopdong->update([
            'trang_thai_ky' => 'da_ky',
            'trang_thai_hop_dong' => 'hieu_luc',
            'nguoi_ky_id' => \Illuminate\Support\Facades\Auth::id(),
            'thoi_gian_ky' => now(),
        ]);
        // Gửi thông báo cho HR
        $hrUsers = \App\Models\NguoiDung::whereHas('vaiTros', function ($q) {
            $q->where('ten', 'hr');
        })->get();
        foreach ($hrUsers as $hr) {
            $hr->notify(new \App\Notifications\HopDongSignedNotification($hopdong));
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

            // Gửi thông báo cho HR
            $hrUsers = \App\Models\NguoiDung::whereHas('vaiTros', function ($q) {
                $q->where('ten', 'hr');
            })->get();

            foreach ($hrUsers as $hr) {
                $hr->notify(new \App\Notifications\HopDongRefusedNotification($hopdong));
            }

            return redirect()->back()->with('success', 'Bạn đã từ chối ký hợp đồng!');
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy hợp đồng!');
        }
    }


} 
