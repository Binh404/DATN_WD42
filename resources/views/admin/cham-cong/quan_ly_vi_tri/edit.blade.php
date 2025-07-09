@extends('layoutsAdmin.master')

@section('title', 'Sửa địa chỉ công ty')
@section('style')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin=""/>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thêm địa chỉ công ty mới</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.locations.update', $location->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ công ty <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('address') is-invalid @enderror"
                                           id="address"
                                           name="address"
                                           value="{{ old('address', $location->address) }}"
                                           placeholder="Nhập địa chỉ công ty...">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="latitude" class="form-label">Vĩ độ (Latitude) <span class="text-danger">*</span></label>
                                            <input type="number"
                                                   class="form-control @error('latitude') is-invalid @enderror"
                                                   id="latitude"
                                                   name="latitude"
                                                   value="{{ old('latitude', $location->latitude) }}"
                                                   step="any"
                                                   placeholder="21.0285">
                                            @error('latitude')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="longitude" class="form-label">Kinh độ (Longitude) <span class="text-danger">*</span></label>
                                            <input type="number"
                                                   class="form-control @error('longitude') is-invalid @enderror"
                                                   id="longitude"
                                                   name="longitude"
                                                   value="{{ old('longitude', $location->longitude) }}"
                                                   step="any"
                                                   placeholder="105.8542">
                                            @error('longitude')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="allowed_radius" class="form-label">Bán kính cho phép (mét) <span class="text-danger">*</span></label>
                                    <input type="number"
                                           class="form-control @error('allowed_radius') is-invalid @enderror"
                                           id="allowed_radius"
                                           name="allowed_radius"
                                           value="{{ old('allowed_radius', $location->allowed_radius) }}"
                                           min="1"
                                           max="10000"
                                           placeholder="1000">
                                    <div class="form-text">Khoảng cách tối đa từ địa chỉ công ty (1-10000 mét)</div>
                                    @error('allowed_radius')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="alert alert-info">
                                    <h6><i class="mdi mdi-information-outline"></i> Hướng dẫn sử dụng:</h6>
                                    <ul class="mb-0">
                                        <li>Click vào vị trí trên bản đồ để lấy tọa độ và địa chỉ</li>
                                        <li>Kéo thả marker để điều chỉnh vị trí (tự động cập nhật địa chỉ)</li>
                                        <li>Hoặc nhập trực tiếp tọa độ vào ô Vĩ độ/Kinh độ</li>
                                        <li>Sử dụng nút "Lấy vị trí hiện tại" để tự động điền tọa độ và địa chỉ</li>
                                    </ul>
                                </div>

                                <div class="mb-3">
                                    <button type="button" class="btn btn-info" onclick="getCurrentLocation()">
                                        <i class="mdi mdi-map-marker"></i> Lấy vị trí hiện tại
                                    </button>
                                    <button type="button" class="btn btn-success ms-2" onclick="searchAddress()">
                                        <i class="mdi mdi-magnify"></i> Tìm theo địa chỉ
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Xem trước bản đồ</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="map" style="height: 300px; border-radius: 5px;"></div>
                                        <small class="text-muted mt-2 d-block">
                                            Click vào bản đồ để chọn vị trí và lấy địa chỉ
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Lưu địa chỉ
                        </button>
                        <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-close"></i> Hủy bỏ
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
<!-- Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

<script>
let map;
let marker;
let circle;

// Khởi tạo bản đồ
function initMap() {
    // Lấy tọa độ từ dữ liệu hiện tại hoặc mặc định (Hà Nội)
    const currentLat = parseFloat(document.getElementById('latitude').value) || 21.0285;
    const currentLng = parseFloat(document.getElementById('longitude').value) || 105.8542;
    const currentRadius = parseInt(document.getElementById('allowed_radius').value) || 1000;

    const defaultLocation = [currentLat, currentLng];

    // Tạo bản đồ
    map = L.map('map').setView(defaultLocation, 15);

    // Thêm tile layer (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Tạo marker
    marker = L.marker(defaultLocation, {
        draggable: true
    }).addTo(map);

    // Tạo circle để hiển thị bán kính
    circle = L.circle(defaultLocation, {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.2,
        radius: currentRadius
    }).addTo(map);

    // Sự kiện khi kéo marker
    marker.on('dragend', function(e) {
        const position = e.target.getLatLng();
        updateCoordinates(position.lat, position.lng);
        updateCircle();
        // Tự động lấy địa chỉ khi kéo marker
        getAddressFromCoordinates(position.lat, position.lng);
    });

    // Sự kiện click trên bản đồ
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        marker.setLatLng([lat, lng]);
        updateCoordinates(lat, lng);
        updateCircle();
        // Tự động lấy địa chỉ khi click trên bản đồ
        getAddressFromCoordinates(lat, lng);
    });

    // Sự kiện khi thay đổi input
    document.getElementById('latitude').addEventListener('input', updateMapFromInput);
    document.getElementById('longitude').addEventListener('input', updateMapFromInput);
    document.getElementById('allowed_radius').addEventListener('input', updateCircle);
}

// Cập nhật tọa độ vào input
function updateCoordinates(lat, lng) {
    document.getElementById('latitude').value = lat.toFixed(7);
    document.getElementById('longitude').value = lng.toFixed(7);
}

// Cập nhật bản đồ từ input
function updateMapFromInput() {
    const lat = parseFloat(document.getElementById('latitude').value);
    const lng = parseFloat(document.getElementById('longitude').value);

    if (!isNaN(lat) && !isNaN(lng)) {
        const newPosition = [lat, lng];
        marker.setLatLng(newPosition);
        map.setView(newPosition);
        updateCircle();
        // Tự động lấy địa chỉ khi nhập tọa độ
        getAddressFromCoordinates(lat, lng);
    }
}

// Cập nhật circle bán kính
function updateCircle() {
    const radius = parseInt(document.getElementById('allowed_radius').value) || 1000;
    const position = marker.getLatLng();
    circle.setLatLng(position);
    circle.setRadius(radius);
}

// Lấy địa chỉ từ tọa độ (Reverse Geocoding)
async function getAddressFromCoordinates(lat, lng) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
        const data = await response.json();

        if (data && data.display_name) {
            // Cập nhật địa chỉ vào input
            document.getElementById('address').value = data.display_name;

            // Hiển thị thông báo nhỏ
            showNotification('Đã cập nhật địa chỉ tự động', 'success');
        }
    } catch (error) {
        console.log('Không thể lấy địa chỉ từ tọa độ:', error);
    }
}

// Lấy vị trí hiện tại
function getCurrentLocation() {
    if (navigator.geolocation) {
        // Hiển thị loading
        showNotification('Đang lấy vị trí hiện tại...', 'info');

        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                marker.setLatLng([lat, lng]);
                map.setView([lat, lng]);
                updateCoordinates(lat, lng);
                updateCircle();

                // Tự động lấy địa chỉ
                getAddressFromCoordinates(lat, lng);

                showNotification('Đã lấy vị trí hiện tại thành công!', 'success');
            },
            function(error) {
                showNotification('Không thể lấy vị trí hiện tại. Vui lòng chọn trên bản đồ.', 'danger');
            }
        );
    } else {
        showNotification('Trình duyệt không hỗ trợ Geolocation.', 'danger');
    }
}

// Tìm kiếm theo địa chỉ (sử dụng Nominatim API - miễn phí)
async function searchAddress() {
    const address = document.getElementById('address').value;

    if (!address.trim()) {
        showNotification('Vui lòng nhập địa chỉ cần tìm', 'warning');
        return;
    }

    try {
        showNotification('Đang tìm kiếm địa chỉ...', 'info');

        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`);
        const data = await response.json();

        if (data && data.length > 0) {
            const lat = parseFloat(data[0].lat);
            const lng = parseFloat(data[0].lon);

            marker.setLatLng([lat, lng]);
            map.setView([lat, lng], 16);
            updateCoordinates(lat, lng);
            updateCircle();

            // Cập nhật địa chỉ đầy đủ từ kết quả tìm kiếm
            document.getElementById('address').value = data[0].display_name;

            showNotification('Đã tìm thấy địa chỉ!', 'success');
        } else {
            showNotification('Không tìm thấy địa chỉ. Vui lòng thử lại với địa chỉ khác.', 'warning');
        }
    } catch (error) {
        showNotification('Lỗi khi tìm kiếm địa chỉ. Vui lòng thử lại.', 'danger');
    }
}

// Hiển thị thông báo Toast Bootstrap 5
function showNotification(message, type = 'info') {
    // Tạo container cho toast nếu chưa có
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // Tạo toast
    const toastId = 'toast-' + Date.now();
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = `toast align-items-center text-bg-${getBootstrapToastClass(type)} border-0`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');

    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;

    toastContainer.appendChild(toast);

    // Khởi tạo và hiển thị toast
    const bsToast = new bootstrap.Toast(toast, {
        autohide: true,
        delay: 3000
    });
    bsToast.show();

    // Xóa toast sau khi ẩn
    toast.addEventListener('hidden.bs.toast', function() {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    });
}

// Chuyển đổi loại thông báo sang class Bootstrap Toast
function getBootstrapToastClass(type) {
    switch(type) {
        case 'success': return 'success';
        case 'error': return 'danger';
        case 'warning': return 'warning';
        case 'info': return 'info';
        default: return 'info';
    }
}

// Khởi tạo bản đồ khi trang load
document.addEventListener('DOMContentLoaded', function() {
    initMap();
});
</script>
@endsection
