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
        $nguoiTuChoi = $this->hopdong->nguoiDung;
        $tenNguoiTuChoi = $nguoiTuChoi && $nguoiTuChoi->hoSo ? ($nguoiTuChoi->hoSo->ho . ' ' . $nguoiTuChoi->hoSo->ten) : 'N/A';
        
        return (new MailMessage)
            ->subject('Nhân viên từ chối ký hợp đồng')
            ->line('Nhân viên ' . $tenNguoiTuChoi . ' đã từ chối ký hợp đồng số: ' . $this->hopdong->so_hop_dong)
            ->line('Lý do từ chối: ' . (str_replace('Từ chối ký: ', '', $this->hopdong->ghi_chu ?? 'Không có lý do')))
            ->action('Xem chi tiết', url('/hopdong/' . $this->hopdong->id));
    }

    public function toDatabase($notifiable)
    {
        $nguoiTuChoi = $this->hopdong->nguoiDung;
        $tenNguoiTuChoi = $nguoiTuChoi && $nguoiTuChoi->hoSo ? ($nguoiTuChoi->hoSo->ho . ' ' . $nguoiTuChoi->hoSo->ten) : 'N/A';
        
        return [
            'title' => 'Hợp đồng bị từ chối ký',
            'message' => 'Nhân viên ' . $tenNguoiTuChoi . ' đã từ chối ký hợp đồng số: ' . $this->hopdong->so_hop_dong,
            'hopdong_id' => $this->hopdong->id,
            'type' => 'hopdong_refused',
            'so_hop_dong' => $this->hopdong->so_hop_dong,
        ];
    }

    public function toArray($notifiable)
    {
        $nguoiTuChoi = $this->hopdong->nguoiDung;
        $tenNguoiTuChoi = $nguoiTuChoi && $nguoiTuChoi->hoSo ? ($nguoiTuChoi->hoSo->ho . ' ' . $nguoiTuChoi->hoSo->ten) : 'N/A';
        
        return [
            'title' => 'Hợp đồng bị từ chối ký',
            'message' => 'Nhân viên ' . $tenNguoiTuChoi . ' đã từ chối ký hợp đồng số: ' . $this->hopdong->so_hop_dong,
            'hopdong_id' => $this->hopdong->id,
            'type' => 'hopdong_refused',
            'so_hop_dong' => $this->hopdong->so_hop_dong,
        ];
    }
}   