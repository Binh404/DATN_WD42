@extends('layoutsAdmin.master')

@section('title', 'Quản lý chấm công')

@section('style')
    <style>
        select.form-select option {
            color: #000;
        }
    </style>
@endsection
@section('content')
    <!-- partial -->
    <div class="row">
        <div class="col-sm-12">
                {{-- <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-0">Quản lý chấm công</h2>
                        <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi chấm công</p>
                    </div>

                </div> --}}
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    {{-- <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab"
                                aria-controls="overview" aria-selected="true">Chấm Công</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#audiences" role="tab"
                               aria-controls="audiences" aria-selected="false">Phê duyệt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#demographics" role="tab"
                                aria-selected="false">Demographics</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link border-0" id="more-tab" data-bs-toggle="tab" href="#more" role="tab"
                                aria-selected="false">More</a>
                        </li>
                    </ul> --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">Quản lý thời gian làm việc</h2>
                            <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi thời gian làm việc</p>
                        </div>

                    </div>

                    {{-- <div>
                        <div class="btn-wrapper">
                            <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i>
                                Share</a>
                            <a href="#" class="btn btn-otline-dark" onclick="window.print()"><i class="icon-printer"></i> Print</a>
                            <a href="#" class="btn btn-primary text-white me-0" data-bs-toggle="modal"
                                data-bs-target="#reportModal"><i class="icon-download"></i>
                                Báo cáo</a>
                        </div>
                    </div> --}}
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
                                                        <h4 class="card-title card-title-dash">Quản lý thời gian </h4>

                                                    </div>
                                                    {{-- <div>
                                                        <button class="btn btn-primary btn-lg text-white mb-0 me-0"
                                                            type="button"><i class="mdi mdi-account-plus"></i>Add
                                                            new member</button>
                                                    </div> --}}
                                                </div>

                                                <div class="table-responsive  mt-1">
                                                    <table class="table table-hover align-middle">
                                                        <thead>
                                                            <tr>

                                                                <th>Giờ vào</th>
                                                                <th>Giờ ra</th>
                                                                <th>Giờ nghỉ trưa</th>
                                                                <th>Số phút đi trễ</th>
                                                                <th>Số phút về sớm</th>
                                                                <th>Thời gian thay đổi</th>
                                                                <th>Thao tác</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($gioLamViec as $gio)
                                                                <tr>
                                                                    <td >{{ $gio->gio_bat_dau }} giờ</td>
                                                                    <td >{{ $gio->gio_ket_thuc }} giờ</td>
                                                                    <td >{{ $gio->gio_nghi_trua }} giờ</td>
                                                                    <td >{{ $gio->so_phut_cho_phep_di_tre }} phút</td>
                                                                    <td >{{ $gio->so_phut_cho_phep_ve_som }} phút</td>
                                                                    <td>{{ $gio->updated_at->format('d/m/Y H:i') }}</td>
                                                                    <td>
                                                                        <div class="btn-group" role="group">                                                                  <div class="btn-group" role="group">
                                                                            <a href="{{ route('admin.giolamviec.edit') }}"
                                                                                title="Chỉnh sửa">
                                                                                <button class="btn btn-warning btn-sm"><i class="mdi mdi-pencil"></i></button>
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                <td colspan="9" class="text-center py-5">
                                                                    <div class="text-center py-4">
                                                                        <p class="text-muted mb-4">Chưa có giờ công ty nào được thêm.</p>
                                                                        {{-- <a href="{{ route('admin.locations.create') }}" class="btn btn-primary btn-lg text-white mb-0 me-0">
                                                                            <i class="mdi mdi-plus-circle-outline me-2"></i> Thêm địa chỉ đầu tiên
                                                                        </a> --}}
                                                                    </div>
                                                                </td>

                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
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


