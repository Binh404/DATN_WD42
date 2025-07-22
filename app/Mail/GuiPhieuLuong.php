<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GuiPhieuLuong extends Mailable
{
    use Queueable, SerializesModels;

    public $tenNhanVien;
    public $thang;
    public $nam;
    public $pathToPdf;

    public function __construct($tenNhanVien, $thang, $nam, $pathToPdf)
    {
        $this->tenNhanVien = $tenNhanVien;
        $this->thang = $thang;
        $this->nam = $nam;
        $this->pathToPdf = $pathToPdf;
    }

    public function build()
    {
        return $this->subject("Phiếu lương tháng {$this->thang}/{$this->nam}")
                    ->markdown('emails.phieuluong')
                    ->attach($this->pathToPdf, [
                        'as' => "PhieuLuong_{$this->thang}_{$this->nam}.pdf",
                        'mime' => 'application/pdf',
                    ]);
    }
}
