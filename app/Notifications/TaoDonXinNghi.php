<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaoDonXinNghi extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $donXinNghi;
    public $user;

    public function __construct($donXinNghi, $user)
    {
        $this->donXinNghi = $donXinNghi;
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
    public function toDatabase($notifiable)
    {
        $tenNguoiTao = $this->donXinNghi->nguoiDung->hoSo->ten ?? 'chưa rõ';

        return [
            'message' => 'Nhân viên ' . $tenNguoiTao . ' vừa tạo đơn xin nghỉ.',
            'url' => route('department.donxinnghi.show', $this->donXinNghi->id),
        ];
    }
       public function toBroadcast(object $notifiable): BroadcastMessage
{
    $tenNguoiTao = $this->donXinNghi->nguoiDung->hoSo->ten ?? 'chưa rõ';

    return new BroadcastMessage([
        'message' => 'Nhân viên ' . $tenNguoiTao . ' vừa tạo đơn xin nghỉ.',
            'url' => route('department.donxinnghi.show', $this->donXinNghi->id),
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
    public function toArray($notifiable)
    {
        $tenNguoiTao = $this->donXinNghi->nguoiDung->hoSo->ten ?? 'chưa rõ';

        return [
            'message' => 'Nhân viên ' . $tenNguoiTao . ' vừa tạo đơn xin nghỉ.',
            'url' => route('department.donxinnghi.show', $this->donXinNghi->id),
        ];
    }
}
