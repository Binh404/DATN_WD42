# Quy tắc tính lương mới

## Tổng quan
Hệ thống đã được cập nhật để tuân thủ quy tắc nghiêm ngặt về thời gian tính lương: **Chỉ được phép tính lương tháng trước khi đã sang tháng mới**.

## Quy tắc chi tiết

### 1. Thời gian được phép tính lương
- **Tháng hiện tại**: KHÔNG được phép tính lương
- **Tháng trước**: Được phép tính lương
- **Năm trước**: Luôn được phép tính lương
- **Năm tương lai**: KHÔNG được phép tính lương

### 2. Ví dụ cụ thể
- **Ngày hiện tại**: 16/08/2025 (tháng 8/2025)
- **Được phép tính lương**: Tháng 7/2025 trở xuống
- **KHÔNG được phép**: Tháng 8/2025
- **Khi nào được tính tháng 8**: Đợi đến ngày 01/09/2025 (sang tháng 9)

### 3. Logic kiểm tra
```php
private function coDuocPhepTinhLuong($thang, $nam)
{
    $thangHienTai = now()->month;
    $namHienTai = now()->year;
    
    // Chỉ cho phép tính lương tháng trước khi đã sang tháng mới
    if ($nam < $namHienTai) {
        return true; // Năm trước luôn được phép
    }
    
    if ($nam == $namHienTai) {
        // Cùng năm, chỉ cho phép tính lương tháng trước
        return $thang < $thangHienTai;
    }
    
    return false; // Năm tương lai không được phép
}
```

## Các thay đổi đã thực hiện

### 1. Database
- Thêm cột `luong_thang` (tinyInteger) - lưu tháng lương (1-12)
- Thêm cột `luong_nam` (year) - lưu năm lương
- Migration: `2025_08_16_134022_add_luong_thang_to_luong_nhan_vien_table.php`

### 2. Controller
- Cập nhật logic kiểm tra thời gian
- Mặc định lấy tháng trước khi truy cập trang tính lương
- Thêm kiểm tra nghiêm ngặt trong method `tinhLuongVaLuu`

### 3. Views
- Hiển thị thông báo rõ ràng về quy tắc
- Vô hiệu hóa form khi không được phép tính lương
- Hiển thị nút tính lương tháng trước
- Thêm nút kiểm tra vi phạm quy tắc

## Cách sử dụng

### Tính lương mới
1. Vào menu **Lương > Tính lương mới**
2. Hệ thống tự động chọn tháng trước
3. Nếu cố gắng tính lương tháng hiện tại, sẽ hiển thị cảnh báo

### Kiểm tra vi phạm
1. Vào menu **Lương > Kiểm tra vi phạm**
2. Xem danh sách bản ghi lương vi phạm quy tắc
3. Xử lý các trường hợp vi phạm

### Xem trạng thái
1. Vào menu **Lương > Trạng thái tính lương**
2. Theo dõi tiến độ tính lương tháng trước
3. Xem tỷ lệ hoàn thành

## Xử lý dữ liệu cũ

### Seeder
- `UpdateLuongNhanVienThangNamSeeder`: Cập nhật dữ liệu cũ với thông tin tháng/năm lương
- Chạy: `php artisan db:seed --class=UpdateLuongNhanVienThangNamSeeder`

### Kiểm tra vi phạm
- Method `kiemTraViPhamQuyTac()`: Tìm các bản ghi lương vi phạm quy tắc
- Route: `/admin/luong/kiem-tra-vi-pham`

## Lưu ý quan trọng

1. **Bảo mật dữ liệu**: Không thể tính lương tháng hiện tại
2. **Tránh trùng lặp**: Mỗi nhân viên chỉ được tính lương một lần cho mỗi tháng
3. **Theo dõi vi phạm**: Sử dụng nút "Kiểm tra vi phạm" để phát hiện sai sót
4. **Quy tắc nghiêm ngặt**: Hệ thống sẽ từ chối mọi yêu cầu tính lương tháng hiện tại

## Tương lai

- Thêm tính năng duyệt lương
- Tự động tính lương theo lịch trình
- Báo cáo vi phạm quy tắc
- Thông báo khi sang tháng mới
