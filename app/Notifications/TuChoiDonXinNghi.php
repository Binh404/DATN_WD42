<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TuChoiDonXinNghi extends Notification
{
    use Queueable;

    public $donXinNghi;

    /**
     * Create a new notification instance.
     */
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

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Quản lý cấp trên đã từ chối đơn xin nghỉ của bạn.',
            'url' => route('nghiphep.show', ['id' => $this->donXinNghi->id]),
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
            'message' => 'Quản lý cấp trên đã từ chối đơn xin nghỉ của bạn.',
            'url' => route('nghiphep.show', ['id' => $this->donXinNghi->id]),
        ];
    }
}
