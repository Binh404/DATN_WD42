@extends('layoutsAdmin.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-0">Đơn đăng ký nghỉ phép</h2>
                    <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi nghỉ phép</p>
                </div>
                <div>
                    <a href="{{ url('/employee/so-du-nghi-phep') }}" style="text-decoration: none;">
                        <button class="btn btn-danger">
                            Số dư nghỉ phép
                        </button>
                    </a>
                </div>
            </div>
            <div class="home-tab">
                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                        <div class="row">
                            <div class="col-lg-12 d-flex flex-column">

                                <!-- Alert Messages -->
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center"
                                        role="alert">
                                        <i class="bi bi-check-circle-fill me-2"></i> {{-- Dùng Bootstrap Icons --}}
                                        <div>{{ session('success') }}</div>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                            aria-label="Đóng"></button>
                                    </div>
                                @endif

                                @if (session('error'))
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
                                                        <h4 class="card-title card-title-dash">Bảng đơn đăng ký nghỉ phép
                                                        </h4>
                                                        <p class="card-subtitle card-subtitle-dash" id="tongSoBanGhi">Bảng
                                                            có
                                                            bản ghi
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('nghiphep.create') }}"
                                                            class="btn btn-primary btn-lg mb-0 me-0 text-white"
                                                            type="button">
                                                            <i class="mdi mdi-plus-circle-outline me-1"></i> Tạo đơn nghỉ
                                                            phép
                                                        </a>

                                                    </div>
                                                </div>

                                                <div class="table-responsive  mt-1">
                                                    <table class="table table-hover align-middle text-nowrap">
                                                        <thead class="table-light">
                                                            <tr>

                                                                <th>Mã đơn</th>
                                                                <th>Ngày tạo</th>
                                                                <th>Từ ngày</th>
                                                                <th>Đến ngày</th>
                                                                <th>Lý do</th>
                                                                <th>Trạng thái</th>
                                                                <th>Thao tác</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($donXinNghis as $key => $item)
                                                                <tr>
                                                                    <td class="text-muted">{{ $item->ma_don_nghi }}</td>
                                                                    <td class="text-muted">
                                                                        {{ $item->created_at->format('d/m/Y') }}</td>
                                                                    <td class="text-muted">
                                                                        {{ $item->ngay_bat_dau->format('d/m/Y') }}</td>
                                                                    <td class="text-muted">
                                                                        {{ $item->ngay_ket_thuc->format('d/m/Y') }}</td>

                                                                    <td class="text-muted">{{ $item->ly_do }}</td>
                                                                    @php
                                                                        $classes = [
                                                                            'cho_duyet' => 'badge  bg-warning',
                                                                            'da_duyet' => 'badge bg-success',
                                                                            'tu_choi' => 'badge bg-danger',
                                                                            'huy_bo' => 'badge bg-secondary',
                                                                        ];

                                                                        $labels = [
                                                                            'cho_duyet' => 'Chờ duyệt',
                                                                            'da_duyet' => 'Đã duyệt',
                                                                            'tu_choi' => 'Từ chối',
                                                                            'huy_bo' => 'Hủy bỏ',
                                                                        ];

                                                                        $trangThai = $item->trang_thai;
                                                                    @endphp

                                                                    <td>
                                                                        <span
                                                                            class="{{ $classes[$trangThai] ?? 'bg bg-secondary' }} text-white">
                                                                            {{ $labels[$trangThai] ?? 'Không xác định' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('nghiphep.show', ['id' => $item->id]) }}"
                                                                            class="btn btn-info" title="Xem">
                                                                            <i class="mdi mdi-eye"></i>
                                                                        </a>
                                                                        <a href="{{ route('nghiphep.cancel', $item->id) }}"
                                                                            class="btn btn-danger" title="Xoá"
                                                                            onclick="return confirm('Bạn có chắc chắn muốn hủy đơn nghỉ phép này không?')">
                                                                            <i class="fas fa-times"></i>
                                                                        </a>


                                                                    </td>

                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="9" class="text-center py-5">
                                                                        <div class="text-muted">
                                                                            <i class="mdi mdi-inbox fs-1 mb-3"></i>
                                                                            <h5>Không có dữ liệu đơn xin nghỉ</h5>
                                                                            <p>Không tìm thấy bản ghi nào phù hợp với điều
                                                                                kiện
                                                                                tìm kiếm.</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                    <div class="pl-3 mt-3">
                                                        {{ $donXinNghis->links() }}
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
            </div>


        </div>
    </div>
@endsection
