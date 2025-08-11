<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HopDongCancelledNotification extends Notification
{
    use Queueable;

    public $hopDong;

    /**
     * Create a new notification instance.
     */
    public function __construct($hopDong)
    {
        $this->hopDong = $hopDong;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Hợp đồng đã bị hủy')
            ->line('Hợp đồng của bạn đã bị hủy bởi quản lý.')
            ->line('Số hợp đồng: ' . $this->hopDong->so_hop_dong)
            ->action('Xem chi tiết', route('hopdong.cua-toi'))
            ->line('Vui lòng liên hệ với phòng Nhân sự để biết thêm thông tin.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Hợp đồng đã bị hủy',
            'message' => 'Hợp đồng ' . $this->hopDong->so_hop_dong . ' của bạn đã bị hủy bởi quản lý. Vui lòng liên hệ với phòng Nhân sự để biết thêm thông tin.',
            'hopdong_id' => $this->hopDong->id,
            'type' => 'hopdong_cancelled',
            'so_hop_dong' => $this->hopDong->so_hop_dong,
        ];
    }
}
