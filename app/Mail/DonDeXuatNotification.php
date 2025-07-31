<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DonDeXuatNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $donDeXuat;
    public $trangThai;
    public $lyDoTuChoi;
    public $nguoiDuyet;
    public $isForCreator; // Thêm flag để phân biệt email cho người tạo hay người được đề xuất
    public function __construct($donDeXuat, $trangThai, $lyDoTuChoi, $nguoiDuyet,$isForCreator = true)
    {
        $this->donDeXuat = $donDeXuat;
        $this->trangThai = $trangThai;
        $this->lyDoTuChoi = $lyDoTuChoi;
        $this->nguoiDuyet = $nguoiDuyet;
        $this->isForCreator = $isForCreator;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // / Nếu là email cho người tạo đơn
        if ($this->isForCreator) {
            $subject = match ($this->trangThai) {
                'da_duyet' => 'Thông báo: Đơn đề xuất đã được phê duyệt',
                'tu_choi' => 'Thông báo: Đơn đề xuất bị từ chối',
                'huy' => 'Thông báo: Đơn đề xuất đã bị hủy',
                default => 'Thông báo: Cập nhật trạng thái đơn đề xuất'
            };
        } else {
            // Email cho người được đề xuất (chỉ khi được duyệt)
            $subject = match ($this->donDeXuat->loai_de_xuat) {
                'de_cu_truong_phong' => 'Chúc mừng: Bạn đã được thăng chức trưởng phòng',
                'mien_nhiem_truong_phong' => 'Thông báo: Miễn nhiệm vị trí trưởng phòng',
                'mien_nhiem_nhan_vien' => 'Thông báo: Miễn nhiệm vị trí nhân viên',
                default => 'Thông báo: Đơn đề xuất liên quan đến bạn đã được phê duyệt'
            };
        }

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Nếu là email cho người tạo đơn
        if ($this->isForCreator) {
            $view = 'emails.don_de_xuat_notification'; // Template thông báo cho người tạo
        } else {
            // Email cho người được đề xuất (chỉ khi được duyệt)
            $view = match ($this->donDeXuat->loai_de_xuat) {
                'de_cu_truong_phong' => 'emails.congratulation_promotion',
                'mien_nhiem_truong_phong', 'mien_nhiem_nhan_vien' => 'emails.regret_dismissal',
                default => 'emails.approval_notification_for_nominee'
            };
        }

        return new Content(
            view: $view,
            with: [
                'donDeXuat' => $this->donDeXuat,
                'trangThai' => $this->trangThai,
                'lyDoTuChoi' => $this->lyDoTuChoi,
                'nguoiDuyet' => $this->nguoiDuyet,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
