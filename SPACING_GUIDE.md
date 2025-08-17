# Hướng dẫn sử dụng Spacing Classes

## Tổng quan
File `public/css/custom-spacing.css` đã được tạo để thêm khoảng cách giữa các div row và các phần tử khác trong ứng dụng.

## Các class spacing có sẵn

### 1. Row Spacing (Khoảng cách giữa các row)
```html
<!-- Khoảng cách mặc định cho tất cả row -->
<div class="row">...</div>

<!-- Khoảng cách nhỏ -->
<div class="row row-spacing-sm">...</div>

<!-- Khoảng cách trung bình -->
<div class="row row-spacing-md">...</div>

<!-- Khoảng cách lớn -->
<div class="row row-spacing-lg">...</div>

<!-- Khoảng cách rất lớn -->
<div class="row row-spacing-xl">...</div>
```

### 2. Margin Bottom (mb-*)
```html
<div class="mb-0">Không có margin bottom</div>
<div class="mb-1">Margin bottom 0.25rem</div>
<div class="mb-2">Margin bottom 0.5rem</div>
<div class="mb-3">Margin bottom 1rem</div>
<div class="mb-4">Margin bottom 1.5rem</div>
<div class="mb-5">Margin bottom 3rem</div>
```

### 3. Margin Top (mt-*)
```html
<div class="mt-0">Không có margin top</div>
<div class="mt-1">Margin top 0.25rem</div>
<div class="mt-2">Margin top 0.5rem</div>
<div class="mt-3">Margin top 1rem</div>
<div class="mt-4">Margin top 1.5rem</div>
<div class="mt-5">Margin top 3rem</div>
```

### 4. Section Spacing
```html
<!-- Khoảng cách section mặc định -->
<div class="section-spacing">...</div>

<!-- Khoảng cách section nhỏ -->
<div class="section-spacing-sm">...</div>

<!-- Khoảng cách section lớn -->
<div class="section-spacing-lg">...</div>
```

### 5. Card Spacing
```html
<!-- Khoảng cách card mặc định -->
<div class="card card-spacing">...</div>

<!-- Khoảng cách card nhỏ -->
<div class="card card-spacing-sm">...</div>

<!-- Khoảng cách card lớn -->
<div class="card card-spacing-lg">...</div>
```

### 6. Form Spacing
```html
<!-- Khoảng cách form -->
<div class="form-spacing">...</div>

<!-- Khoảng cách form group -->
<div class="form-group-spacing">...</div>
```

### 7. Table Spacing
```html
<!-- Khoảng cách table -->
<div class="table-spacing">...</div>
```

### 8. Button Group Spacing
```html
<!-- Khoảng cách button group -->
<div class="btn-group-spacing">...</div>
```

### 9. Alert Spacing
```html
<!-- Khoảng cách alert -->
<div class="alert alert-spacing">...</div>
```

## Ví dụ sử dụng

### Ví dụ 1: Thống kê dashboard
```html
<!-- Thống kê tổng quan -->
<div class="row row-spacing-lg">
    <div class="col-lg-3">
        <div class="card card-spacing">
            <!-- Card content -->
        </div>
    </div>
    <!-- More cards... -->
</div>

<!-- Bảng thống kê -->
<div class="row row-spacing-md">
    <div class="col-12">
        <div class="card table-spacing">
            <!-- Table content -->
        </div>
    </div>
</div>
```

### Ví dụ 2: Form đăng ký
```html
<!-- Form section -->
<div class="form-spacing">
    <div class="row row-spacing-md">
        <div class="col-md-6">
            <div class="form-group-spacing">
                <label>Họ tên</label>
                <input type="text" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group-spacing">
                <label>Email</label>
                <input type="email" class="form-control">
            </div>
        </div>
    </div>
    
    <div class="row row-spacing-md">
        <div class="col-12">
            <div class="btn-group-spacing">
                <button type="submit" class="btn btn-primary">Đăng ký</button>
                <button type="reset" class="btn btn-secondary">Làm mới</button>
            </div>
        </div>
    </div>
</div>
```

### Ví dụ 3: Danh sách với alert
```html
<!-- Alert thông báo -->
<div class="alert alert-success alert-spacing">
    Thao tác thành công!
</div>

<!-- Danh sách -->
<div class="row row-spacing-lg">
    <div class="col-12">
        <div class="card table-spacing">
            <!-- Table content -->
        </div>
    </div>
</div>
```

## Responsive Design
Tất cả các class spacing đều responsive và sẽ tự động điều chỉnh trên thiết bị di động:
- Desktop: Khoảng cách đầy đủ
- Mobile (≤768px): Khoảng cách giảm 33%

## Lưu ý
1. File CSS đã được thêm vào tất cả layout master
2. Các class có thể kết hợp với nhau
3. Sử dụng `!important` để đảm bảo override các style khác
4. Row cuối cùng trong container sẽ không có margin-bottom

## Cách tùy chỉnh
Nếu muốn thay đổi khoảng cách, chỉnh sửa file `public/css/custom-spacing.css`:
```css
.row {
    margin-bottom: 2rem; /* Thay đổi từ 1.5rem thành 2rem */
}
```

