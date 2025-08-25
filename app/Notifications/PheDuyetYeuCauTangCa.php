<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PheDuyetYeuCauTangCa extends Notification implements ShouldQueue
{
    use Queueable;

    protected $yeuCau;
    protected $status; // 'approved' hoặc 'rejected'
    protected $lyDo;   // chỉ dùng khi từ chối

    public function __construct($yeuCau, string $status, string $lyDo = null)
    {
        $this->yeuCau = $yeuCau;
        $this->status = $status;
        $this->lyDo = $lyDo;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        if ($this->status === 'approved') {
            $message = 'Yêu cầu tăng ca của bạn vào ngày ' . $this->yeuCau->ngay_tang_ca->format('d/m/Y') . ' đã được phê duyệt.';
        } else { // rejected
            $message = 'Yêu cầu tăng ca của bạn vào ngày ' . $this->yeuCau->ngay_tang_ca->format('d/m/Y') . ' đã bị từ chối.';
        }

        return [
            'message' => $message,
            // 'user_id' => $this->yeuCau->nguoi_dung_id,
            // 'yeu_cau_id' => $this->yeuCau->id,
            // 'status' => $this->status,
            'url' => route('cham-cong.tao-don-xin-tang-ca'),
        ];
    }
}
