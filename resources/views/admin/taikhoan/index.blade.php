@extends('layoutsAdmin.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">
                    <div class="d-sm-flex align-items-center justify-content-between border-bottom">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="fw-bold mb-1">Danh sách tài khoản người dùng</h2>
                                <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi tài khoản</p>
                            </div>

                        </div>

                        <div>
                            <div class="btn-wrapper">
                                {{-- <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i>
                                    Share</a> --}}
                                {{-- <a href="#" class="btn btn-otline-dark" onclick="window.print()"><i class="icon-printer"></i> Print</a>
                                <a href="#" class="btn btn-primary text-white me-0" data-bs-toggle="modal"
                                    data-bs-target="#reportModal"><i class="icon-download"></i>
                                    Báo cáo</a> --}}

                            </div>
                        </div>
                    </div>
                    <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">

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
                                                        <h4 class="card-title card-title-dash">Bảng tài khoản người dùng</h4>
                                                        <p class="card-subtitle card-subtitle-dash" id="tongSoBanGhi">Bảng
                                                            có {{ $taikhoan->total() }}
                                                            bản ghi
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <a class="btn btn-primary btn-lg text-white mb-0 me-0" href="{{route('register')}}"
                                                            type="button"><i class="mdi mdi-account-plus"></i>Tạo tài khoản</a>
                                                    </div>
                                                </div>

                                                <div class="table-responsive  mt-1">
                                                    <table class="table table-hover align-middle text-nowrap">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Người dùng</th>
                                                                <th>Tên đăng nhập</th>
                                                                <th>Email</th>
                                                                <th>Trạng thái</th>
                                                                <th>Lần đăng nhập cuối</th>
                                                                {{-- <th>IP đăng nhập cuối</th> --}}
                                                                <th>Phòng ban</th>
                                                                <th>Chức vụ</th>
                                                                <th>Hành động</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @forelse($taikhoan as $item)
                                                                @php
                                                                // dd($cc);
                                                                $hoSo = $item->hoSo ?? null;
                                                                    $avatar = $hoSo && $hoSo->anh_dai_dien
                                                                        ? asset($hoSo->anh_dai_dien)
                                                                        : asset('assets/images/default.png');
                                                                    // $avatar = $cc->nguoiDung->hoSo->anh_dai_dien
                                                                    //     ? asset($cc->nguoiDung->hoSo->anh_dai_dien)
                                                                    //     : asset('assets/images/default.png'); // Đặt ảnh mặc định trong public/images/
                                                                @endphp
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-flex align-items-center gap-3">
                                                                            <img src="{{ $avatar }}" alt="Avatar"
                                                                                class="rounded-circle border border-2 border-primary"
                                                                                width="50" height="50"
                                                                                onerror="this.onerror=null; this.src='{{ asset('assets/images/default.png') }}';">

                                                                            <div>
                                                                                <h6 class="mb-1 fw-semibold">
                                                                                    {{ $item->hoSo->ho ?? 'N/A' }}
                                                                                    {{ $item->hoSo->ten ?? 'N/A' }}
                                                                                </h6>
                                                                                <div class="small text-muted">
                                                                                    <div><i class="mdi mdi-account me-1"></i> Mã
                                                                                        NV:
                                                                                        {{ $item->hoSo->ma_nhan_vien ?? 'N/A' }}
                                                                                    </div>
                                                                                    <div><i
                                                                                            class="mdi mdi-office-building me-1"></i>
                                                                                        Phòng:
                                                                                        {{ $item->phongBan->ten_phong_ban ?? 'N/A' }}
                                                                                    </div>
                                                                                    <div><i class="mdi mdi-account-badge me-1"></i>
                                                                                        Vai trò: {{ $item->vaiTro->ten_hien_thi }}</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ $item->ten_dang_nhap }}</td>
                                                                    <td>{{ $item->email }}</td>


                                                                    <td >
                                                                        <span class="text-white {{ $item->trang_thai == 1 ? 'bg-success' : 'bg-danger' }} px-2 py-1 rounded">
                                                                             {{ $item->trang_thai == 1 ? 'Hoạt động' : 'Ngưng hoạt động' }}
                                                                        </span>

                                                                    </td>
                                                                    <td>{{ $item->lan_dang_nhap_cuoi }}</td>
                                                                    {{-- <td>{{ $item->ip_dang_nhap_cuoi }}</td> --}}
                                                                    <td>{{ $item->PhongBan->ten_phong_ban }}</td>
                                                                    <td>{{ $item->chucVu->ten }}</td>
                                                                    <td>
                                                                        <a href="{{ route('tkedit', $item->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="10" class="text-center py-5">
                                                                        <div class="text-muted">
                                                                            <i class="mdi mdi-inbox fs-1 mb-3"></i>
                                                                            <h5>Không có dữ liệu người dùng</h5>
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
                                            @if($taikhoan->hasPages())
                                                <div class="card-footer bg-white border-top">
                                                    <div
                                                        class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                        <small class="text-muted">
                                                            Hiển thị {{ $taikhoan->firstItem() }} đến
                                                            {{ $taikhoan->lastItem() }} trong tổng số {{ $taikhoan->total() }}
                                                            bản ghi
                                                        </small>
                                                        <nav>
                                                            {{ $taikhoan->links('pagination::bootstrap-5') }}
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
    </div>

@endsection
