<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HopDongRefusedNotification extends Notification
{
    use Queueable;
    public $hopdong;

    public function __construct($hopdong)
    {
        $this->hopdong = $hopdong;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nhân viên từ chối ký hợp đồng')
            ->line('Nhân viên đã từ chối ký hợp đồng số: ' . $this->hopdong->so_hop_dong)
            ->action('Xem chi tiết', url('/hopdong/' . $this->hopdong->id));
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Nhân viên đã từ chối ký hợp đồng số: ' . $this->hopdong->so_hop_dong,
            'hopdong_id' => $this->hopdong->id,
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Nhân viên đã từ chối ký hợp đồng số: ' . $this->hopdong->so_hop_dong,
            'hopdong_id' => $this->hopdong->id,
        ];
    }
} 