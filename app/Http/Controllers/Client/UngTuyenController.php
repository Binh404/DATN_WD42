<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\UngTuyen;
use Illuminate\Http\Request;

class UngTuyenController extends Controller
{
    public function store(Request $request)
    {
        // Validate dữ liệu form
        $validated = $request->validate([
            'ten_ung_vien' => 'required|string|max:255',
            'email' => 'required|email',
            'so_dien_thoai' => 'required|string|max:20',
            'kinh_nghiem' => 'nullable|string|max:50',
            'ky_nang' => 'nullable|string|max:255',
            'thu_gioi_thieu' => 'nullable|string|max:1000',
            'tai_cv' => 'required|mimes:pdf,doc,docx|max:2048', // 2MB
        ]);

        // Lưu file CV
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('applications/cv', 'public');
            $validated['cv_path'] = $cvPath;
        }
        $application = UngTuyen::create($validated);
        // return redirect("/homepage/job")->with('success', 'Đơn ứng tuyển đã được gửi thành công!');
        echo "<script>alert('Đơn ứng tuyển đã được gửi thành công!'); window.location.href='/homepage/job';</script>";
    }
}
