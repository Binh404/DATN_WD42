@extends('layoutsEmploye.master')

@section('content-employee')
<section class="content-section" id="overtime">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Đơn đăng ký tăng ca</h2>
        <button class="btn btn-primary" onclick="showOvertimeModal()">
            <i class="fas fa-plus"></i>
            Tạo đơn tăng ca
        </button>
    </div>

    <!-- Hiển thị thống kê -->
    <div class="stats-container" style="margin-bottom: 20px;">
        <div class="stat-box">
            <strong>Tổng đơn: </strong>{{ $stats['total'] }}
        </div>
        <div class="stat-box">
            <strong>Chờ duyệt: </strong>{{ $stats['pending'] }}
        </div>
        <div class="stat-box">
            <strong>Đã duyệt: </strong>{{ $stats['approved'] }}
        </div>
        <div class="stat-box">
            <strong>Từ chối: </strong>{{ $stats['rejected'] }}
        </div>
    </div>

    <!-- Form lọc -->
    <div class="filter-container" style="margin-bottom: 20px;">
        <form method="GET" action="{{ route('cham-cong.tao-don-xin-tang-ca') }}">
            <div style="display: flex; gap: 10px;">
                <select name="trang_thai" class="form-control">
                    <option value="">Tất cả trạng thái</option>
                    <option value="cho_duyet" {{ request('trang_thai') == 'cho_duyet' ? 'selected' : '' }}>Chờ duyệt</option>
                    <option value="da_duyet" {{ request('trang_thai') == 'da_duyet' ? 'selected' : '' }}>Đã duyệt</option>
                    <option value="tu_choi" {{ request('trang_thai') == 'tu_choi' ? 'selected' : '' }}>Từ chối</option>
                </select>
                <select name="thang" class="form-control">
                    <option value="">Chọn tháng</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('thang') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                <select name="nam" class="form-control">
                    <option value="">Chọn năm</option>
                    @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}" {{ request('nam') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                <button type="submit" class="btn btn-primary">Lọc</button>
            </div>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Ngày tăng ca</th>
                    <th>Giờ bắt đầu</th>
                    <th>Giờ kết thúc</th>
                    <th>Số giờ</th>
                    <th>Loại tăng ca</th>
                    <th>Lý do</th>
                    <th>Trạng thái</th>
                    <th>Phản hồi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dangKyTangCa as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->ngay_tang_ca)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->gio_bat_dau)->format('H:i') ?? '-'}}</td>
                        <td>{{ \Carbon\Carbon::parse($item->gio_ket_thuc)->format('H:i') ?? '-' }}</td>
                        <td>{{ $item->so_gio_tang_ca ?? '-' }}</td>
                        <td>{{ $item->loai_tang_ca_text ?? '-' }}</td>
                        <td>{{ $item->ly_do_tang_ca ?? '-' }}</td>
                        <td>
                            @if ($item->trang_thai == 'cho_duyet')
                                <span class="status-badge status-pending">Chờ duyệt</span>
                            @elseif ($item->trang_thai == 'da_duyet')
                                <span class="status-badge status-approved">Đã duyệt</span>
                            @elseif ($item->trang_thai == 'tu_choi')
                                <span class="status-badge status-rejected">Từ chối</span>
                            @elseif ($item->trang_thai == 'huy')
                                <span class="status-badge status-denied">Hủy bỏ</span>
                            @else
                                <span class="status-badge">-</span>
                            @endif
                        </td>
                        <td>{{ $item->ly_do_tu_choi ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Không có dữ liệu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <div class="pagination-container" style="margin-top: 20px;">
        {{ $dangKyTangCa->links() }}
    </div>
     <div id="overtimeModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tạo đơn tăng ca</h3>
                <button class="close" onclick="closeModal('overtimeModal')">×</button>
            </div>
            <form onsubmit="submitOvertime(event)">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Loại tăng ca</label>
                        <select name="loai_tang_ca" id="loai_tang_ca" class="form-control" onchange="handleOvertimeTypeChange()" required>
                            <option value="">Chọn loại tăng ca</option>
                            <option value="ngay_thuong">Ngày thường</option>
                            <option value="ngay_nghi">Ngày nghỉ</option>
                            <option value="le_tet">Lễ tết</option>
                        </select>
                        <div id="timeRestrictionNote" class="time-restriction-note" style="display: none;">
                            * Ngày thường chỉ được tăng ca từ 18:45 trở đi
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ngày tăng ca</label>
                        <input type="date" name="ngay_tang_ca" id="ngay_tang_ca" class="form-control" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Giờ bắt đầu</label>
                        <input type="time" name="gio_bat_dau" id="gio_bat_dau" class="form-control" onchange="calculateHours()" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Giờ kết thúc</label>
                        <input type="time" name="gio_ket_thuc" id="gio_ket_thuc" class="form-control" onchange="calculateHours()" required>
                    </div>
                </div>

                <div id="calculatedHours" class="calculated-hours" style="display: none;">
                    <strong>Số giờ tăng ca: <span id="hoursDisplay">0</span> giờ</strong>
                </div>

                <div class="form-group">
                    <label class="form-label">Lý do tăng ca</label>
                    <textarea name="ly_do_tang_ca" class="form-control" rows="4" placeholder="Mô tả lý do tăng ca" ></textarea>
                </div>
                <div style="text-align: right;">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('overtimeModal')">Hủy</button>
                    <button type="submit" class="btn btn-primary">Gửi đơn</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('javascript')
<script>
 function showOvertimeModal() {
    const modal = document.getElementById('overtimeModal');
    if (modal) {
        modal.style.display = 'block';
        // Set ngày mặc định là hôm nay
        const today = new Date().toISOString().split('T')[0];
        const dateInput = document.getElementById('ngay_tang_ca');
        if (dateInput && !dateInput.value) {
            dateInput.value = today;
        }
    }
}

// Xử lý thay đổi loại tăng ca
function handleOvertimeTypeChange() {
    const loaiTangCa = document.getElementById('loai_tang_ca');
    const gioBatDau = document.getElementById('gio_bat_dau');
    const timeRestrictionNote = document.getElementById('timeRestrictionNote');

    if (!loaiTangCa || !gioBatDau || !timeRestrictionNote) return;

    if (loaiTangCa.value === 'ngay_thuong') {
        // Hiển thị ghi chú hạn chế thời gian
        timeRestrictionNote.style.display = 'block';
        // Đặt giá trị mặc định là 18:45 cho ngày thường
        if (!gioBatDau.value || gioBatDau.value < '18:45') {
            gioBatDau.value = '18:45';
        }
        gioBatDau.min = '18:45';
    } else {
        // Ẩn ghi chú và bỏ hạn chế thời gian
        timeRestrictionNote.style.display = 'none';
        gioBatDau.removeAttribute('min');
    }

    // Tính lại số giờ khi thay đổi loại tăng ca
    calculateHours();
}

// Tính toán số giờ tăng ca
function calculateHours() {
    const gioBatDauEl = document.getElementById('gio_bat_dau');
    const gioKetThucEl = document.getElementById('gio_ket_thuc');
    const calculatedHoursDiv = document.getElementById('calculatedHours');
    const hoursDisplay = document.getElementById('hoursDisplay');

    if (!gioBatDauEl || !gioKetThucEl || !calculatedHoursDiv || !hoursDisplay) return;

    const gioBatDau = gioBatDauEl.value;
    const gioKetThuc = gioKetThucEl.value;

    if (gioBatDau && gioKetThuc) {
        const startTime = new Date(`2000-01-01T${gioBatDau}:00`);
        let endTime = new Date(`2000-01-01T${gioKetThuc}:00`);

        // Nếu giờ kết thúc nhỏ hơn giờ bắt đầu, coi như sang ngày hôm sau
        if (endTime <= startTime) {
            endTime.setDate(endTime.getDate() + 1);
        }

        const diffInMs = endTime - startTime;
        const diffInHours = diffInMs / (1000 * 60 * 60);

        if (diffInHours > 0 && diffInHours <= 12) {
            hoursDisplay.textContent = diffInHours.toFixed(1);
            calculatedHoursDiv.style.display = 'block';
        } else if (diffInHours > 12) {
            hoursDisplay.textContent = diffInHours.toFixed(1) + ' (Vượt quá 12 giờ!)';
            calculatedHoursDiv.style.display = 'block';
            calculatedHoursDiv.style.color = 'red';
        } else {
            calculatedHoursDiv.style.display = 'none';
        }
    } else {
        calculatedHoursDiv.style.display = 'none';
    }
}

// Validate thời gian tăng ca
function validateOvertimeTime() {
    const loaiTangCa = document.getElementById('loai_tang_ca');
    const gioBatDau = document.getElementById('gio_bat_dau');

    if (!loaiTangCa || !gioBatDau) return true;

    if (loaiTangCa.value === 'ngay_thuong' && gioBatDau.value) {
        const startTime = gioBatDau.value.split(':');
        const startHour = parseInt(startTime[0]);
        const startMinute = parseInt(startTime[1]);

        // Kiểm tra nếu thời gian bắt đầu trước 18:45
        if (startHour < 18 || (startHour === 18 && startMinute < 45)) {
            showError('Ngày thường chỉ được tăng ca từ 18:45 trở đi!');
            gioBatDau.value = '18:45';
            calculateHours();
            return false;
        }
    }
    return true;
}

// Tính toán số giờ tăng ca (hàm tiện ích)
function calculateOvertimeHours() {
    const startTimeInput = document.getElementById('gio_bat_dau');
    const endTimeInput = document.getElementById('gio_ket_thuc');

    if (!startTimeInput || !endTimeInput) return 0;

    const startTime = startTimeInput.value;
    const endTime = endTimeInput.value;

    if (startTime && endTime) {
        const start = new Date(`2000-01-01T${startTime}:00`);
        let end = new Date(`2000-01-01T${endTime}:00`);

        // Xử lý trường hợp qua ngày
        if (end <= start) {
            end.setDate(end.getDate() + 1);
        }

        const diffMs = end - start;
        const diffHours = diffMs / (1000 * 60 * 60);

        return Math.round(diffHours * 10) / 10; // Làm tròn 1 chữ số thập phân
    }
    return 0;
}

// Validate form trước khi submit
function validateOvertimeForm(formData) {
    const overtimeType = formData.get('loai_tang_ca');
    const startTime = formData.get('gio_bat_dau');
    const endTime = formData.get('gio_ket_thuc');
    const overtimeDate = formData.get('ngay_tang_ca');
    const reason = formData.get('ly_do_tang_ca');

    // Check required fields
    if (!overtimeType) {
        showError('Vui lòng chọn loại tăng ca');
        return false;
    }

    if (!overtimeDate) {
        showError('Vui lòng chọn ngày tăng ca');
        return false;
    }

    if (!startTime) {
        showError('Vui lòng nhập giờ bắt đầu');
        return false;
    }

    if (!endTime) {
        showError('Vui lòng nhập giờ kết thúc');
        return false;
    }

    if (!reason || !reason.trim()) {
        showError('Vui lòng nhập lý do tăng ca');
        return false;
    }

    // Check date is not in the past
    const today = new Date();
    const selectedDate = new Date(overtimeDate);
    today.setHours(0, 0, 0, 0);
    selectedDate.setHours(0, 0, 0, 0);

    if (selectedDate < today) {
        showError('Ngày tăng ca không được trong quá khứ');
        return false;
    }

    // Check time restriction for weekdays
    if (overtimeType === 'ngay_thuong') {
        const [hour, minute] = startTime.split(':').map(Number);
        if (hour < 18 || (hour === 18 && minute < 45)) {
            showError('Ngày thường chỉ được tăng ca từ 18:45 trở đi');
            return false;
        }
    }

    // Check overtime hours
    const soGioTangCa = calculateOvertimeHours();
    if (soGioTangCa <= 0) {
        showError('Giờ kết thúc phải sau giờ bắt đầu');
        return false;
    }

    if (soGioTangCa > 12) {
        showError('Số giờ tăng ca không được vượt quá 12 giờ');
        return false;
    }

    return true;
}

// Xử lý submit form
function submitOvertime(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    // Validate dữ liệu
    if (!validateOvertimeForm(formData)) {
        return;
    }

    // Tính số giờ tăng ca
    const soGioTangCa = calculateOvertimeHours();

    // Tạo object dữ liệu để gửi
    const overtimeData = {
        loai_tang_ca: formData.get('loai_tang_ca'),
        ngay_tang_ca: formData.get('ngay_tang_ca'),
        gio_bat_dau: formData.get('gio_bat_dau'),
        gio_ket_thuc: formData.get('gio_ket_thuc'),
        so_gio_tang_ca: soGioTangCa,
        ly_do_tang_ca: formData.get('ly_do_tang_ca').trim()
    };

    console.log('Dữ liệu đơn tăng ca:', overtimeData);

    // Gọi API để gửi dữ liệu
    submitOvertimeRequest(overtimeData);
}

// Hàm submit form
async function submitOvertimeRequest(data) {
    try {
        // Hiển thị loading
        const submitBtn = document.querySelector('#overtimeModal button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Đang gửi...';
        submitBtn.disabled = true;

        // Lấy CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        // Gửi request
        const response = await fetch('{{ route('cham-cong.tao-don-xin-tang-ca.store')}}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok && result.success) {
            showSuccess('Gửi đơn tăng ca thành công!');
            closeModal('overtimeModal');

            // Reload danh sách hoặc cập nhật UI
            if (typeof loadOvertimeList === 'function') {
                loadOvertimeList();
            } else {
                // Refresh trang nếu không có hàm reload
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        } else {
            // Xử lý lỗi validation
            if (result.errors) {
                showValidationErrors(result.errors);
            } else {
                showError(result.message || 'Có lỗi xảy ra khi gửi đơn tăng ca');
            }
        }

    } catch (error) {
        console.error('Lỗi:', error);
        showError('Có lỗi xảy ra khi gửi đơn tăng ca. Vui lòng thử lại.');
    } finally {
        // Khôi phục nút submit
        const submitBtn = document.querySelector('#overtimeModal button[type="submit"]');
        if (submitBtn) {
            submitBtn.textContent = 'Gửi đơn';
            submitBtn.disabled = false;
        }
    }
}

// Hiển thị lỗi validation
function showValidationErrors(errors) {
    let errorMessages = [];

    for (const field in errors) {
        if (errors[field] && Array.isArray(errors[field])) {
            errorMessages = errorMessages.concat(errors[field]);
        }
    }

    if (errorMessages.length > 0) {
        showError(errorMessages.join('\n'));
    }
}

// Utility functions for notifications
function showSuccess(message) {
    // Có thể thay thế bằng toast notification
    alert('✅ ' + message);
}

function showError(message) {
    // Có thể thay thế bằng toast notification
    alert('❌ ' + message);
}

// Ẩn div hiển thị số giờ tính toán
function hideCalculatedHours() {
    const calculatedHoursDiv = document.getElementById('calculatedHours');
    if (calculatedHoursDiv) {
        calculatedHoursDiv.style.display = 'none';
        calculatedHoursDiv.style.color = ''; // Reset color
    }
}

// Hàm đóng modal
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';

        // Reset form
        const form = modal.querySelector('form');
        if (form) {
            form.reset();
            hideCalculatedHours();

            // Ẩn ghi chú hạn chế thời gian
            const timeRestrictionNote = document.getElementById('timeRestrictionNote');
            if (timeRestrictionNote) {
                timeRestrictionNote.style.display = 'none';
            }

            // Reset min attribute của input giờ bắt đầu
            const gioBatDau = document.getElementById('gio_bat_dau');
            if (gioBatDau) {
                gioBatDau.removeAttribute('min');
            }
        }
    }
}

// Khởi tạo event listeners khi DOM đã load
document.addEventListener('DOMContentLoaded', function() {
    // Event listener cho input giờ bắt đầu
    const gioBatDauInput = document.getElementById('gio_bat_dau');
    if (gioBatDauInput) {
        gioBatDauInput.addEventListener('blur', validateOvertimeTime);
        gioBatDauInput.addEventListener('change', calculateHours);
    }

    // Event listener cho input giờ kết thúc
    const gioKetThucInput = document.getElementById('gio_ket_thuc');
    if (gioKetThucInput) {
        gioKetThucInput.addEventListener('change', calculateHours);
    }

    // Event listener cho select loại tăng ca
    const loaiTangCaSelect = document.getElementById('loai_tang_ca');
    if (loaiTangCaSelect) {
        loaiTangCaSelect.addEventListener('change', handleOvertimeTypeChange);
    }

    // Đóng modal khi click bên ngoài
    window.onclick = function(event) {
        const modal = document.getElementById('overtimeModal');
        if (event.target === modal) {
            closeModal('overtimeModal');
        }
    };

    // Đóng modal khi nhấn ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modal = document.getElementById('overtimeModal');
            if (modal && modal.style.display === 'block') {
                closeModal('overtimeModal');
            }
        }
    });

    // Set min date cho input ngày tăng ca là hôm nay
    const ngayTangCaInput = document.getElementById('ngay_tang_ca');
    if (ngayTangCaInput) {
        const today = new Date().toISOString().split('T')[0];
        ngayTangCaInput.min = today;
    }
});
</script>
@endsection
