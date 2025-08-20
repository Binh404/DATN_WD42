@extends('layoutsAdmin.master')
@section('title', 'Quy định công')

@section('content')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body bg-primary text-white rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="mb-1 fw-bold">
                                    <i class="fas fa-clipboard-list me-2"></i>
                                    Quy Định Công Ty
                                </h2>
                                <p class="mb-0 opacity-75">Nội quy và quy định làm việc</p>
                            </div>
                            <div class="text-end">

                                <button class="btn btn-outline-light btn-sm">
                                    <i class="fas fa-download me-1"></i>Xuất PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-md-3 col-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-primary mb-2">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        <h5 class="card-title text-muted">Giờ làm việc</h5>
                        <h3 class="text-primary mb-0">
                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $gioLamViec->gio_bat_dau)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $gioLamViec->gio_ket_thuc)->format('H:i') }}


                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-success mb-2">
                            <i class="fas fa-calendar-week fa-2x"></i>
                        </div>
                        <h5 class="card-title text-muted">Ngày làm việc</h5>
                        <h3 class="text-success mb-0">T2 - T6</h3>
                    </div>
                </div>
            </div>
            @php
                // Tính tổng giờ làm việc
                $batDau = \Carbon\Carbon::createFromFormat('H:i:s', $gioLamViec->gio_bat_dau);
                $ketThuc = \Carbon\Carbon::createFromFormat('H:i:s', $gioLamViec->gio_ket_thuc);
                $soGioLamViec = $batDau->diffInMinutes($ketThuc) / 60;
                $nghiBatDau = \Carbon\Carbon::createFromTimeString('12:00:00');
                $nghiKetThuc = $nghiBatDau->copy()->addHours((float) $gioLamViec->gio_nghi_trua);
            @endphp
            <div class="col-md-3 col-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-warning mb-2">
                            <i class="fas fa-coffee fa-2x"></i>
                        </div>
                        <h5 class="card-title text-muted">Giờ nghỉ trưa</h5>

                        <h3 class="text-warning mb-0">
                            @if ($soGioLamViec > 6)
                                {{ $nghiBatDau->format('H:i') }} - {{ $nghiKetThuc->format('H:i') }}

                            @else
                                không có giờ nghỉ trưa
                            @endif
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-info mb-2">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <h5 class="card-title text-muted">Tổng nhân viên</h5>
                        <h3 class="text-info mb-0">{{ $soNhanVien}}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Left Column - Rules List -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list-ul me-2 text-primary"></i>
                            Danh Sách Quy Định
                        </h5>
                    </div>
                    <div class="card-body p-0">


                        <!-- Rules Accordion -->
                        <div class="accordion accordion-flush" id="rulesAccordion">

                            {{-- Quy định giờ làm việc --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#rule1">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary me-3">01</span>
                                            <div>
                                                <strong>Quy định về giờ làm việc</strong>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="rule1" class="accordion-collapse collapse show" data-bs-parent="#rulesAccordion">
                                    <div class="accordion-body">
                                        <h6 class="text-primary">Thời gian làm việc:</h6>
                                         <ul class="list-unstyled ms-3 mb-3">
                                            <li class="mb-1">
                                                <i class="fas fa-clock text-success me-2"></i>
                                                <strong>Giờ vào:</strong> {{ \Carbon\Carbon::createFromFormat('H:i:s', $gioLamViec->gio_bat_dau)->format('H:i') }} h
                                            </li>
                                            <li class="mb-1">
                                                <i class="fas fa-clock text-danger me-2"></i>
                                                <strong>Giờ ra:</strong> {{ \Carbon\Carbon::createFromFormat('H:i:s', $gioLamViec->gio_ket_thuc)->format('H:i') }} h
                                            </li>
                                            <li class="mb-1">
                                                <i class="fas fa-coffee text-warning me-2"></i>
                                                <strong>Nghỉ trưa:</strong>
                                                @if ($soGioLamViec > 6)
                                                    {{ $nghiBatDau->format('H:i') }} - {{ $nghiKetThuc->format('H:i') }}
                                                @else
                                                    Không có giờ nghỉ trưa
                                                @endif
                                            </li>
                                        </ul>

                                        <h6 class="text-primary mt-3">Quy định chấm công:</h6>
                                        <p class="text-muted small mb-3">
                                            Đi muộn quá <strong>{{ $gioLamViec->so_phut_cho_phep_di_tre }} phút</strong> hoặc về sớm trước
                                            <strong>{{ $gioLamViec->so_phut_cho_phep_ve_som }} phút</strong> sẽ cần gửi lý do và chờ cấp trên duyệt
                                            mới được tính công.
                                        </p>

                                        <h6 class="text-primary mt-3">Quy định tính công:</h6>
                                         <ul class="list-unstyled ms-3">
                                            <li>- Làm đủ 8 giờ → <strong>1 công</strong></li>
                                            <li>- Làm trên 4 giờ → <strong>0.5 công</strong></li>
                                            <li>- Dưới 4 giờ → <strong>0 công</strong></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Quy định tăng ca --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#rule2">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success me-3">02</span>
                                            <div>
                                                <strong>Quy định về tăng ca</strong>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="rule2" class="accordion-collapse collapse" data-bs-parent="#rulesAccordion">
                                    <div class="accordion-body">
                                        <h6 class="text-success">Nguyên tắc đăng ký và duyệt:</h6>
                                        <ul class="list-unstyled ms-3">
                                            <li><i class="fas fa-check text-success me-2"></i>Phải <strong>gửi đơn đăng ký
                                                    tăng ca</strong> trước khi làm thêm.</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Chỉ được tăng ca sau khi
                                                <strong>quản lý phê duyệt</strong>.</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Ca tăng ca được công nhận khi
                                                <strong>làm đủ hoặc hơn số giờ đăng ký</strong>.</li>
                                            <li><i class="fas fa-times text-danger me-2"></i>Nếu làm <strong>ít hơn số giờ
                                                    đăng ký</strong> → <em>không hoàn thành</em> và chờ duyệt.</li>
                                        </ul>

                                        <h6 class="text-success mt-3">Cách tính số công:</h6>
                                        <ul class="list-unstyled ms-3">
                                            <li><i class="fas fa-calculator text-primary me-2"></i><strong>Số công = (Giờ ra
                                                    - Giờ vào) ÷ 8 × Hệ số tăng ca</strong></li>
                                            <li><i class="fas fa-check text-success me-2"></i>Nếu <strong>không hoàn
                                                    thành</strong>: tính theo giờ thực tế làm được.</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Nếu <strong>hoàn
                                                    thành</strong>: tính theo giờ đăng ký × hệ số tăng ca.</li>
                                        </ul>

                                        <h6 class="text-success mt-3">Ví dụ:</h6>
                                        <ul class="list-unstyled ms-3">
                                            <li>Đăng ký 4 giờ, hệ số 1.5:</li>
                                            <li class="ms-4">✔ Làm đủ 4h → 0.75 công</li>
                                            <li class="ms-4">✔ Làm 3h → 0.56 công</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Quy định trang phục --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#rule3">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-info me-3">03</span>
                                            <div>
                                                <strong>Quy định về trang phục</strong>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="rule3" class="accordion-collapse collapse" data-bs-parent="#rulesAccordion">
                                    <div class="accordion-body">
                                        <h6 class="text-info">Trang phục công sở:</h6>
                                        <ul class="list-unstyled ms-3">
                                            <li><i class="fas fa-check text-success me-2"></i>Áo sơ mi, quần âu lịch sự</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Giày dép phù hợp</li>
                                            <li><i class="fas fa-times text-danger me-2"></i>Không mặc quần short, dép tông
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Quy định nghỉ phép --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#rule4">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-warning me-3">04</span>
                                            <div>
                                                <strong>Quy định về nghỉ phép</strong>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="rule4" class="accordion-collapse collapse" data-bs-parent="#rulesAccordion">
                                    <div class="accordion-body">
                                        <h6 class="text-warning">Nghỉ phép năm:</h6>
                                        <ul class="list-unstyled ms-3">
                                            <li><i class="fas fa-calendar text-info me-2"></i>12 ngày phép/năm</li>
                                            <li><i class="fas fa-bell text-warning me-2"></i>Báo trước ít nhất 3 ngày</li>
                                            <li><i class="fas fa-file-alt text-primary me-2"></i>Gửi đơn xin phép và chờ
                                                duyệt</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <!-- Right Column - Quick Info -->
            <div class="col-lg-4 mb-4">


                <!-- Contact Info -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-phone me-2"></i>
                            Liên Hệ HR
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light rounded-circle p-1 me-3" style="width: 50px; height: 50px; overflow: hidden;">
                                <img src="{{ $thongTinHr->hoSo->anh_dai_dien ?? asset('images/default.png') }}"
                                    alt="Avatar"
                                    class="img-fluid rounded-circle"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div>
                                <small class="text-muted d-block">{{ $thongTinHr->phongBan->ten_phong_ban}}</small>
                                <strong>{{$thongTinHr->hoSo->ho .' ' . $thongTinHr->hoSo->ten}}</strong>
                            </div>
                        </div>
                        <div class="row g-2 text-sm">
                            <div class="col-12">
                                <i class="fas fa-phone text-success me-2"></i>
                                <small>{{ $thongTinHr->hoSo->so_dien_thoai }}</small>
                            </div>
                            <div class="col-12">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <small>{{ $thongTinHr->email }}</small>
                            </div>
                            <div class="col-12">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                <small>{{ $thongTinHr->hoSo->dia_chi_hien_tai}}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-bolt me-2"></i>
                            Thao Tác Nhanh
                        </h6>
                    </div>
                    <div class="card-body p-2">
                        <div class="d-grid gap-2">
                            <!-- Cả Admin và Nhân viên đều có thể tải -->
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-file-download me-2"></i>
                                Tải quy định công ty (PDF)
                            </button>

                            <!-- Nhân viên có thể hỏi đáp -->
                            <button class="btn btn-outline-success btn-sm">
                                <i class="fas fa-question-circle me-2"></i>
                                Hỏi đáp về quy định
                            </button>

                            <!-- Cả hai đều có thể xem lịch sử -->
                            <button class="btn btn-outline-info btn-sm">
                                <i class="fas fa-history me-2"></i>
                                Lịch sử cập nhật
                            </button>

                            <!-- Chỉ Nhân viên mới có nút này -->
                            @if(auth()->user()->role != 'admin')
                                <button class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-bookmark me-2"></i>
                                    Lưu quy định quan tâm
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <style>
        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .accordion-button:not(.collapsed) {
            background-color: #f8f9ff;
            border-color: #e3e6f0;
        }

        .badge {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .btn {
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }
    </style>
@endsection
