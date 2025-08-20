<?php

namespace App\Services;

use App\Models\GioLamViec;


class GioLamViecService
{
    protected $schedule;

    public function __construct()
    {
        // Lấy bản ghi cấu hình đầu tiên từ DB
        $this->schedule = GioLamViec::first();
    }

    /**
     * Lấy giờ làm việc
     * @return array
     */
    public function getWorkingHours(): array
    {
        if ($this->schedule) {
            return [
                'start_time' => $this->schedule->gio_bat_dau ?? '08:30',
                'end_time' => $this->schedule->gio_ket_thuc ?? '17:30',
                'standard_hours' => 8,
                'lunch_break' => $this->schedule->gio_nghi_trua ?? 1,
                'start_time_tang_ca' => $this->schedule->gio_bat_dau_tang_ca ?? '18:30',
            ];
        }

        // Fallback lấy từ config
        return config('chamcong.working_hours');
    }

    /**
     * Lấy cấu hình tính toán chấm công
     * @return array
     */
    public function getCalculation(): array
    {
        if ($this->schedule) {
            return [
                'late_threshold' => $this->schedule->so_phut_cho_phep_di_tre ?? 15,
                'early_leave_threshold' => $this->schedule->so_phut_cho_phep_ve_som ?? 15,
                'hours_per_workday' => 8,
                'overtime_threshold' => 8,
            ];
        }

        return config('chamcong.calculation');
    }
}
