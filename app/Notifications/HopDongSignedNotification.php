<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HopDongSignedNotification extends Notification
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
        $nguoiKy = $this->hopdong->nguoiKy;
        $tenNguoiKy = $nguoiKy && $nguoiKy->hoSo ? ($nguoiKy->hoSo->ho . ' ' . $nguoiKy->hoSo->ten) : 'N/A';
        
        return (new MailMessage)
            ->subject('Nhân viên đã ký hợp đồng')
            ->line('Nhân viên ' . $tenNguoiKy . ' đã ký hợp đồng số: ' . $this->hopdong->so_hop_dong)
            ->line('Thời gian ký: ' . $this->hopdong->thoi_gian_ky ? $this->hopdong->thoi_gian_ky->format('d/m/Y H:i') : 'N/A')
            ->action('Xem chi tiết', url('/hopdong/' . $this->hopdong->id));
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Hợp đồng đã được ký',
            'message' => 'Nhân viên đã ký hợp đồng số: ' . $this->hopdong->so_hop_dong,
            'hopdong_id' => $this->hopdong->id,
            'type' => 'hopdong_signed',
            'so_hop_dong' => $this->hopdong->so_hop_dong,
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Hợp đồng đã được ký',
            'message' => 'Nhân viên đã ký hợp đồng số: ' . $this->hopdong->so_hop_dong,
            'hopdong_id' => $this->hopdong->id,
            'type' => 'hopdong_signed',
            'so_hop_dong' => $this->hopdong->so_hop_dong,
        ];
    }
}
