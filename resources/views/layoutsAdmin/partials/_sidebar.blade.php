<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href=" {{route('admin.dashboard')}}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item nav-category">UI Elements</li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-floor-plan"></i>
                <span class="menu-title">Hồ sơ</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="/hoso/admin/hoso">Hồ sơ</a>
                    </li>

                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false"
                aria-controls="form-elements">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Phòng ban</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="/phongban">Danh sách phòng ban</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                <i class="menu-icon mdi mdi-chart-line"></i>
                <span class="menu-title">Lương</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route("luong.index")}}">Lương</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('phieuluong.index')}}">Phiếu Lương</a></li>
                </ul>
            </div>

        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="menu-icon mdi mdi-clock-outline"></i>
                <span class="menu-title">Chấm công</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item"> <a class="nav-link
                        " href="{{ route('admin.chamcong.index')}}">Danh sách chấm công</a>
                    </li>

                    <li class="nav-item"> <a class="nav-link "
                            href="{{ route('admin.chamcong.xemPheDuyetTangCa')}}">Phê duyệt tăng ca</a></li>
                    <li class="nav-item"> <a class="nav-link  "
                            href="{{ route('admin.chamcong.tangCa.index')}}">Danh sách tăng ca</a></li>
                    <li class="nav-item"> <a class="nav-link  "
                            href="{{ route('admin.locations.index')}}">Quản lý vị trí</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#hd" aria-expanded="false" aria-controls="hd">
                <i class="menu-icon mdi mdi-file-document"></i>
                <span class="menu-title">Hợp đồng</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="hd">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('hopdong.index') }}">Danh sách</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ttd" aria-expanded="false" aria-controls="ttd">
                <i class="menu-icon mdi mdi-layers-outline"></i>
                <span class="menu-title">Tin tuyển dụng</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ttd">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('hr.tintuyendung.index')}}">Tin đã đăng</a></li>

                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#cttb" aria-expanded="false" aria-controls="cttb">
                <i class="menu-icon mdi mdi-layers-outline"></i>
                <span class="menu-title">Thông báo</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="cttb">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('hr.captrenthongbao.tuyendung.index')}}">Tuyển dụng</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#dd" aria-expanded="false" aria-controls="dd">
                <i class="menu-icon mdi mdi-layers-outline"></i>
                <span class="menu-title">Duyệt đơn</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="dd">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('admin.duyetdon.tuyendung.index')}}">Tuyển dụng</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('department.donxinnghi.danhsach') }}">Xin nghỉ phép</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="menu-icon mdi mdi-account-circle-outline"></i>
                <span class="menu-title">Xin nghỉ phép</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="">
                            Danh sách </a></li>
                    {{-- <li class="nav-item"> <a class="nav-link" href="{{route('admin.duyetdon.tuyendung.index')}}"> Tuyển dụng
                        </a></li> --}}
                    {{-- <li class="nav-item"> <a class="nav-link" href="../../pages/samples/error-500.html"> 500
                        </a></li>
                    <li class="nav-item"> <a class="nav-link" href="../../pages/samples/login.html"> Login
                        </a></li>
                    <li class="nav-item"> <a class="nav-link" href="../../pages/samples/register.html">
                            Register </a></li> --}}
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('hr.loainghiphep.index')}}">
                <i class="menu-icon mdi mdi-file-document"></i>
                <span class="menu-title">Loại nghỉ phép </span>
            </a>
        </li>
    </ul>
</nav>
