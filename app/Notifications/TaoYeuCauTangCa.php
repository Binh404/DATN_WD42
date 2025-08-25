<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaoYeuCauTangCa extends Notification
{
    use Queueable;

    protected $yeuCau;
    protected $user;
    public function __construct($yeuCau, $user)
    {
        $this->yeuCau = $yeuCau;
        $this->user = $user;
    }

    public function via(object $notifiable): array
    {
        return [ 'database', 'broadcast'];
    }

    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->subject('Yêu cầu tăng ca mới')
    //         ->line('Bạn có một yêu cầu tăng ca mới cần duyệt.')
    //         ->action('Xem yêu cầu', url('/admin/yeu-cau-tang-ca/' . $this->yeuCau->id))
    //         ->line('Vui lòng xử lý sớm!');
    // }
      public function toBroadcast(object $notifiable): BroadcastMessage
{
     $tenNguoiTao = ($this->yeuCau->nguoiDung->hoSo->ho .' '.$this->yeuCau->nguoiDung->hoSo->ten) ?? 'chưa rõ';

    return new BroadcastMessage([
       'message' => 'Yêu cầu tăng ca mới từ ' . $tenNguoiTao,
        'url' => route('admin.chamcong.xemChiTietDonTangCa' , $this->yeuCau->id),
        'created_at' => now()->toDateTimeString(),
    ]);
}
public function broadcastOn()
{
    // Laravel sẽ tự truyền $notifiable khi broadcast
    return new PrivateChannel('App.Models.User.' . $this->user->id);
}


    public function toDatabase(object $notifiable): array
    {
        $tenNguoiTao = ($this->yeuCau->nguoiDung->hoSo->ho .' '.$this->yeuCau->nguoiDung->hoSo->ten) ?? 'chưa rõ';
        return [
            'message' => 'Yêu cầu tăng ca mới từ ' . $tenNguoiTao,
            'url' => route('admin.chamcong.xemChiTietDonTangCa' , $this->yeuCau->id),
        ];
    }
}
