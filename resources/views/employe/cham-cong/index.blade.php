@extends('layoutsEmploye.master')

@section('content-employee')
<!-- Thông báo -->
<div id="notification" class="notification" style="display: none;">
    <div class="notification-item">
        <div class="notification-header">
            <span class="notification-title">New Message</span>
            <span class="notification-time">5 mins ago</span>
        </div>
        <div class="notification-content">
            You have received a new message from John Doe.
        </div>
        <button class="notification-close">×</button>
    </div>
</div>
<section class="content-section" id="attendance">

     <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Chấm công</h2>
        <button class="btn btn-primary checkin-btn" onclick="checkInOut()" id="checkinBtn" style="display: none">
            <i class="fas fa-fingerprint"></i>
            <span id="btnText">Chấm công</span>
        </button>
    </div>

   <!-- Thống kê ngày hôm nay -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div class="stat-card">
            <i class="fas fa-clock stat-icon"></i>
            <div class="stat-value" id="gioVaoHomNay">
                {{ $chamCongHomNay ? $chamCongHomNay->gio_vao_format : '--:--' }}
            </div>
            <div class="stat-label">Giờ vào hôm nay</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-clock stat-icon"></i>
            <div class="stat-value" id="gioRaHomNay">
                {{ $chamCongHomNay ? $chamCongHomNay->gio_ra_format : '--:--' }}
            </div>
            <div class="stat-label">Giờ ra hôm nay</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-stopwatch stat-icon"></i>
            <div class="stat-value" id="soGioLamHomNay">
                {{ $chamCongHomNay ? $chamCongHomNay->so_gio_lam . 'h' : '0h' }}
            </div>
            <div class="stat-label">Tổng giờ làm hôm nay</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-calendar-check stat-icon"></i>
            <div class="stat-value" id="trangThaiHomNay">
                {{ $chamCongHomNay ? $chamCongHomNay->trang_thai_text : 'Chưa chấm công' }}
            </div>
            <div class="stat-label">Trạng thái hôm nay</div>
        </div>
    </div>

    <!-- Lịch chấm công -->
    <div class="calendar-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3>Lịch chấm công tháng {{ now()->month }}/{{ now()->year }}</h3>
            <div class="calendar-legend">
                <span class="legend-item"><span class="legend-color day-present"></span>Có mặt</span>
                <span class="legend-item"><span class="legend-color day-late"></span>Đi muộn</span>
                <span class="legend-item"><span class="legend-color day-early"></span>Về sớm</span>
                <span class="legend-item"><span class="legend-color day-leave"></span>Nghỉ phép</span>
                <span class="legend-item"><span class="legend-color day-absent"></span>Vắng mặt</span>
            </div>
        </div>

        <div class="attendance-grid">
            <div class="day-cell day-header">T2</div>
            <div class="day-cell day-header">T3</div>
            <div class="day-cell day-header">T4</div>
            <div class="day-cell day-header">T5</div>
            <div class="day-cell day-header">T6</div>
            <div class="day-cell day-header">T7</div>
            <div class="day-cell day-header">CN</div>

            @foreach($lichChamCong as $ngay)
                <div class="day-cell {{ $ngay['class'] }}"
                    @php
                    $chamCong = $ngay['cham_cong'] ?? null;
                    @endphp

                     @if($chamCong instanceof \App\Models\ChamCong)
                        title="Vào: {{ $ngay['cham_cong']->gio_vao_format }} - Ra: {{ $ngay['cham_cong']->gio_ra_format }} - {{ $ngay['cham_cong']->trang_thai_text }}"
                     @endif>
                    {{ $ngay['ngay'] }}
                </div>
            @endforeach
        </div>
    </div>
    </div>
</section>
@endsection

@section('javascript')
<script>
    let currentUser = {{ auth()->id() }};

    // CẤU HÌNH VỊ TRÍ CÔNG TY
    const COMPANY_LOCATION = {
        latitude: 21.0305024,    // Thay bằng tọa độ thực tế của công ty
        longitude: 105.7685504,  // Thay bằng tọa độ thực tế của công ty
        // latitude: 21.0305,    // Thay bằng tọa độ thực tế của công ty
        // longitude: 105.5684,  // Thay bằng tọa độ thực tế của công ty
        allowedRadius: 5000   // 5km = 5000 mét
    };

    // Khởi tạo trạng thái khi load trang
    document.addEventListener('DOMContentLoaded', async function() {
        await checkAttendanceStatus();
        await updateButtonState();
    });

    // Kiểm tra trạng thái chấm công hiện tại
    async function checkAttendanceStatus() {
        // console.log(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        fetch('/employee/cham-cong/trang-thai', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(async data => {
            if (data.success) {
                switch(data.trang_thai) {
                    case 'chua_cham_cong':
                        attendanceStatus = 'out';
                        break;
                    case 'da_cham_cong_vao':
                        attendanceStatus = 'in';
                        break;
                    case 'da_hoan_thanh':
                        attendanceStatus = 'completed';
                        break;
                }

                if (data.data) {
                    console.log(data.data);
                    updateDisplayData(data.data);
                }

                await updateButtonState();
                document.getElementById("checkinBtn").style.display = "inline-block";
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi khi kiểm tra trạng thái chấm công', 'error');
        });
    }

    // Cập nhật dữ liệu hiển thị
    function updateDisplayData(data) {
        document.getElementById("checkinBtn").style.display = "inline-block";
        document.getElementById('gioVaoHomNay').textContent = data.gio_vao;
        document.getElementById('gioRaHomNay').textContent = data.gio_ra;
        document.getElementById('soGioLamHomNay').textContent = data.so_gio_lam + 'h';
        document.getElementById('trangThaiHomNay').textContent = data.trang_thai_text;
    }

    // Cập nhật trạng thái button
    function updateButtonState() {
        const btn = document.getElementById('checkinBtn');
        const btnText = document.getElementById('btnText');

        switch(attendanceStatus) {
            case 'out':
                btn.innerHTML = '<i class="fas fa-fingerprint"></i> <span>Chấm công vào</span>';
                btn.style.background = 'linear-gradient(135deg, #007bff, #0056b3)';
                btn.disabled = false;
                break;

            case 'in':
                btn.innerHTML = '<i class="fas fa-sign-out-alt"></i> <span>Chấm công ra</span>';
                btn.style.background = 'linear-gradient(135deg, #ff6b6b, #ff9f43)';
                btn.disabled = false;
                break;

            case 'completed':
                btn.innerHTML = '<i class="fas fa-check-double"></i> <span>Đã hoàn thành</span>';
                btn.style.background = 'linear-gradient(135deg, #28a745, #20c997)';
                btn.disabled = true;
                break;
        }
    }

    // Tính khoảng cách giữa 2 điểm GPS (công thức Haversine)
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371e3; // Bán kính trái đất tính bằng mét
        const φ1 = lat1 * Math.PI/180; // φ, λ in radians
        const φ2 = lat2 * Math.PI/180;
        const Δφ = (lat2-lat1) * Math.PI/180;
        const Δλ = (lon2-lon1) * Math.PI/180;

        const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                  Math.cos(φ1) * Math.cos(φ2) *
                  Math.sin(Δλ/2) * Math.sin(Δλ/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

        const distance = R * c; // khoảng cách tính bằng mét
        return distance;
    }

    // Kiểm tra vị trí có trong phạm vi cho phép không
    function isWithinAllowedArea(currentLat, currentLng) {
        const distance = calculateDistance(
            COMPANY_LOCATION.latitude,
            COMPANY_LOCATION.longitude,
            currentLat,
            currentLng
        );
        console.log(`Vị trí hiện tại: ${currentLat}, ${currentLng}`);
        console.log(`Khoảng cách từ công ty: ${Math.round(distance)}m`);

        return {
            isValid: distance <= COMPANY_LOCATION.allowedRadius,
            distance: Math.round(distance),
            maxDistance: COMPANY_LOCATION.allowedRadius
        };
    }

    // Xử lý chấm công
    async function checkInOut() {
        const btn = document.getElementById('checkinBtn');

        // Hiệu ứng click
        btn.style.transform = 'scale(0.95)';
        setTimeout(() => {
            btn.style.transform = 'scale(1)';
        }, 100);

        // Lấy vị trí hiện tại trước khi chấm công
        // showNotification('Đang lấy vị trí hiện tại...', 'info');

        try {
            const location = await getCurrentLocation();
            // console.log(location);
            if (!location || location.error) {
                showNotification('Không thể lấy vị trí hiện tại. Vui lòng cho phép truy cập vị trí.', 'error');
                return;
            }

            // Kiểm tra vị trí có trong phạm vi cho phép không
            const locationCheck = isWithinAllowedArea(location.latitude, location.longitude);

            if (!locationCheck.isValid) {
                const distanceKm = (locationCheck.distance / 1000).toFixed(1);
                const maxDistanceKm = (locationCheck.maxDistance / 1000).toFixed(1);
                showNotification(
                    `Bạn đang ở cách công ty ${distanceKm}km. Chỉ được chấm công trong phạm vi ${maxDistanceKm}km.`,
                    'error'
                );
                return;
            }

            // Nếu vị trí hợp lệ, tiến hành chấm công
            if (attendanceStatus === 'out') {
                btn.disabled = true;
                btn.innerHTML = `<i class="fas fa-check-circle"></i> Đã chấm công thành công`;
                chamCongVao(location);
            } else if (attendanceStatus === 'in') {
                chamCongRa(location);
            }

        } catch (error) {
            console.error('Lỗi khi kiểm tra vị trí:', error);
            showNotification('Có lỗi xảy ra khi kiểm tra vị trí', 'error');
        }
    }

    // Chấm công vào
    function chamCongVao(location) {
        const requestData = {
            latitude: parseFloat(location.latitude.toFixed(8)),
            longitude: parseFloat(location.longitude.toFixed(8)),
            address: location.address || "Không xác định được địa chỉ chi tiết",
            accuracy: location.accuracy || null,
            timestamp: location.timestamp || new Date().toISOString(),
            // Thêm thông tin bổ sung nếu có
            ...(location.heading && { heading: location.heading }),
            ...(location.speed && { speed: location.speed }),
            ...(location.altitude && { altitude: location.altitude })
        };

        console.log("Dữ liệu vị trí:", requestData);

        fetch('/employee/cham-cong/vao', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                attendanceStatus = 'in';
                updateDisplayData({
                    gio_vao: data.data.gio_vao,
                    gio_ra: '--:--',
                    so_gio_lam: 0,
                    trang_thai_text: data.data.trang_thai_text
                });

                showNotification(data.message, 'success');
                console.log(data.success);

                // Disable button trong 1 phút để tránh spam
                disableButtonTemporarily(60);

            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi xảy ra khi chấm công', 'error');
        });
    }

    // Chấm công ra
    function chamCongRa(location) {
        const requestData = {
            latitude: location.latitude,
            longitude: location.longitude,
            address: location.address || "Không xác định được địa chỉ chi tiết"
        };

        console.log("Dữ liệu vị trí:", requestData);

        fetch('/employee/cham-cong/ra', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                attendanceStatus = 'completed';
                updateButtonState();
                updateDisplayData({
                    gio_vao: document.getElementById('gioVaoHomNay').textContent,
                    gio_ra: data.data.gio_ra,
                    so_gio_lam: data.data.so_gio_lam,
                    trang_thai_text: data.data.trang_thai_text
                });

                showNotification(data.message, 'success');

            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi xảy ra khi chấm công', 'error');
        });
    }

    // Lấy vị trí hiện tại với độ chính xác cao
    async function getCurrentLocation() {
        return new Promise((resolve) => {
            if (!navigator.geolocation) {
                showNotification("Trình duyệt không hỗ trợ Geolocation",'error');
                resolve(null);
                return;
            }

            const highAccuracyOptions = {
                enableHighAccuracy: true,
                timeout: 45000, // Tăng thời gian chờ lên 45 giây
                maximumAge: 0 // Luôn lấy vị trí mới nhất
            };

            // Thử lấy vị trí với độ chính xác cao trước
            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    try {
                        const { latitude, longitude, accuracy, heading, speed, altitude } = position.coords;

                        // Lấy địa chỉ chi tiết
                        const address = await getVietnameseAddress(latitude, longitude);

                        resolve({
                            latitude,
                            longitude,
                            accuracy: Math.round(accuracy), // Độ chính xác tính bằng mét
                            heading: heading || null, // Hướng di chuyển
                            speed: speed || null, // Tốc độ
                            altitude: altitude || null, // Độ cao
                            address: address || `Vị trí tại: ${latitude.toFixed(6)}, ${longitude.toFixed(6)}`,
                            timestamp: new Date().toISOString()
                        });
                    } catch (error) {
                        console.log('Lỗi khi lấy địa chỉ:', error);
                        resolve({
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude,
                            accuracy: Math.round(position.coords.accuracy),
                            address: null,
                            timestamp: new Date().toISOString()
                        });
                    }
                },
                (error) => {
                    // Nếu lỗi, thử lại với cài đặt thấp hơn
                    showNotification('Lỗi với cài đặt độ chính xác cao, thử lại...' , 'error');

                    const fallbackOptions = {
                        enableHighAccuracy: false,
                        timeout: 30000,
                        maximumAge: 300000 // Chấp nhận cache 5 phút
                    };

                    navigator.geolocation.getCurrentPosition(
                        async (position) => {
                            try {
                                const { latitude, longitude, accuracy } = position.coords;
                                const address = await getVietnameseAddress(latitude, longitude);

                                resolve({
                                    latitude,
                                    longitude,
                                    accuracy: Math.round(accuracy),
                                    address: address || `Vị trí tại: ${latitude.toFixed(6)}, ${longitude.toFixed(6)}`,
                                    timestamp: new Date().toISOString(),
                                    note: "Sử dụng cài đặt dự phòng"
                                });
                            } catch (err) {
                                resolve({
                                    latitude: position.coords.latitude,
                                    longitude: position.coords.longitude,
                                    accuracy: Math.round(position.coords.accuracy),
                                    address: null,
                                    timestamp: new Date().toISOString(),
                                    note: "Sử dụng cài đặt dự phòng"
                                });
                            }
                        },
                        (fallbackError) => {
                            let errorMessage = "Không thể lấy vị trí";
                            switch(fallbackError.code) {
                                case fallbackError.PERMISSION_DENIED:
                                    errorMessage = "Người dùng từ chối cho phép truy cập vị trí";
                                    break;
                                case fallbackError.POSITION_UNAVAILABLE:
                                    errorMessage = "Thông tin vị trí không khả dụng";
                                    break;
                                case fallbackError.TIMEOUT:
                                    errorMessage = "Hết thời gian chờ lấy vị trí";
                                    break;
                                default:
                                    errorMessage = "Lỗi không xác định khi lấy vị trí";
                                    break;
                            }
                            console.log(errorMessage);
                            resolve({ error: errorMessage });
                        },
                        fallbackOptions
                    );
                },
                highAccuracyOptions
            );
        });
    }

    // Hàm lấy địa chỉ tiếng Việt từ tọa độ với nhiều nguồn dữ liệu
    async function getVietnameseAddress(lat, lng) {
        const services = [
            {
                name: 'OpenStreetMap',
                url: `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1&accept-language=vi`,
                parser: (data) => {
                    if (data.error) return null;

                    const address = data.address;
                    let parts = [];

                    // Số nhà
                    if (address.house_number) parts.push(address.house_number);

                    // Đường
                    if (address.road) parts.push(address.road);
                    else if (address.pedestrian) parts.push(address.pedestrian);
                    else if (address.footway) parts.push(address.footway);

                    // Khu vực nhỏ
                    if (address.suburb) parts.push(address.suburb);
                    else if (address.neighbourhood) parts.push(address.neighbourhood);
                    else if (address.hamlet) parts.push(address.hamlet);

                    // Quận/huyện
                    if (address.city_district) parts.push(address.city_district);
                    else if (address.county) parts.push(address.county);
                    else if (address.district) parts.push(address.district);

                    // Thành phố/tỉnh
                    if (address.city) parts.push(address.city);
                    else if (address.town) parts.push(address.town);
                    else if (address.village) parts.push(address.village);
                    else if (address.municipality) parts.push(address.municipality);

                    // Tỉnh/bang
                    if (address.state) parts.push(address.state);

                    return parts.length > 0 ? parts.join(', ') : null;
                }
            }
        ];

        for (let service of services) {
            try {
                console.log(`Đang thử lấy địa chỉ từ ${service.name}...`);

                const response = await fetch(service.url, {
                    headers: {
                        'User-Agent': 'LocationApp/1.0'
                    }
                });

                if (!response.ok) {
                    console.log(`${service.name} trả về lỗi: ${response.status}`);
                    continue;
                }

                const data = await response.json();
                const address = service.parser(data);

                if (address) {
                    console.log(`Lấy địa chỉ thành công từ ${service.name}`);
                    return address;
                }
            } catch (error) {
                console.error(`Lỗi khi lấy địa chỉ từ ${service.name}:`, error);
            }
        }

        // Nếu không lấy được địa chỉ từ dịch vụ nào
        return `Tọa độ: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    }

    // Vô hiệu hóa button tạm thời
    function disableButtonTemporarily(seconds) {
        const btn = document.getElementById('checkinBtn');
        let countdown = seconds;

        const timer = setInterval(() => {
            const minutes = Math.floor(countdown / 60);
            const secs = countdown % 60;
            countdown--;

            if (countdown < 0) {
                clearInterval(timer);
                btn.disabled = false;
                updateButtonState();
            }
        }, 1000);
    }

    // // Hiển thị thông báo

    function showNotification(message, type = 'success') {
    const notificationContainer = document.getElementById('notification');
    const notificationItem = document.createElement('div');
    notificationItem.className = `notification-item ${type}`;

    // Tạo nội dung thông báo
    notificationItem.innerHTML = `
        <div class="notification-header">
            <span class="notification-title">${type.charAt(0).toUpperCase() + type.slice(1)}</span>
            <span class="notification-time">${new Date().toLocaleTimeString()}</span>
        </div>
        <div class="notification-content">${message}</div>
        <button class="notification-close">×</button>
    `;

    // Thêm thông báo vào container
    notificationContainer.appendChild(notificationItem);
    notificationContainer.style.display = 'block';

    // Hiệu ứng hiển thị
    setTimeout(() => {
        notificationItem.classList.add('show');
    }, 100);

    // Tự động ẩn sau 5 giây
    setTimeout(() => {
        notificationItem.classList.remove('show');
        setTimeout(() => {
            notificationItem.remove();
            if (!notificationContainer.hasChildNodes()) {
                notificationContainer.style.display = 'none';
            }
        }, 300);
    }, 5000);

    // Xử lý sự kiện nút đóng
    notificationItem.querySelector('.notification-close').addEventListener('click', () => {
        notificationItem.classList.remove('show');
        setTimeout(() => {
            notificationItem.remove();
            if (!notificationContainer.hasChildNodes()) {
                notificationContainer.style.display = 'none';
            }
        }, 300);
    });
}
</script>
@endsection
