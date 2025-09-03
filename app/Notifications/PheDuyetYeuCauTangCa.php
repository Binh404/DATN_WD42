<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
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
        return ['database', 'broadcast'];
    }
    public function toDatabase($notifiable): array
    {
        return $this->formatMessage();
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->formatMessage());
    }

    public function broadcastOn()
    {
        // Gửi đến user cụ thể
        return new \Illuminate\Broadcasting\PrivateChannel('App.Models.User.' . $this->yeuCau->nguoi_dung_id);
    }

    protected function formatMessage(): array
    {
        $ngayTangCa = $this->yeuCau->ngay_tang_ca->format('d/m/Y');
        if ($this->status === 'approved') {
            $message = "Yêu cầu tăng ca của bạn vào ngày $ngayTangCa đã được phê duyệt.";
        } else { // rejected
            $lyDoText = $this->lyDo ? " Lý do: {$this->lyDo}" : '';
            $message = "Yêu cầu tăng ca của bạn vào ngày $ngayTangCa đã bị từ chối." . $lyDoText;
        }

        return [
            'message' => $message,
            'url' => route('cham-cong.tao-don-xin-tang-ca'),
        ];
    }
}
