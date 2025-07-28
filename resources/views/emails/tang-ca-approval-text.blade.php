THÔNG BÁO PHÊ DUYỆT ĐĂNG KÝ TĂNG CA
==========================================

Xin chào {{ $mailData['ten_nhan_vien'] }},

Đăng ký tăng ca của bạn đã được xử lý với thông tin như sau:

TRẠNG THÁI: {{
    $mailData['trang_thai'] == 'da_duyet' ? 'ĐÃ DUYỆT' :
    ($mailData['trang_thai'] == 'tu_choi' ? 'TỪ CHỐI' : 'HỦY')
}}

THÔNG TIN CHI TIẾT:
- Ngày tăng ca: {{ $mailData['ngay_tang_ca'] }}
- Thời gian: {{ $mailData['gio_bat_dau'] }} - {{ $mailData['gio_ket_thuc'] }}
- Người phê duyệt: {{ $mailData['nguoi_duyet'] }}
- Thời gian phê duyệt: {{ $mailData['thoi_gian_duyet'] }}

@if(in_array($mailData['trang_thai'], ['tu_choi', 'huy']) && !empty($mailData['ly_do_tu_choi']))
{{ $mailData['trang_thai'] == 'tu_choi' ? 'LÝ DO TỪ CHỐI:' : 'LÝ DO HỦY:' }}
{{ $mailData['ly_do_tu_choi'] }}

@endif
@if($mailData['trang_thai'] == 'da_duyet')
Chúc mừng! Đăng ký tăng ca của bạn đã được phê duyệt.
Vui lòng thực hiện tăng ca đúng thời gian đã đăng ký.

@endif
Nếu bạn có bất kỳ thắc mắc nào, vui lòng liên hệ với bộ phận Nhân sự hoặc người quản lý trực tiếp.

Trân trọng,
Bộ phận Nhân sự

--
Email này được gửi tự động từ hệ thống quản lý nhân sự.
Vui lòng không trả lời email này.
