<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class HopDongApprovedNotification extends Notification
{
    use Queueable;

    protected $hopDong;

    public function __construct($hopDong)
    {
        $this->hopDong = $hopDong;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        // Lấy thông tin người gửi (HR hoặc Admin)
        $nguoiGui = auth()->user();
        $tenNguoiGui = 'HR';
        
        if ($nguoiGui && $nguoiGui->hoSo) {
            $tenNguoiGui = $nguoiGui->hoSo->ho . ' ' . $nguoiGui->hoSo->ten;
        }
        
        return [
            'message' => $tenNguoiGui . ' đã gửi hợp đồng #' . $this->hopDong->so_hop_dong . ' cho bạn. Vui lòng kiểm tra và ký hợp đồng.',
            'hopdong_id' => $this->hopDong->id,
        ];
    }
}
