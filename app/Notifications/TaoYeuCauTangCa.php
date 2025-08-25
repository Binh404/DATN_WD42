<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaoYeuCauTangCa extends Notification
{
    use Queueable;

    protected $yeuCau;

    public function __construct($yeuCau)
    {
        $this->yeuCau = $yeuCau;
    }

    public function via(object $notifiable): array
    {
        return [ 'database'];
    }

    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->subject('Yêu cầu tăng ca mới')
    //         ->line('Bạn có một yêu cầu tăng ca mới cần duyệt.')
    //         ->action('Xem yêu cầu', url('/admin/yeu-cau-tang-ca/' . $this->yeuCau->id))
    //         ->line('Vui lòng xử lý sớm!');
    // }

    public function toDatabase(object $notifiable): array
    {
        $tenNguoiTao = ($this->yeuCau->nguoiDung->hoSo->ho .' '.$this->yeuCau->nguoiDung->hoSo->ten) ?? 'chưa rõ';
        return [
            'message' => 'Yêu cầu tăng ca mới từ ' . $tenNguoiTao,
            'url' => route('admin.chamcong.xemChiTietDonTangCa' , $this->yeuCau->id),
        ];
    }
}
