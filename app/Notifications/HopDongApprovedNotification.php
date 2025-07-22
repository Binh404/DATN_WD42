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
        return [
            'message' => 'Hợp đồng #' . $this->hopDong->so_hop_dong . ' đã được HR phê duyệt. Vui lòng kiểm tra và ký hợp đồng.',
            'hopdong_id' => $this->hopDong->id,
        ];
    }
}
