<?php

namespace App\Http\Controllers;

use App\Models\GioLamViec;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\GioLamViecService;
use Carbon\Carbon;

class GioLamViecController extends Controller
{
    public function workSchedule(): JsonResponse
    {
        $service = app(GioLamViecService::class);
        $workingHours = $service->getWorkingHours();
        $calculation = $service->getCalculation();

        return response()->json([
            'start_time' => isset($workingHours['start_time'])
                ? Carbon::parse($workingHours['start_time'])->format('H:i')
                : '08:30',
            'end_time' => isset($workingHours['end_time'])
                ? Carbon::parse($workingHours['end_time'])->format('H:i')
                : '17:30',
            'late_threshold' => $calculation['late_threshold'] ?? 15,
            'early_leave_threshold' => $calculation['early_leave_threshold'] ?? 15,
            'overtime_threshold' => isset($workingHours['start_time_tang_ca'])
                ? Carbon::parse($workingHours['start_time_tang_ca'])->format('H:i')
                : '18:30',
        ]);
    }
    public function index(){
        $gioLamViec = GioLamViec::latest()->paginate(10);
        return view('admin.cham-cong.quan_ly_thoi_gian.index', compact('gioLamViec'));

    }
    // Hiển thị form chỉnh sửa
    public function edit()
    {
        $gioLamViec = GioLamViec::firstOrFail(); // Nếu chưa có sẽ lỗi
        return view('admin.cham-cong.quan_ly_thoi_gian.edit', compact('gioLamViec'));
    }

    // Cập nhật dữ liệu
    public function update(Request $request)
    {
        $validated = $request->validate([
            'gio_bat_dau' => 'required',
            'gio_ket_thuc' => 'required|after:gio_bat_dau',
            'gio_nghi_trua' => 'required|numeric|min:0|max:4',
            'so_phut_cho_phep_di_tre' => 'required|integer|min:0|max:120',
            'so_phut_cho_phep_ve_som' => 'required|integer|min:0|max:120',
            'gio_bat_dau_tang_ca' => 'required|after:gio_ket_thuc',
        ]);

        $gioLamViec = GioLamViec::firstOrFail();
        $gioLamViec->update($validated);

        return redirect()->route('admin.giolamviec.index')
                         ->with('success', 'Cập nhật lịch làm việc thành công.');
    }
}
