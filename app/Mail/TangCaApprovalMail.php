<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TangCaApprovalMail extends Mailable
{
    use Queueable, SerializesModels;
     public $mailData;
    /**
     * Create a new message instance.
     */
     public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = 'Thông báo phê duyệt đăng ký tăng ca';

        // Tùy chỉnh subject theo trạng thái
        switch ($this->mailData['trang_thai']) {
            case 'da_duyet':
                $subject = '✅ Đăng ký tăng ca đã được phê duyệt';
                break;
            case 'tu_choi':
                $subject = '❌ Đăng ký tăng ca bị từ chối';
                break;
            case 'huy':
                $subject = '🔄 Đăng ký tăng ca đã bị hủy';
                break;
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
         return new Content(
            html: 'emails.tang-ca-approval',
            text: 'emails.tang-ca-approval-text',
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
