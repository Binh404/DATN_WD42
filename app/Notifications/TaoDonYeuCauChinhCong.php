<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaoDonYeuCauChinhCong extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $donYeuCauChinhCong;
    public $user;
    public function __construct($donYeuCauChinhCong, $user)
    {
        $this->donYeuCauChinhCong = $donYeuCauChinhCong;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }
    public function toBroadcast(object $notifiable): BroadcastMessage
{
    $tenNguoiTao = ($this->donYeuCauChinhCong->nguoiDung->hoSo->ho .' '.$this->donYeuCauChinhCong->nguoiDung->hoSo->ten) ?? 'chưa rõ';

    return new BroadcastMessage([
        'message' => 'Nhân viên ' . $tenNguoiTao . ' vừa tạo yêu cầu chỉnh công.',
        'url' => route('admin.yeu-cau-dieu-chinh-cong.show', $this->donYeuCauChinhCong->id),
        'created_at' => now()->toDateTimeString(),
    ]);
}
public function broadcastOn()
{
    // Laravel sẽ tự truyền $notifiable khi broadcast
    return new PrivateChannel('App.Models.User.' . $this->user->id);
}


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        $tenNguoiTao = ($this->donYeuCauChinhCong->nguoiDung->hoSo->ho .' '.$this->donYeuCauChinhCong->nguoiDung->hoSo->ten) ?? 'chưa rõ';

        return [
            'message' => 'Nhân viên ' . $tenNguoiTao . ' vừa tạo yêu cầu chỉnh công.',
            'url' => route('admin.yeu-cau-dieu-chinh-cong.show', $this->donYeuCauChinhCong->id),
        ];

    }
    public function toArray(object $notifiable): array
    {
        $tenNguoiTao = ($this->donYeuCauChinhCong->nguoiDung->hoSo->ho .' '.$this->donYeuCauChinhCong->nguoiDung->hoSo->ten) ?? 'chưa rõ';

        return [
            'message' => 'Nhân viên ' . $tenNguoiTao . ' vừa tạo yêu cầu chỉnh công.',
            'url' => route('admin.yeu-cau-dieu-chinh-cong.show', $this->donYeuCauChinhCong->id),
        ];
    }
}
