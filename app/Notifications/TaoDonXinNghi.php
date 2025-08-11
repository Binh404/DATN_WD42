<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaoDonXinNghi extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $donXinNghi;

    public function __construct($donXinNghi)
    {
        $this->donXinNghi = $donXinNghi;
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

        return [
            'message' => 'Nhân viên ' . $this->donXinNghi->nguoi_dung_id . 'vừa tạo đơn xin nghỉ.',
            'url' => route('department.donxinnghi.show', $this->donXinNghi->id),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Nhân viên Nguyễn Văn A vừa tạo đơn xin nghỉ.',
            'url' => route('department.donxinnghi.show', $this->donXinNghi->id),
        ];
    }
}
