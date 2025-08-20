@extends('layoutsAdmin.master')
@section('title', 'Danh sách nhân sự')

@section('content')
    {{-- <div class="container-fluid px-4"> --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="fw-bold mb-1">Quản lý danh sách nhân sự</h2>
                                <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi nhân sự</p>
                            </div>

                        </div>

                        <div>
                            <div class="btn-wrapper">
                                {{-- <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i>
                                    Share</a>
                                <a href="#" class="btn btn-otline-dark" onclick="window.print()"><i
                                        class="icon-printer"></i> Print</a>
                                <a href="#" class="btn btn-primary text-white me-0" data-bs-toggle="modal"
                                    data-bs-target="#reportModal"><i class="icon-download"></i>
                                    Báo cáo</a> --}}
                                <a href="{{ route('hoso.resigned') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="mdi mdi-account me-1"></i> Xem danh sách đã nghỉ
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content tab-content-basic">

                        <div class="row">
                            <div class="col-lg-12 grid-margin stretch-card mt-4">
                                <div class="card">
                                    <div
                                        class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0"><i class="mdi mdi-magnify me-2"></i> Tìm kiếm</h5>
                                    </div>
                                    <div class="card-body">

                                        <form method="GET" action="{{ route('hoso.all') }}">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <!-- Tên nhân viên -->
                                                        <div class="col-md-8 mb-3">
                                                            <label for="search" class="form-label">Tìm theo
                                                                tên, họ</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="mdi mdi-account-search"></i></span>
                                                                <input type="text" name="search" id="searchInput"
                                                                    class="form-control form-control-sm"
                                                                    placeholder="Tìm họ, tên, email ..."
                                                                    value="{{ request('search') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <div class="d-flex gap-2 mt-4">
                                                                <button type="submit" class="btn btn-primary btn-sm py-2">
                                                                    <i class="mdi mdi-magnify me-1"></i> Tìm kiếm
                                                                </button>
                                                                <a href="{{ route('hoso.all') }}"
                                                                    class="btn btn-secondary btn-sm py-2">
                                                                    <i class="mdi mdi-refresh me-1"></i> Làm mới
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>
            <div class="row">
                            <div class="col-lg-12 d-flex flex-column">

                                <!-- Alert Messages -->
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center"
                                        role="alert">
                                        <i class="bi bi-check-circle-fill me-2"></i> {{-- Dùng Bootstrap Icons --}}
                                        <div>{{ session('success') }}</div>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                            aria-label="Đóng"></button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center"
                                        role="alert">
                                        <i class="bi bi-exclamation-circle-fill me-2"></i> {{-- Dùng Bootstrap Icons --}}
                                        <div>{{ session('error') }}</div>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                            aria-label="Đóng"></button>
                                    </div>
                                @endif
                            </div>
            </div>
                        <div class="row">

                            <div class="col-lg-12 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="d-sm-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h4 class="card-title card-title-dash">Bảng hồ sơ nhân viên</h4>
                                                        <p class="card-subtitle card-subtitle-dash" id="tongSoBanGhi">Bảng
                                                            có
                                                            <span id="totalRecords">{{ $nguoiDungs->total() }}</span> bản ghi
                                                        </p>
                                                    </div>
                                                    {{-- <div>
                                                        <button class="btn btn-primary btn-lg text-white mb-0 me-0"
                                                            type="button"><i class="mdi mdi-account-plus"></i>Add
                                                            new member</button>
                                                    </div> --}}
                                                </div>

                                                <div class="table-responsive  mt-1">
                                                    <table class="table table-hover align-middle text-nowrap">
                                                        <thead class="table-light">
                                                            <tr>

                                                                <th>NGƯỜI DÙNG</th>
                                                                <th>NGÀY SINH</th>
                                                                <th>GIỚ TÍNH</th>
                                                                <th>ĐỊA CHỈ</th>
                                                                <th>THAO TÁC</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($nguoiDungs as $index => $cc)
                                                                @php
                                                                    $ngaySinh = optional($cc->hoSo)->ngay_sinh;
                                                                @endphp
                                                                <tr>

                                                                    <td>
                                                                        <div class="d-flex align-items-center gap-3">
                                                                            @if(!empty($cc->hoSo->anh_dai_dien))
                                                                                <img src="{{ asset($cc->hoSo->anh_dai_dien) }}"
                                                                                    alt="Avatar"
                                                                                    class="rounded-circle border border-2 border-primary"
                                                                                    width="50" height="50"
                                                                                    onerror="this.onerror=null; this.src='{{ asset('assets/images/default.png') }}';">
                                                                            @else
                                                                                <span class="text-muted fst-italic">Không có</span>
                                                                            @endif


                                                                            <div>
                                                                                <h6 class="mb-1 fw-semibold">
                                                                                    {{ $cc->hoSo->ho ?? 'Chưa cập nhật' }}
                                                                                    {{ $cc->hoSo->ten ?? '' }}
                                                                                </h6>
                                                                                <div class="small text-muted">
                                                                                    <div><i class="mdi mdi-account me-1"></i> Mã
                                                                                        NV:
                                                                                        {{ $cc->hoSo->ma_nhan_vien ?? 'Chưa cập nhật' }}
                                                                                    </div>
                                                                                    <div><i
                                                                                            class="mdi mdi-office-building me-1"></i>
                                                                                        Phòng:
                                                                                        {{ $cc->phongBan->ten_phong_ban ?? 'Chưa cập nhật' }}
                                                                                    </div>
                                                                                    <div><i class="mdi mdi-email me-1"></i>
                                                                                        Email: {{ $cc->email }}</div>

                                                                                    @if(isset($cc->percent))
                                                                                        @php
                                                                                            $percent = $cc->percent;
                                                                                            $barColor = 'bg-success'; // xanh lá

                                                                                            if ($percent < 50) {
                                                                                                $barColor = 'bg-danger'; // đỏ
                                                                                            } elseif ($percent < 80) {
                                                                                                $barColor = 'bg-warning'; // cam
                                                                                            }
                                                                                        @endphp
                                                                                        <div class="mt-1" data-bs-toggle="tooltip" data-bs-html="true"
                                                                                            title="
                                                                                            @if(isset($cc->missingFields) && count($cc->missingFields) > 0)
                                                                                                Thiếu:<br>
                                                                                                @foreach($cc->missingFields as $field)
                                                                                                    - {{ $field }}&#10; <br>
                                                                                                @endforeach
                                                                                            @else
                                                                                                Đã hoàn thiện hồ sơ!
                                                                                            @endif
                                                                                            ">
                                                                                            <small class="text-muted">Hoàn thành hồ sơ: {{ $percent }}%</small>
                                                                                            <div class="progress" style="height: 5px; max-width: 150px;">
                                                                                                <div class="progress-bar {{ $barColor }}" role="progressbar"
                                                                                                    style="width: {{ $percent }}%" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-muted">
                                                                        {{ $ngaySinh ? \Carbon\Carbon::parse($ngaySinh)->format('d/m/Y') : 'Chưa cập nhật' }}
                                                                    </td>
                                                                    <td class="text-muted">
                                                                        @if(!empty($cc->hoSo->ngay_sinh))
                                                                            @if($cc->hoSo->gioi_tinh == 'nam')
                                                                                Nam
                                                                            @elseif($cc->hoSo->gioi_tinh == 'nu')
                                                                                Nữ
                                                                            @else
                                                                                Khác
                                                                            @endif
                                                                        @else
                                                                            Chưa cập nhật
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-muted">
                                                                        @if(!empty($cc->hoSo->dia_chi_thuong_tru))
                                                                            {{ $cc->hoSo->dia_chi_thuong_tru }}
                                                                        @else
                                                                            Chưa cập nhật
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if(isset($cc->hoSo->id))
                                                                            <a href="{{ route('hoso.edit', $cc->hoSo->id) }}"
                                                                                class="btn btn-sm btn-warning me-1">
                                                                                <i class="mdi mdi-pencil"></i>
                                                                            </a>
                                                                            <form
                                                                                action="{{ route('hoso.markResigned', $cc->hoSo->id) }}"
                                                                                method="POST" style="display: inline;">
                                                                                @csrf
                                                                                @method('PATCH')
                                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                                    onclick="return confirm('Bạn có chắc muốn đánh dấu nhân viên này là đã nghỉ?')">
                                                                                    <i class="mdi mdi-account-off"></i>
                                                                                </button>
                                                                            </form>

                                                                        @if($cc->percent < 100)
                                                                            <form action="{{ route('admin.hoso.remind', $cc->hoSo->id) }}" method="POST" style="display:inline;">
                                                                                @csrf
                                                                                <button class="btn btn-warning btn-sm" onclick="return confirm('Gửi nhắc nhở tới nhân viên này?')">
                                                                                    Gửi nhắc nhở
                                                                                </button>
                                                                            </form>
                                                                        @endif                                                                       
                                                                        @else
                                                                            <span class="text-muted fst-italic">Chưa có hồ sơ</span>
                                                                        @endif
                                                                    </td>

                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="5" class="text-center py-5">
                                                                        <div class="text-muted">
                                                                            <i class="mdi mdi-inbox fs-1 mb-3"></i>
                                                                            <h5>Không có dữ liệu chấm công</h5>
                                                                            <p>Không tìm thấy bản ghi nào phù hợp với điều kiện
                                                                                tìm kiếm.</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @if($nguoiDungs->hasPages())
                                                <div class="card-footer bg-white border-top">
                                                    <div
                                                        class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                        <small class="text-muted">
                                                            Hiển thị {{ $nguoiDungs->firstItem() }} đến
                                                            {{ $nguoiDungs->lastItem() }} trong tổng số
                                                            {{ $nguoiDungs->total() }}
                                                            bản ghi
                                                        </small>
                                                        <nav>
                                                            {{ $nguoiDungs->links('pagination::bootstrap-5') }}
                                                        </nav>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    {{-- </div> --}}

    {{-- SCRIPT TÌM KIẾM --}}
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });

</script>

@endsection
