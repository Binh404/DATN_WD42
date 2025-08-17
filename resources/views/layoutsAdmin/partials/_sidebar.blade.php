<?php
// resources/views/layouts/sidebar.blade.php

?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        {{-- Dashboard - Tất cả role đều có quyền --}}
        @if(MenuHelper::hasMenuPermission('dashboard'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="mdi mdi-view-dashboard-outline menu-icon"></i>
                <span class="menu-title">Thống kê</span>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('chat.index') }}">
                <i class="mdi mdi-message-text-outline menu-icon"></i>
                <span class="menu-title">Nhắn tin</span>
            </a>
        </li> --}}
        @endif

        {{-- Hồ sơ - Tất cả role đều có quyền --}}
        <li class="nav-item nav-category">Các chức năng</li>


        @if(MenuHelper::hasMenuPermission('hoso'))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-hoso" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-clipboard-account-outline"></i>
                <span class="menu-title">Nhân sự</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-hoso">
                <ul class="nav flex-column sub-menu">
                    @if(MenuHelper::hasSubMenuPermission('hoso', 'qlhoso'))
                    <li class="nav-item">
                        <a class="nav-link" href="/hoso/admin/hoso">Hồ sơ</a>
                    </li>
                    @endif

                    @if(MenuHelper::hasSubMenuPermission('hoso', 'qltk'))

                    <li class="nav-item"> <a class="nav-link" href="{{route('tkall')}}">Tài khoản</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{route('chucvu.index')}}">
                           Chức vụ
                        </a>
                    </li>
                    @endif
                    @if(MenuHelper::hasSubMenuPermission('hoso', 'hosocn'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employee.profile.show') }}">Hồ sơ cá nhân</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('vaitro.index')}}">
                           Vai trò
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('phongban.index') }}">
                           Phòng ban
                        </a>
                    </li>
                </ul>

            </div>

        </li>
        @endif

        {{-- Phòng ban - Chỉ admin, hr có quyền --}}
        {{-- @if(MenuHelper::hasMenuPermission('phongban'))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi mdi-office-building-outline"></i>
                <span class="menu-title">Phòng ban</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('phongban.index') }}">Danh sách phòng ban</a>
                    </li>
                </ul>
            </div>
        </li>
        @endif --}}

        @if(MenuHelper::hasMenuPermission('thongbaotuyendung'))
        <li class="nav-item">
            <a class="nav-link" href="{{route('hr.captrenthongbao.tuyendung.index')}}" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi mdi-office-building-outline"></i>
                <span class="menu-title">Thông báo tuyển dụng</span>
                <i class="menu-arrow"></i>
            </a>

        </li>
        @endif

        {{-- Lương - Chỉ admin có quyền --}}
        @if(MenuHelper::hasMenuPermission('luong'))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                <i class="menu-icon mdi mdi-chart-line"></i>
                <span class="menu-title">Lương</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    {{-- <li class="nav-item"> <a class="nav-link" href="{{route("luong.create")}}">Tính lương</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route("luong.index")}}">Bảng lương</a></li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('luong.list') }}">Danh sách</a>
                    </li>
                    @if(MenuHelper::hasSubMenuPermission('luong', 'luong'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('luong.create') }}">Tính lương</a>
                    </li>
                    @endif
                    @if(MenuHelper::hasSubMenuPermission('luong', 'phieuluong'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('luong.index') }}">Bảng lương</a>
                    </li>
                    @endif
                    @if(MenuHelper::hasSubMenuPermission('luong', 'phieuluongnv'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('danh-sach-luong') }}">Bảng lương</a>
                    </li>
                    @endif

                </ul>
            </div>
        </li>
        @endif

        {{-- Chấm công - admin, department, employee có quyền --}}
        @if(MenuHelper::hasMenuPermission('chamcong'))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="menu-icon mdi mdi-clock-outline"></i>
                <span class="menu-title">Chấm công</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    @if(MenuHelper::hasSubMenuPermission('chamcong', 'chamcong'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cham-cong.index') }}">Chấm công</a>
                    </li>
                    @endif
                    @if(MenuHelper::hasSubMenuPermission('chamcong', 'donxintangca'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cham-cong.tao-don-xin-tang-ca') }}">Đơn xin tăng ca</a>
                    </li>
                    @endif
                    @if(MenuHelper::hasSubMenuPermission('chamcong', 'danhsach'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.chamcong.index') }}">Danh sách chấm công</a>
                    </li>
                    @endif

                    @if(MenuHelper::hasSubMenuPermission('chamcong', 'pheduyet'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.chamcong.xemPheDuyetTangCa') }}">Phê duyệt tăng ca</a>
                    </li>
                    @endif

                    @if(MenuHelper::hasSubMenuPermission('chamcong', 'tangca'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.chamcong.tangCa.index') }}">Danh sách tăng ca</a>
                    </li>
                    @endif
                    @if(MenuHelper::hasSubMenuPermission('chamcong', 'importcc'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('chamcong.import.form') }}">Import chấm công</a>
                    </li>
                    @endif
                     @if(MenuHelper::hasSubMenuPermission('chamcong', 'vitri'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.locations.index') }}">Quản lý vị trí</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.giolamviec.index') }}">Quản lý thời gian</a>
                    </li>
                    @endif


                </ul>
            </div>
        </li>
        @endif

        {{-- Ứng viên - admin, hr có quyền --}}
        @if(MenuHelper::hasMenuPermission('ungvien'))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#uv" aria-expanded="false" aria-controls="uv">
                <i class="menu-icon mdi mdi-account-multiple"></i>
                <span class="menu-title">Ứng viên</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="uv">
                <ul class="nav flex-column sub-menu">
                    @if(MenuHelper::hasSubMenuPermission('ungvien', 'danhsach'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ungvien.index') }}">Ứng viên</a>
                    </li>
                    @endif

                    @if(MenuHelper::hasSubMenuPermission('ungvien', 'phongvan'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ungvien.phong-van') }}">Gửi email phỏng vấn</a>
                    </li>
                    @endif

                    @if(MenuHelper::hasSubMenuPermission('ungvien', 'emaildagui'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ungvien.emaildagui') }}">Danh sách email đã gửi</a>
                    </li>
                    @endif

                    @if(MenuHelper::hasSubMenuPermission('ungvien', 'trungtuyen'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ungvien.trung-tuyen') }}">Trúng tuyển</a>
                    </li>
                    @endif

                    @if(MenuHelper::hasSubMenuPermission('ungvien', 'luutru'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ungvien.luu-tru') }}">Lưu trữ</a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
        @endif

        {{-- Hợp đồng của tôi - Tất cả role đều có quyền --}}
        @if(MenuHelper::hasMenuPermission('hopdong'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('hopdong.cua-toi') }}">
                <i class="menu-icon mdi mdi-file-document-outline"></i>
                <span class="menu-title">Hợp đồng của tôi</span>
            </a>
        </li>
        @endif

        {{-- Quản lý hợp đồng - Chỉ admin, hr có quyền --}}
        @if(MenuHelper::hasMenuPermission('hopdong_quanly'))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#taodontu" aria-expanded="false"
                aria-controls="tables">
                <i class="menu-icon mdi mdi-file-document-multiple-outline"></i>
                <span class="menu-title">Quản lý hợp đồng</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="taodontu">
                <ul class="nav flex-column sub-menu">
                    @if(MenuHelper::hasSubMenuPermission('hopdong_quanly', 'danhsach'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('hopdong.index') }}">Danh sách</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('hopdong.luu-tru') }}">Lưu trữ</a>
                    </li>
                    @endif

                    @if(MenuHelper::hasSubMenuPermission('hopdong_quanly', 'thongke'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('hopdong.thong-ke') }}">Thống kê</a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
        @endif



        {{-- Tin tuyển dụng - admin, hr có quyền --}}
        @if(MenuHelper::hasMenuPermission('tintuyendung'))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ttd" aria-expanded="false" aria-controls="ttd">
                <i class="menu-icon mdi mdi-briefcase-search-outline"></i>
                <span class="menu-title">Tin tuyển dụng</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ttd">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('hr.tintuyendung.index') }}">Tin đã đăng</a>
                    </li>
                </ul>
            </div>
        </li>
        @endif

        {{-- Thông báo - admin, hr có quyền --}}
        @if(MenuHelper::hasMenuPermission('thongbao'))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#cttb" aria-expanded="false" aria-controls="cttb">
                <i class="menu-icon mdi mdi-bell-outline"></i>
                <span class="menu-title">Thông báo</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="cttb">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('hr.captrenthongbao.tuyendung.index') }}">Tuyển dụng</a>
                    </li>
                </ul>
            </div>
        </li>
        @endif

        {{-- Duyệt đơn - admin, hr, department có quyền --}}
        @if(MenuHelper::hasMenuPermission('duyetdon'))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#dd" aria-expanded="false" aria-controls="dd">
                <i class="menu-icon mdi mdi-clipboard-check-outline"></i>
                <span class="menu-title">Duyệt đơn</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="dd">
                <ul class="nav flex-column sub-menu">
                    @if(MenuHelper::hasSubMenuPermission('duyetdon', 'tuyendung'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.duyetdon.tuyendung.index') }}">Tuyển dụng</a>
                    </li>
                    @endif

                    @if(MenuHelper::hasSubMenuPermission('duyetdon', 'xinnghiphep'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('department.donxinnghi.danhsach') }}">Xin nghỉ phép</a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
        @endif

        {{-- Xin nghỉ phép - admin, hr, department, employee có quyền --}}
        @if(MenuHelper::hasMenuPermission('xinnghiphep'))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="menu-icon mdi mdi-calendar-remove-outline"></i>
                <span class="menu-title">Xin nghỉ phép</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    @if(MenuHelper::hasSubMenuPermission('xinnghiphep', 'danhsach'))
                    <li class="nav-item">
                        <a class="nav-link" href="">Danh sách</a>
                    </li>
                    @endif

                    @if(MenuHelper::hasSubMenuPermission('xinnghiphep', 'donxinnghiphep'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('employee/nghi-phep')}}">Đơn nghỉ phép</a>
                    </li>
                    @endif

                </ul>
            </div>
        </li>
        @endif

        {{-- Loại nghỉ phép - admin, hr có quyền --}}
        @if(MenuHelper::hasMenuPermission('loainghiphep'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('hr.loainghiphep.index') }}">
                <i class="menu-icon mdi mdi-file-document-edit-outline"></i>
                <span class="menu-title">Loại nghỉ phép</span>
            </a>
        </li>

        @endif

        {{-- Loại nghỉ phép - admin, hr có quyền --}}
        @if(MenuHelper::hasMenuPermission('yeucautuyendung'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('department.yeucautuyendung.index') }}">
                <i class="menu-icon mdi mdi-file-document-edit-outline"></i>
                <span class="menu-title">Yêu cầu tuyển đụng</span>
            </a>
        </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" href="{{ route('quyDinh') }}">
                <i class="menu-icon mdi mdi-file-document-edit-outline"></i>
                <span class="menu-title">Quy định</span>
            </a>
        </li>
         @if(MenuHelper::hasMenuPermission('dondexuat'))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#dondexuat" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi mdi-file-outline"></i>
                <span class="menu-title">Đơn đề xuất</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="dondexuat">
                <ul class="nav flex-column sub-menu">
                    @if(MenuHelper::hasSubMenuPermission('dondexuat', 'guidexuat'))

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('de-xuat.index')}}">Gửi đề xuất</a>
                    </li>
                    @endif
                    @if(MenuHelper::hasSubMenuPermission('dondexuat', 'danhsach'))

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('de-xuat.index')}}">Danh sách đề xuất</a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
        @endif

        {{-- Thống kê hợp đồng - admin, hr có quyền --}}
        @if(MenuHelper::hasMenuPermission('hopdong'))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#thongke" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi mdi-clock-check"></i>
                <span class="menu-title">Thống kê</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="thongke">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('hopdong.thong-ke') }}">Hợp đồng</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.chamcong.thong-ke') }}">Chấm công</a>
                    </li>

                </ul>
            </div>
        </li>

        @endif


    </ul>
</nav>


