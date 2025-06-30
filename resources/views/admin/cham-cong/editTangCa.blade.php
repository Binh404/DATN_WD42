@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Header Section -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="mb-0"><i class="fas fa-edit"></i> Chỉnh Sửa Chấm Công Tăng Ca</h1>
                        <p class="mb-0">Cập nhật thông tin chấm công tăng ca nhân viên</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.chamcong.danhSachTangCa') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> Vui lòng kiểm tra lại thông tin:
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Edit Form -->
        <form method="POST" action="{{route('admin.chamcong.updateTangCa', $thucHienTangCa->id)}}">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Thông tin nhân viên -->
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-user"></i> Thông tin chấm công</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Nhân viên -->
                                <div class="col-md-6 mb-3">
                                    <label for="nguoi_dung_id" class="form-label">Nhân viên <span class="text-danger">*</span></label>

                                    <!-- Hiển thị tên nhân viên (chỉ đọc) -->
                                    <input type="text" class="form-control"
                                        value="{{ $thucHienTangCa->dangKyTangCa->nguoiDung->hoSo->ho ?? '' }} {{ $thucHienTangCa->dangKyTangCa->nguoiDung->hoSo->ten ?? '' }}"
                                        readonly>

                                    <!-- input hidden giữ giá trị id để gửi lên server -->
                                    <input type="hidden" name="nguoi_dung_id" value="{{ $thucHienTangCa->dangKyTangCa->nguoi_dung_id }}">

                                    @error('nguoi_dung_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- <!-- Ngày chấm công -->
                                <div class="col-md-6 mb-3">
                                    <label for="ngay_cham_cong" class="form-label">Ngày chấm công <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('ngay_cham_cong') is-invalid @enderror"
                                           id="ngay_cham_cong" name="ngay_cham_cong"
                                           value="{{ old('ngay_cham_cong', $thucHienTangCa->dangKyTangCa->ngay_tang_ca->format('Y-m-d')) }}" required>
                                    @error('ngay_cham_cong')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                                <!-- Trạng thái -->
                                <div class="col-md-6 mb-3">
                                    <label for="trang_thai" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                    <select class="form-select @error('trang_thai') is-invalid @enderror"
                                            id="trang_thai" name="trang_thai" required>
                                        @foreach($trangThaiList as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ old('trang_thai', $thucHienTangCa->trang_thai) == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('trang_thai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Giờ vào -->
                                <div class="col-md-6 mb-3">
                                    <label for="gio_vao" class="form-label">Giờ vào <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('gio_vao') is-invalid @enderror"
                                           id="gio_vao" name="gio_vao"
                                           {{-- value="{{ old('gio_vao', ($thucHienTangCa->gio_bat_dau_thuc_te)) }}"> --}}
                                           value="{{ old('gio_vao', optional($thucHienTangCa->gio_bat_dau_thuc_te ? \Carbon\Carbon::parse($thucHienTangCa->gio_bat_dau_thuc_te) : null)->format('H:i')) }}">

                                    @error('gio_vao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Giờ vào làm tăng ca</small>
                                </div>

                                <!-- Giờ ra -->
                                <div class="col-md-6 mb-3">
                                    <label for="gio_ra" class="form-label">Giờ ra</label>
                                    <input type="time" class="form-control @error('gio_ra') is-invalid @enderror"
                                           id="gio_ra" name="gio_ra"
                                           {{-- value="{{ old('gio_ra', $thucHienTangCa->gio_bat_dau_thuc_te ? $thucHienTangCa->gio_ket_thuc_thuc_te : '') }}"> --}}
                                           value="{{ old('gio_vao', optional($thucHienTangCa->gio_ket_thuc_thuc_te ? \Carbon\Carbon::parse($thucHienTangCa->gio_ket_thuc_thuc_te) : null)->format('H:i')) }}">

                                    @error('gio_ra')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Giờ tan làm tăng ca</small>
                                </div>



                                <!-- Trạng thái phê duyệt -->


                                <!-- Ghi chú -->
                                <div class="col-12 mb-3">
                                    <label for="ghi_chu" class="form-label">Ghi chú</label>
                                    <textarea class="form-control @error('ghi_chu') is-invalid @enderror"
                                              id="ghi_chu" name="ghi_chu" rows="3"
                                              placeholder="Nhập ghi chú (tùy chọn)">{{ old('ghi_chu', $thucHienTangCa->ghi_chu) }}</textarea>
                                    @error('ghi_chu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Thông tin chi tiết -->
                <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Thông tin chi tiết</h5>
                            </div>
                            <div class="card-body">
                                <!-- Thông tin nhân viên hiện tại -->
                                <div class="mb-3 p-3 bg-light rounded">
                                    <h6 class="mb-2"><i class="fas fa-user"></i> Nhân viên hiện tại</h6>
                                    <div><strong>Tên:</strong> {{ $thucHienTangCa->dangKyTangCa->nguoiDung->hoSo->ho ?? 'N/A' }} {{ $thucHienTangCa->dangKyTangCa->nguoiDung->hoSo->ten ?? 'N/A' }}</div>
                                    <div><strong>Email:</strong> {{ $thucHienTangCa->dangKyTangCa->nguoiDung->email }}</div>
                                    <div><strong>Phòng ban:</strong> {{ $thucHienTangCa->dangKyTangCa->nguoiDung->phongBan->ten_phong_ban ?? 'N/A' }}</div>
                                </div>

                                <!-- Thông tin tính toán -->
                                <div class="mb-3 p-3 bg-light rounded">
                                    <h6 class="mb-2"><i class="fas fa-calculator"></i> Thông tin tính toán</h6>
                                    <div><strong>Số giờ làm:</strong> <span id="soGioLam">{{ number_format($thucHienTangCa->so_gio_tang_ca_thuc_te, 1) }}h</span></div>
                                    <div><strong>Số công:</strong> <span id="soCong">{{ number_format($thucHienTangCa->so_cong_tang_ca, 1) }}</span></div>
                                    {{-- <div><strong>Phút đi muộn:</strong> <span id="phutDiMuon">{{ $chamCong->phut_di_muon ?? 0 }}p</span></div>
                                    <div><strong>Phút về sớm:</strong> <span id="phutVeSom">{{ $chamCong->phut_ve_som ?? 0 }}p</span></div> --}}
                                </div>

                                <!-- Thông tin audit -->
                                <div class="mb-3 p-3 bg-light rounded">
                                    <h6 class="mb-2"><i class="fas fa-history"></i> Thông tin cập nhật</h6>
                                    <div><strong>Tạo lúc:</strong> {{ $thucHienTangCa->created_at->format('d/m/Y H:i') }}</div>
                                    <div><strong>Cập nhật:</strong> {{ $thucHienTangCa->updated_at->format('d/m/Y H:i') }}</div>
                                </div>

                                <!-- Hướng dẫn -->
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-lightbulb"></i> Lưu ý:</h6>
                                    <ul class="mb-0 small">
                                        <li>Phải làm đủ giời mới được là hoàn thành</li>
                                        <li>Số công được tính dựa trên số giờ làm thực tế</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> Làm mới
                            </button>
                        </div>
                        <div>
                            <a href="{{ route('admin.chamcong.danhSachTangCa') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Hủy
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection

@push('styles')
<style>
    .form-label {
        font-weight: 600;
        color: #495057;
    }
    .text-danger {
        color: #dc3545 !important;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
    .alert-info {
        background-color: #d1ecf1;
        border-color: #bee5eb;
        color: #0c5460;
    }
    .card-header h5 {
        color: #495057;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        if (!alert.classList.contains('alert-info')) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 10000);
        }
    });

    // Tính toán lại khi thay đổi giờ vào/ra
    const gioVaoInput = document.getElementById('gio_vao');
    const gioRaInput = document.getElementById('gio_ra');
    const trangThaiSelect = document.getElementById('trang_thai');

    function tinhToanLaiGio() {
        const gioVao = gioVaoInput.value;
        const gioRa = gioRaInput.value;

        if (gioVao && gioRa) {
            // Tính số giờ làm
            const [gioVaoH, gioVaoM] = gioVao.split(':').map(Number);
            const [gioRaH, gioRaM] = gioRa.split(':').map(Number);

            const phutVao = gioVaoH * 60 + gioVaoM;
            const phutRa = gioRaH * 60 + gioRaM;

            let soPhutLam = phutRa - phutVao;
            if (soPhutLam > 0) {
                // Trừ giờ nghỉ trưa (1 tiếng = 60 phút)
                if (soPhutLam > 240) { // Làm hơn 4 tiếng thì có giờ nghỉ trưa
                    soPhutLam -= 60;
                }

                const soGioLam = soPhutLam / 60;
                document.getElementById('soGioLam').textContent = soGioLam.toFixed(1) + 'h';

                // Tính số công (8 tiếng = 1 công)
                const soCong = soGioLam / 8;
                document.getElementById('soCong').textContent = soCong.toFixed(1);
            }

            // Tính phút đi muộn (so với 8:00)
            const phutDiMuon = Math.max(0, phutVao - (8 * 60));
            document.getElementById('phutDiMuon').textContent = phutDiMuon + 'p';

            // Tính phút về sớm (so với 17:00)
            const phutVeSom = Math.max(0, (17 * 60) - phutRa);
            document.getElementById('phutVeSom').textContent = phutVeSom + 'p';

            // Tự động set trạng thái
            if (phutDiMuon > 0) {
                trangThaiSelect.value = 'di_muon';
            } else if (phutVeSom > 0) {
                trangThaiSelect.value = 've_som';
            } else {
                trangThaiSelect.value = 'binh_thuong';
            }
        }
    }

    gioVaoInput.addEventListener('change', tinhToanLaiGio);
    gioRaInput.addEventListener('change', tinhToanLaiGio);

    // Hiển thị phòng ban khi chọn nhân viên
    const nguoiDungSelect = document.getElementById('nguoi_dung_id');
    nguoiDungSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const phongBan = selectedOption.getAttribute('data-phong-ban');
        if (phongBan) {
            // Có thể hiển thị phòng ban ở đâu đó nếu cần
            console.log('Phòng ban:', phongBan);
        }
    });
});
</script>
@endpush
