# Hướng dẫn test luồng hợp đồng mới

## Luồng xử lý hợp đồng đã được cập nhật:

### 1. Tạo hợp đồng mới
- Khi tạo hợp đồng mới → trạng thái tự động là "Tạo mới"
- Trạng thái ký tự động là "Chờ ký"
- Không cần chọn trạng thái hợp đồng và trạng thái ký khi tạo

### 2. Phê duyệt hợp đồng (HR/Admin)
- HR hoặc Admin xem hợp đồng ở trạng thái "Tạo mới"
- Click nút "Phê duyệt" → hợp đồng chuyển sang trạng thái "Chưa hiệu lực"
- Trạng thái ký vẫn là "Chờ ký"

### 3. Ký hợp đồng (HR/Admin)
- HR hoặc Admin xem hợp đồng ở trạng thái "Chưa hiệu lực"
- Click nút "Ký hợp đồng" → hợp đồng chuyển sang trạng thái "Hiệu lực"
- Trạng thái ký chuyển thành "Đã ký"

## Các thay đổi đã thực hiện:

### Database
- Thêm trạng thái "tao_moi" vào enum trang_thai_hop_dong
- Thay đổi default value thành "tao_moi"

### Controller
- Cập nhật method store() để tự động set trạng thái "tạo mới"
- Thêm method pheDuyetHopDong() để xử lý phê duyệt
- Cập nhật method kyHopDong() để lưu người ký

### Views
- Cập nhật create.blade.php: loại bỏ chọn trạng thái, thêm thông báo
- Cập nhật show.blade.php: thêm nút phê duyệt và ký hợp đồng
- Cập nhật index.blade.php: hiển thị trạng thái "tạo mới"

### Routes
- Thêm route POST /{id}/phe-duyet cho chức năng phê duyệt

### JavaScript
- Thêm function pheDuyetHopDong() và kyHopDong()
- Xử lý AJAX calls với thông báo thành công/lỗi

## Cách test:

1. **Tạo hợp đồng mới:**
   - Vào trang tạo hợp đồng
   - Điền thông tin và submit
   - Kiểm tra hợp đồng có trạng thái "Tạo mới"

2. **Phê duyệt hợp đồng:**
   - Vào trang chi tiết hợp đồng "Tạo mới"
   - Click nút "Phê duyệt"
   - Kiểm tra trạng thái chuyển thành "Chưa hiệu lực"

3. **Ký hợp đồng:**
   - Vào trang chi tiết hợp đồng "Chưa hiệu lực"
   - Click nút "Ký hợp đồng"
   - Kiểm tra trạng thái chuyển thành "Hiệu lực"

## Lưu ý:
- Chỉ Admin và HR mới có quyền phê duyệt và ký hợp đồng
- Hợp đồng phải theo đúng luồng: Tạo mới → Phê duyệt → Ký
- Các trạng thái khác (Hết hạn, Hủy bỏ) vẫn hoạt động như cũ 