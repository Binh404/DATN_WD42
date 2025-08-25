<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PheDuyetYeuCauChinhCong extends Notification
{
    use Queueable;

    public $donYeuCauChinhCong;
    public $trangThai;

    /**
     * Create a new notification instance.
     */
    public function __construct($donYeuCauChinhCong, $trangThai)
    {
        $this->donYeuCauChinhCong = $donYeuCauChinhCong;
        $this->trangThai = $trangThai; // "da_duyet" hoặc "tu_choi"
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
          // Gửi qua database + realtime broadcast
        return ['database'];
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
    public function toDatabase(object $notifiable): array
    {
        $ngayGuiDon = $this->donYeuCauChinhCong->ngay->format('d/m/Y');
        $message = 'Yêu cầu chỉnh công '. $ngayGuiDon .' của bạn đã được '
                 . ($this->trangThai === 'da_duyet' ? 'phê duyệt' : 'từ chối')
                 . '.';

        return [
            'message' => $message,
            'url' => route('yeu-cau-dieu-chinh-cong.show', $this->donYeuCauChinhCong->id),
            // 'trang_thai' => $this->trangThai,
            // 'nguoi_xu_ly' => auth()->user()->name ?? 'Hệ thống',
        ];
    }
    //  public function toBroadcast(object $notifiable)
    // {
    //     return [
    //         'data' => $this->toDatabase($notifiable)
    //     ];
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->toDatabase($notifiable)['message'],
        ];
    }
}
