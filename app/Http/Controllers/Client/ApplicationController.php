<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        // Validate dữ liệu form
        $validated = $request->validate([
            'fullName' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'experience' => 'nullable|string|max:50',
            'skills' => 'nullable|string|max:255',
            'coverLetter' => 'nullable|string|max:1000',
            'cv' => 'required|mimes:pdf,doc,docx|max:2048', // 2MB
        ]);

        // Lưu file CV
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('applications/cv', 'public');
            $validated['cv_path'] = $cvPath;
        }
        // Lưu vào DB
        $application = Application::create($validated);
            return redirect("/homepage/job")->with('success', 'Đơn ứng tuyển đã được gửi thành công!');
    }
}
