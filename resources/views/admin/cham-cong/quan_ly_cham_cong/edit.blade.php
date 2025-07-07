@extends('layoutsAdmin.master')

@section('title', 'Chỉnh sửa chấm công')

@section('style')

@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Chỉnh sửa chấm công</h2>
                    {{-- <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.chamcong.index') }}">Chấm công</a></li>
                            <li class="breadcrumb-item active">Chỉnh sửa</li>
                        </ol>
                    </nav> --}}
                    <p class="mb-0 opacity-75">Chỉnh sửa thông tin bản ghi chấm công</p>

                </div>
                <div>
                    <a href="{{ route('admin.chamcong.show', $chamCong->id) }}" class="btn btn-light">
                        <i class="mdi mdi-arrow-left me-2"></i>Quay lại
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <div>
                        <strong>Có lỗi xảy ra:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Thông tin nhân viên -->
                <div class="col-md-4 mb-4">
                    <div class="card stat-card h-120">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="mdi mdi-account me-2"></i>Thông tin nhân viên</h5>
                        </div>
                        <div class="card-body text-center">
                            @php
                                $avatar = $chamCong->nguoiDung->hoSo->anh_dai_dien
                                    ? asset($chamCong->nguoiDung->hoSo->anh_dai_dien)
                                    : asset('assets/images/default.png');
                            @endphp
                            <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle border border-3 border-primary mb-3"
                                width="100" height="100"
                                onerror="this.onerror=null; this.src='{{ asset('assets/images/default.png') }}';">

                            <h5 class="card-title mb-3">
                                {{ $chamCong->nguoiDung->hoSo->ho ?? 'N/A' }}
                                {{ $chamCong->nguoiDung->hoSo->ten ?? 'N/A' }}
                            </h5>

                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <div class="fw-bold">{{ $chamCong->nguoiDung->hoSo->ma_nhan_vien ?? 'N/A' }}</div>
                                        <small class="opacity-75">Mã NV</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="fw-bold">{{ $chamCong->nguoiDung->phongBan->ten_phong_ban ?? 'N/A' }}</div>
                                    <small class="opacity-75">Phòng ban</small>
                                </div>
                            </div>

                            <hr class="border-light opacity-75">
                            <div class="small">
                                <i class="mdi mdi-phone me-2"></i>{{ $chamCong->nguoiDung->hoSo->so_dien_thoai ?? 'N/A' }}
                            </div>
                            <div class="small">
                                <i class="mdi mdi-email me-2"></i>{{ $chamCong->nguoiDung->email }}
                            </div>

                        </div>
                    </div>

                    <div class="card stat-card h-120 mt-2">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="mdi mdi-calendar me-2"></i>Thông tin chi tiết</h5>
                        </div>
                        <div class="card-body">
                            <!-- Thông tin tính toán -->
                            <div class="mb-3 p-2  bg-body-secondary rounded">
                                <h6 class="mb-2"><i class="mdi mdi-calculator me-2"></i>Thông tin tính toán</h6>
                                <div><strong>Số giờ làm:</strong> <span id="soGioLam">{{ number_format($chamCong->so_gio_lam, 1) }}h</span></div>
                                <div><strong>Số công:</strong> <span id="soCong">{{ number_format($chamCong->so_cong, 1) }}</span></div>
                                <div><strong>Phút đi muộn:</strong> <span id="phutDiMuon">{{ $chamCong->phut_di_muon ?? 0 }}p</span></div>
                                <div><strong>Phút về sớm:</strong> <span id="phutVeSom">{{ $chamCong->phut_ve_som ?? 0 }}p</span></div>
                            </div>

                            <!-- Thông tin audit -->
                            <div class="mb-3 p-2  bg-body-secondary rounded">
                                <h6 class="mb-2"><i class="mdi mdi-history me-2"></i>Thông tin cập nhật</h6>
                                <div><strong>Tạo lúc:</strong> {{ $chamCong->created_at->format('d/m/Y H:i') }}</div>
                                <div><strong>Cập nhật:</strong> {{ $chamCong->updated_at->format('d/m/Y H:i') }}</div>
                            </div>

                            <!-- Hướng dẫn -->
                            <div class="mb-3 p-2 rounded " style="background-color: rgba(13, 202, 240, 0.25);">
                                <h6><i class="mdi mdi-lightbulb me-2"></i>Lưu ý:</h6>
                                <ul class="mb-0 small">
                                    <li>Giờ vào tiêu chuẩn: 08:30</li>
                                    <li>Giờ tan tiêu chuẩn: 17:30</li>
                                    <li>Đi muộn hơn 08:30 sẽ bị tính phút đi muộn</li>
                                    <li>Về sớm hơn 17:30 sẽ bị tính phút về sớm</li>
                                    <li>Số công được tính dựa trên số giờ làm thực tế</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form chỉnh sửa -->
                <div class="col-md-8">
                    <form method="POST" action="{{ route('admin.chamcong.update', $chamCong->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="nguoi_dung_id" id="" value="{{ $chamCong->nguoi_dung_id }}">
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                <h5 class="mb-0"><i class="mdi mdi-pencil me-2"></i>Thông tin chấm công</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Ngày chấm công -->
                                    <div class="col-md-6 mb-3">
                                        <label for="ngay_cham_cong" class="form-label">
                                            <i class="mdi mdi-calendar text-primary me-2"></i>Ngày chấm công
                                        </label>
                                        <input type="date"
                                            class="form-control @error('ngay_cham_cong') is-invalid @enderror"
                                            id="ngay_cham_cong" name="ngay_cham_cong"
                                            value="{{ old('ngay_cham_cong', $chamCong->ngay_cham_cong->format('Y-m-d')) }}"
                                            required>
                                        @error('ngay_cham_cong')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Trạng thái -->
                                    <div class="col-md-6 mb-3">
                                        <label for="trang_thai" class="form-label">
                                            <i class="mdi mdi-flag text-primary me-2"></i>Trạng thái
                                        </label>
                                        <select class="form-select @error('trang_thai') is-invalid @enderror"
                                            id="trang_thai" name="trang_thai" required>
                                            <option value="">-- Chọn trạng thái --</option>
                                            <option value="binh_thuong" {{ old('trang_thai', $chamCong->trang_thai) == 'binh_thuong' ? 'selected' : '' }}>
                                                Bình thường
                                            </option>
                                            <option value="di_muon" {{ old('trang_thai', $chamCong->trang_thai) == 'di_muon' ? 'selected' : '' }}>
                                                Đi muộn
                                            </option>
                                            <option value="ve_som" {{ old('trang_thai', $chamCong->trang_thai) == 've_som' ? 'selected' : '' }}>
                                                Về sớm
                                            </option>
                                            <option value="vang_mat" {{ old('trang_thai', $chamCong->trang_thai) == 'vang_mat' ? 'selected' : '' }}>
                                                Vắng mặt
                                            </option>
                                            <option value="nghi_phep" {{ old('trang_thai', $chamCong->trang_thai) == 'nghi_phep' ? 'selected' : '' }}>
                                                Nghỉ phép
                                            </option>
                                        </select>
                                        @error('trang_thai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Giờ vào -->
                                    <div class="col-md-6 mb-3">
                                        <label for="gio_vao" class="form-label">
                                            <i class="mdi mdi-clock-in text-success me-2"></i>Giờ vào
                                        </label>
                                        <input type="time"
                                            class="form-control time-input @error('gio_vao') is-invalid @enderror"
                                            id="gio_vao" name="gio_vao"
                                            value="{{ old('gio_vao', $chamCong->gio_vao ? date('H:i', strtotime($chamCong->gio_vao)) : '') }}"
                                            step="60">
                                        @error('gio_vao')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Giờ ra -->
                                    <div class="col-md-6 mb-3">
                                        <label for="gio_ra" class="form-label">
                                            <i class="mdi mdi-clock-out text-danger me-2"></i>Giờ ra
                                        </label>
                                        <input type="time"
                                            class="form-control time-input @error('gio_ra') is-invalid @enderror"
                                            id="gio_ra" name="gio_ra"
                                            value="{{ old('gio_ra', $chamCong->gio_ra ? date('H:i', strtotime($chamCong->gio_ra)) : '') }}"
                                            step="60">
                                        @error('gio_ra')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Phút đi muộn -->
                                    <div class="col-md-6 mb-3">
                                        <label for="phut_di_muon" class="form-label">
                                            <i class="mdi mdi-timer-sand text-warning me-2"></i>Phút đi muộn
                                        </label>
                                        <input type="number"
                                            class="form-control @error('phut_di_muon') is-invalid @enderror"
                                            id="phut_di_muon" name="phut_di_muon"
                                            value="{{ old('phut_di_muon', $chamCong->phut_di_muon ?? 0) }}" min="0"
                                            max="480">
                                        @error('phut_di_muon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Phút về sớm -->
                                    <div class="col-md-6 mb-3">
                                        <label for="phut_ve_som" class="form-label">
                                            <i class="mdi mdi-timer text-info me-2"></i>Phút về sớm
                                        </label>
                                        <input type="number" class="form-control @error('phut_ve_som') is-invalid @enderror"
                                            id="phut_ve_som" name="phut_ve_som"
                                            value="{{ old('phut_ve_som', $chamCong->phut_ve_som ?? 0) }}" min="0" max="480">
                                        @error('phut_ve_som')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Số giờ làm -->
                                    <div class="col-md-6 mb-3">
                                        <label for="so_gio_lam" class="form-label">
                                            <i class="mdi mdi-clock text-primary me-2"></i>Số giờ làm
                                        </label>
                                        <input type="number" class="form-control @error('so_gio_lam') is-invalid @enderror"
                                            id="so_gio_lam" name="so_gio_lam"
                                            value="{{ old('so_gio_lam', $chamCong->so_gio_lam ?? 0) }}" min="0" max="24"
                                            step="0.1">
                                        @error('so_gio_lam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Số công -->
                                    <div class="col-md-6 mb-3">
                                        <label for="so_cong" class="form-label">
                                            <i class="mdi mdi-account-check text-success me-2"></i>Số công
                                        </label>
                                        <input type="number" class="form-control @error('so_cong') is-invalid @enderror"
                                            id="so_cong" name="so_cong"
                                            value="{{ old('so_cong', $chamCong->so_cong ?? 0) }}" min="0" max="1"
                                            step="0.1">
                                        @error('so_cong')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Ghi chú -->
                                    <div class="col-12 mb-3">
                                        <label for="ghi_chu" class="form-label">
                                            <i class="mdi mdi-note-text text-secondary me-2"></i>Ghi chú
                                        </label>
                                        <textarea class="form-control @error('ghi_chu') is-invalid @enderror" id="ghi_chu"
                                            name="ghi_chu" rows="3"
                                            placeholder="Nhập ghi chú (tùy chọn)">{{ old('ghi_chu', $chamCong->ghi_chu) }}</textarea>
                                        @error('ghi_chu')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Trạng thái trang_thai_duyet -->
                                    <div class="col-md-12 mb-3">
                                        <label for="trang_thai_duyet" class="form-label">
                                            <i class="mdi mdi-flag text-primary me-2"></i>Trạng thái phê duyệt
                                        </label>
                                        <select class="form-select @error('trang_thai_duyet') is-invalid @enderror"
                                            id="trang_thai_duyet" name="trang_thai_duyet" required>
                                            <option value="">-- Chọn trạng thái --</option>
                                            <option value="0" {{ old('trang_thai_duyet', $chamCong->trang_thai_duyet) == 0 ? 'selected' : '' }}>
                                                Chưa gửi lý do
                                            </option>
                                            <option value="1" {{ old('trang_thai_duyet', $chamCong->trang_thai_duyet) == 1 ? 'selected' : '' }}>
                                                Đã duyệt
                                            </option>
                                            <option value="2" {{ old('trang_thai_duyet', $chamCong->trang_thai_duyet) == 2 ? 'selected' : '' }}>
                                                Từ chối
                                            </option>
                                            <option value="3" {{ old('trang_thai_duyet', $chamCong->trang_thai_duyet) == 3 ? 'selected' : '' }}>
                                                Chờ duyệt
                                            </option>
                                        </select>
                                        @error('trang_thai_duyet')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <!-- Ghi chú -->
                                    <div class="col-12 mb-3">
                                        <label for="ghi_chu_duyet" class="form-label">
                                            <i class="mdi mdi-note-text text-secondary me-2"></i>Ghi chú duyệt
                                        </label>
                                        <textarea class="form-control @error('ghi_chu_duyet') is-invalid @enderror"
                                            id="ghi_chu_duyet" name="ghi_chu_duyet" rows="3"
                                            placeholder="Nhập ghi chú (tùy chọn)">{{ old('ghi_chu_duyet', $chamCong->ghi_chu_duyet) }}</textarea>
                                        @error('ghi_chu_duyet')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin tính toán -->
                        <div class="card mt-4 calculation-card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">
                                    <i class="mdi mdi-calculator text-primary me-2"></i>Tính toán tự động
                                </h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <div class="fw-bold text-primary" id="calculated-hours">0.0</div>
                                            <small class="text-muted">Giờ làm (tự động)</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <div class="fw-bold text-success" id="calculated-work">0.0</div>
                                            <small class="text-muted">Công (tự động)</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <div class="fw-bold text-info" id="status-preview">-</div>
                                            <small class="text-muted">Trạng thái dự kiến</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="card mt-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.chamcong.index') }}" class="btn btn-secondary">
                                        <i class="mdi mdi-arrow-left me-2"></i>Hủy
                                    </a>
                                    <div>
                                        <button type="button" class="btn btn-info me-2" onclick="autoCalculate()">
                                            <i class="mdi mdi-calculator me-2"></i>Tính toán tự động
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="mdi mdi-content-save me-2"></i>Cập nhật
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-hide alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function (alert) {
                setTimeout(function () {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 15000);
            });

            // Tính toán tự động khi thay đổi giờ vào/ra
            const gioVao = document.getElementById('gio_vao');
            const gioRa = document.getElementById('gio_ra');
            const trangThai = document.getElementById('trang_thai');

            [gioVao, gioRa, trangThai].forEach(element => {
                element.addEventListener('change', autoCalculate);
            });

            // Tính toán ban đầu
            autoCalculate();
        });

        function autoCalculate() {
            const gioVao = document.getElementById('gio_vao').value;
            const gioRa = document.getElementById('gio_ra').value;
            const trangThai = document.getElementById('trang_thai').value;

            if (!gioVao || !gioRa) {
                resetCalculation();
                return;
            }

            // Tính số giờ làm
            const timeIn = new Date(`2000-01-01T${gioVao}:00`);
            const timeOut = new Date(`2000-01-01T${gioRa}:00`);

            if (timeOut <= timeIn) {
                resetCalculation();
                return;
            }

            const diffMs = timeOut - timeIn;
            const diffHours = diffMs / (1000 * 60 * 60);
            const workHours = Math.max(0, diffHours - 1); // Trừ 1 giờ nghỉ trưa

            // Tính số công
            let soCong = 0;
            if (trangThai === 'binh_thuong') {
                soCong = 1;
            } else if (trangThai === 'di_muon' || trangThai === 've_som') {
                soCong = 0.5;
            } else if (trangThai === 'vang_mat') {
                soCong = 0;
            } else if (trangThai === 'nghi_phep') {
                soCong = 1;
            }

            // Cập nhật UI
            document.getElementById('calculated-hours').textContent = workHours.toFixed(1);
            document.getElementById('calculated-work').textContent = soCong.toFixed(1);
            document.getElementById('status-preview').textContent = getStatusText(trangThai);

            // Tự động điền vào form
            document.getElementById('so_gio_lam').value = workHours.toFixed(1);
            document.getElementById('so_cong').value = soCong.toFixed(1);

            // Tính phút đi muộn/về sớm
            calculateLateness();
        }

        function calculateLateness() {
            const gioVao = document.getElementById('gio_vao').value;
            const gioRa = document.getElementById('gio_ra').value;

            if (!gioVao || !gioRa) return;

            // Giờ chuẩn (có thể điều chỉnh theo quy định công ty)
            const gioVaoChuan = '08:30';
            const gioRaChuan = '17:30';

            // Tính phút đi muộn
            const timeIn = new Date(`2000-01-01T${gioVao}:00`);
            const timeInStandard = new Date(`2000-01-01T${gioVaoChuan}:00`);
            const lateMins = Math.max(0, (timeIn - timeInStandard) / (1000 * 60));

            // Tính phút về sớm
            const timeOut = new Date(`2000-01-01T${gioRa}:00`);
            const timeOutStandard = new Date(`2000-01-01T${gioRaChuan}:00`);
            const earlyMins = Math.max(0, (timeOutStandard - timeOut) / (1000 * 60));

            document.getElementById('phut_di_muon').value = Math.round(lateMins);
            document.getElementById('phut_ve_som').value = Math.round(earlyMins);
        }

        function resetCalculation() {
            document.getElementById('calculated-hours').textContent = '0.0';
            document.getElementById('calculated-work').textContent = '0.0';
            document.getElementById('status-preview').textContent = '-';
        }

        function getStatusText(status) {
            const statusMap = {
                'binh_thuong': 'Bình thường',
                'di_muon': 'Đi muộn',
                've_som': 'Về sớm',
                'vang_mat': 'Vắng mặt',
                'nghi_phep': 'Nghỉ phép'
            };
            return statusMap[status] || '-';
        }
    </script>
@endsection
