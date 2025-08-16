# Hướng dẫn sử dụng hệ thống tính lương

## Các tính năng mới

### 1. Kiểm soát thời gian tính lương
- **Chỉ được phép tính lương cho tháng trước**: Hệ thống sẽ kiểm tra và chỉ cho phép tính lương cho tháng trước khi sang tháng mới
- **Bảo vệ dữ liệu**: Tránh việc tính lương sớm khi tháng chưa kết thúc

### 2. Ẩn nhân viên đã được tính lương
- **Tự động lọc**: Chỉ hiển thị những nhân viên chưa được tính lương trong tháng/năm được chọn
- **Tránh trùng lặp**: Ngăn chặn việc tính lương nhiều lần cho cùng một nhân viên

### 3. Quản lý trạng thái tính lương
- **Dashboard tổng quan**: Hiển thị tiến độ tính lương của tháng hiện tại
- **Thống kê chi tiết**: Số lượng nhân viên đã/chưa tính lương, tỷ lệ hoàn thành

## Cách sử dụng

### Tính lương mới
1. Vào menu **Lương > Tính lương mới**
2. Chọn tháng/năm cần tính lương (chỉ được chọn tháng trước)
3. Chọn nhân viên từ danh sách (chỉ hiển thị nhân viên chưa tính lương)
4. Điền thông tin và nhấn "Cập nhật"

### Xem danh sách đã tính lương
1. Vào menu **Lương > Danh sách đã tính lương**
2. Xem danh sách nhân viên đã được tính lương
3. Có thể xem chi tiết, tải PDF, hoặc quay lại tính lương

### Xem trạng thái tính lương
1. Vào menu **Lương > Trạng thái tính lương**
2. Xem tổng quan tiến độ tính lương
3. Theo dõi tỷ lệ hoàn thành

## Quy tắc hoạt động

### Kiểm tra thời gian
```php
// Chỉ cho phép tính lương tháng trước
if ($thang >= $thangHienTai && $nam >= $namHienTai) {
    return redirect()->back()->with('error', 'Chỉ được phép tính lương cho tháng trước');
}
```

### Lọc nhân viên chưa tính lương
```php
$nhanViensChuaTinhLuong = $nhanViens->filter(function ($nhanVien) use ($thang, $nam) {
    $daCoLuong = LuongNhanVien::where('nguoi_dung_id', $nhanVien->id)
        ->whereHas('bangLuong', function ($query) use ($thang, $nam) {
            $query->where('thang', $thang)->where('nam', $nam);
        })
        ->exists();
    
    return !$daCoLuong;
});
```

## Routes mới

- `GET /admin/luong/tinh-luong` - Trang tính lương mới
- `GET /admin/luong/danh-sach-da-tinh-luong` - Danh sách đã tính lương
- `GET /admin/luong/trang-thai-tinh-luong-hien-tai` - Trạng thái tính lương

## Lưu ý quan trọng

1. **Thời gian tính lương**: Chỉ được phép tính lương cho tháng trước
2. **Tránh trùng lặp**: Hệ thống tự động kiểm tra và ẩn nhân viên đã tính lương
3. **Bảo mật dữ liệu**: Mỗi nhân viên chỉ được tính lương một lần cho mỗi tháng
4. **Theo dõi tiến độ**: Sử dụng dashboard để theo dõi tiến độ tính lương

## Xử lý lỗi

- **Tháng hiện tại**: Hiển thị thông báo lỗi nếu cố gắng tính lương tháng hiện tại
- **Nhân viên đã tính**: Hiển thị thông báo nếu cố gắng tính lương cho nhân viên đã có lương
- **Tháng chưa kết thúc**: Ngăn chặn việc tính lương sớm

## Tương lai

- Thêm tính năng duyệt lương
- Tích hợp với hệ thống chấm công
- Tự động tính lương theo lịch trình
- Báo cáo và thống kê nâng cao
