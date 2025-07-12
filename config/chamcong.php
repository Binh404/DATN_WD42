<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cài đặt chấm công
    |--------------------------------------------------------------------------
    */

    // Giờ làm việc chuẩn
    'working_hours' => [
        'start_time' => '08:30',      // Giờ vào chuẩn
        'end_time' => '17:30',        // Giờ ra chuẩn
        'standard_hours' => 8,        // Số giờ làm việc chuẩn
        'lunch_break' => 1,           // Giờ nghỉ trưa (giờ)
    ],

    // Cài đặt tính toán
    'calculation' => [
        'late_threshold' => 15,       // Ngưỡng tính đi muộn (phút)
        'early_leave_threshold' => 15, // Ngưỡng tính về sớm (phút)
        'hours_per_workday' => 8,     // Số giờ = 1 công
        'overtime_threshold' => 8,    // Ngưỡng tính làm thêm giờ
    ],

    // Trạng thái chấm công
    'status' => [
        'binh_thuong' => 'Bình thường',
        'di_muon' => 'Đi muộn',
        've_som' => 'Về sớm',
        'vang_mat' => 'Vắng mặt',
        'nghi_phep' => 'Nghỉ phép',
        'lam_them' => 'Làm thêm giờ',
    ],

    // Trạng thái phê duyệt
    'approval_status' => [
        0 => 'Chưa gửi lý do',
        1 => 'Đã duyệt',
        2 => 'Từ chối',
        3 => 'Chờ phê duyệt',
    ],

    // Cài đặt xuất file
    'export' => [
        'max_records_per_export' => 5000,  // Giới hạn số bản ghi xuất
        'default_format' => 'excel',       // Định dạng mặc định
        'date_format' => 'd/m/Y',          // Định dạng ngày
        'datetime_format' => 'd/m/Y H:i',  // Định dạng ngày giờ
    ],

    // Cài đặt báo cáo
    'report' => [
        'default_period' => 30,            // Kỳ báo cáo mặc định (ngày)
        'chart_colors' => [
            'binh_thuong' => '#28a745',
            'di_muon' => '#ffc107',
            've_som' => '#17a2b8',
            'vang_mat' => '#dc3545',
            'nghi_phep' => '#6c757d',
        ],
    ],

    // Cài đặt phân trang
    'pagination' => [
        'per_page' => 20,                  // Số bản ghi mỗi trang
        'per_page_options' => [10, 20, 50, 100], // Tùy chọn số bản ghi
    ],

    // Cài đặt thông báo
    'notifications' => [
        'late_notification' => true,       // Thông báo đi muộn
        'approval_notification' => true,   // Thông báo phê duyệt
        'reminder_time' => '08:30',        // Giờ nhắc nhở chấm công
    ],

    // Cài đặt bảo mật
    'security' => [
        'allow_edit_old_records' => 7,     // Cho phép sửa bản ghi cũ (ngày)
        'require_approval' => true,        // Yêu cầu phê duyệt
        'auto_approve_normal' => false,    // Tự động duyệt chấm công bình thường
    ],
];
