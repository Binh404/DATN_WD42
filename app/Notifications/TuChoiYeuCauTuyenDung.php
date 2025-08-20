<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TuChoiYeuCauTuyenDung extends Notification
{
    use Queueable;

    public $yeuCauTuyenDung;

    /**
     * Create a new notification instance.
     */
    public function __construct($yeuCauTuyenDung)
    {
        $this->yeuCauTuyenDung = $yeuCauTuyenDung;
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

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Giám đốc đã từ chối yêu cầu tuyển dụng của bạn.',
            'url' => route('department.yeucautuyendung.show', ['id' => $this->yeuCauTuyenDung->id]),
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
            'message' => 'Giám đốc đã từ chối yêu cầu tuyển dụng của bạn.',
            'url' => route('department.yeucautuyendung.show', ['id' => $this->yeuCauTuyenDung->id]),
        ];
    }
}
