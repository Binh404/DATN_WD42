# Sửa Logic Tạo Dữ Liệu Lương Cơ Bản và Tính Lương

## Tóm tắt các thay đổi

### Yêu cầu 1: Sửa logic tạo dữ liệu lương cơ bản
**Vấn đề cũ:** Dữ liệu lương cơ bản được tạo ngay khi admin tạo hợp đồng, ngay cả khi hợp đồng chưa được ký.

**Giải pháp mới:** Dữ liệu lương cơ bản chỉ được tạo khi nhân viên (employee) ký hợp đồng thành công.

### Yêu cầu 2: Sửa logic tính lương
**Vấn đề cũ:** Hệ thống vẫn tính được lương khi hợp đồng hết hạn.

**Giải pháp mới:** Chỉ tính lương cho nhân viên có hợp đồng có hiệu lực (`trang_thai_hop_dong = 'hieu_luc'`).

## Các file đã sửa

### 1. `app/Http/Controllers/Admin/HopDongLaoDongController.php`

#### Thay đổi trong method `store()`:
- **Trước:** Tạo bản ghi lương ngay khi tạo hợp đồng
- **Sau:** Không tạo bản ghi lương, chỉ tạo hợp đồng

#### Thay đổi trong method `update()`:
- **Trước:** Cập nhật bản ghi lương khi cập nhật hợp đồng
- **Sau:** Không cập nhật bản ghi lương

#### Thay đổi trong method `destroy()`:
- **Trước:** Xóa bản ghi lương khi xóa hợp đồng
- **Sau:** Không xóa bản ghi lương (vì không có)

#### Thay đổi trong method `xuLyKyHopDong()`:
- **Thêm:** Logic tạo bản ghi lương cơ bản khi nhân viên ký hợp đồng thành công

### 2. `app/Http/Controllers/Admin/LuongController.php`

#### Thay đổi trong method `create()`:
- **Thêm:** Lọc nhân viên chỉ hiển thị những người có hợp đồng hiệu lực

#### Thay đổi trong method `tinhLuongVaLuu()`:
- **Thêm:** Kiểm tra hợp đồng có hiệu lực khi lấy lương cơ bản

#### Thay đổi trong method `trangThaiTinhLuongHienTai()`:
- **Thêm:** Chỉ đếm nhân viên có hợp đồng hiệu lực

### 3. `app/Http/Controllers/NotificationController.php`

#### Thay đổi trong method `xacNhanKy()`:
- **Thêm:** Logic tạo bản ghi lương cơ bản khi nhân viên ký hợp đồng

### 4. `app/Exports/LuongCoBanExport.php`

#### Thay đổi trong method `collection()`:
- **Thêm:** Chỉ export lương từ hợp đồng có hiệu lực

### 5. `database/seeders/LuongSeeder.php`

#### Thay đổi:
- **Thêm:** Comment giải thích rằng seeder chỉ tạo dữ liệu mẫu
- **Lưu ý:** Trong thực tế, lương sẽ được tạo tự động khi ký hợp đồng

## Luồng hoạt động mới

### 1. Tạo hợp đồng (Admin)
```
Admin tạo hợp đồng → Trạng thái: "tạo mới" → KHÔNG có bản ghi lương
```

### 2. Phê duyệt hợp đồng (HR/Admin)
```
HR phê duyệt → Trạng thái: "chưa hiệu lực" → Vẫn KHÔNG có bản ghi lương
```

### 3. Ký hợp đồng (Nhân viên)
```
Nhân viên ký → Trạng thái: "hiệu lực" → TỰ ĐỘNG tạo bản ghi lương cơ bản
```

### 4. Tính lương
```
Chỉ tính lương cho nhân viên có hợp đồng hiệu lực
Không tính lương cho hợp đồng hết hạn
```

## Lợi ích của thay đổi

### 1. Đúng logic nghiệp vụ
- Lương chỉ được tạo khi hợp đồng thực sự có hiệu lực
- Tránh tình trạng tạo lương cho hợp đồng chưa ký

### 2. Bảo mật dữ liệu
- Không có dữ liệu lương "ma" cho hợp đồng chưa ký
- Dữ liệu lương luôn tương ứng với hợp đồng có hiệu lực

### 3. Tính nhất quán
- Lương cơ bản luôn đồng bộ với thông tin hợp đồng
- Tránh tình trạng lương không khớp với hợp đồng

## Kiểm tra sau khi sửa

### 1. Test tạo hợp đồng
- [ ] Tạo hợp đồng mới → Kiểm tra không có bản ghi lương
- [ ] Kiểm tra trạng thái hợp đồng là "tạo mới"

### 2. Test phê duyệt hợp đồng
- [ ] Phê duyệt hợp đồng → Kiểm tra trạng thái "chưa hiệu lực"
- [ ] Vẫn không có bản ghi lương

### 3. Test ký hợp đồng
- [ ] Nhân viên ký hợp đồng → Kiểm tra trạng thái "hiệu lực"
- [ ] Kiểm tra có bản ghi lương được tạo tự động

### 4. Test tính lương
- [ ] Chỉ hiển thị nhân viên có hợp đồng hiệu lực
- [ ] Không hiển thị nhân viên có hợp đồng hết hạn
- [ ] Tính lương thành công với hợp đồng hiệu lực

### 5. Test export
- [ ] Export lương cơ bản chỉ chứa hợp đồng có hiệu lực
- [ ] Không có dữ liệu lương từ hợp đồng hết hạn

## Lưu ý quan trọng

1. **Dữ liệu cũ:** Các bản ghi lương đã tồn tại từ trước vẫn giữ nguyên
2. **Migration:** Không cần migration mới, chỉ sửa logic
3. **Backward compatibility:** Hệ thống vẫn hoạt động bình thường với dữ liệu cũ
4. **Performance:** Thay đổi không ảnh hưởng đến hiệu suất hệ thống

## Kết luận

Các thay đổi đã được thực hiện để đảm bảo:
- Dữ liệu lương cơ bản chỉ được tạo khi hợp đồng có hiệu lực
- Hệ thống tính lương chỉ hoạt động với hợp đồng có hiệu lực
- Logic nghiệp vụ chính xác và nhất quán
- Bảo mật dữ liệu tốt hơn
