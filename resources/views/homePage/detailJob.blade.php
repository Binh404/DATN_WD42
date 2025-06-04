@extends('layoutsHomePage.master')
@section('content')
    <div class="progress-bar" id="progressBar"></div>

    <div class="floating-elements">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>

    <div class="container">
        <div class="job-header">
            <div class="company-info">
                <div class="company-logo"><img src="{{ asset('assets/images/dvlogo.png') }}" alt=""></div>
                <div class="company-details">
                    <h1>{{$tuyenDung->tieu_de}}</h1>
                    <div class="company-name">DV Tech</div>
                </div>
            </div>

            <div class="job-meta">
                <div class="meta-item">
                    <div class="meta-label">Mức lương</div>
                    <div class="meta-value">{{ substr($tuyenDung->luong_toi_thieu, 0, 2) }}
                                            - {{ substr($tuyenDung->luong_toi_da, 0, 2)}} triệu</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Địa điểm</div>
                    <div class="meta-value">Hà Nội</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Kinh nghiệm</div>
                    <div class="meta-value">{{$tuyenDung->kinh_nghiem_toi_thieu}} - {{$tuyenDung->kinh_nghiem_toi_da}} năm</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Hình thức</div>
                    <div class="meta-value">Toàn thời gian</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Hạn nộp</div>
                    <div class="meta-value">{{$tuyenDung->han_nop_ho_so->format('d/m/Y')}}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Cấp bậc</div>
                    <div class="meta-value">{{$tuyenDung->cap_do_kinh_nghiem}}</div>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="job-detailss">
                <div class="section-title">Mô tả công việc</div>
                <div class="job-description">
                    {{$tuyenDung->mo_ta_cong_viec}}
                </div>

                <div class="section-title">Yêu cầu công việc</div>
                @foreach($tuyenDung->yeu_cau as $ky_nang)

                    <ul class="requirements-list">
                    <li>{{$ky_nang}}</li>
                    </ul>
                @endforeach
                <div class="section-title">Kỹ năng yêu cầu</div>
                @foreach($tuyenDung->ky_nang_yeu_cau as $ky_nang)
                    <span class="skill-tag">{{ $ky_nang }}</span>
                @endforeach


                <div class="section-title">Quyền lợi</div>
                <div class="benefits-grid">
                     @foreach($tuyenDung->phuc_loi as $pl)
                        <div class="benefit-item">
                            <div>{{ $pl }}</div>
                        </div>
                    @endforeach
                    {{-- <div class="benefit-item">
                        <div class="benefit-icon">🌴</div>
                        <div>15 ngày phép/năm</div>
                    </div> --}}
                </div>
            </div>

            <div class="sidebar">
                <div class="sidebar-card">
                    <a class="apply-button" href="/ungtuyen/create/{{$tuyenDung->id}}">Ứng tuyển ngay</a>
                    <button class="save-button">
                        Lưu tin tuyển dụng
                    </button>
                </div>

                <div class="sidebar-card">
                    <div class="section-title">Thông tin công ty</div>
                    <p><strong>DV Tech</strong></p>
                    <p>Công ty công nghệ hàng đầu chuyên về phát triển ứng dụng web và mobile.</p>
                    <br>
                    <p><strong>Quy mô:</strong> 100-200 nhân viên</p>
                    <p><strong>Lĩnh vực:</strong> Công nghệ thông tin</p>
                    <p><strong>Website:</strong> dvtech.com</p>
                </div>

                <div class="sidebar-card">
                    <div class="section-title">Việc làm liên quan</div>
                    <div style="space-y: 15px;">
                        @foreach ($relateJob as $item)
                            <div style="padding: 15px; background: rgba(102, 126, 234, 0.05); border-radius: 12px; margin-bottom: 15px; cursor: pointer; transition: all 0.3s ease;"
                            onmouseover="this.style.background='rgba(102, 126, 234, 0.1)'"
                            onmouseout="this.style.background='rgba(102, 126, 234, 0.05)'">
                            <strong>{{$item->tieu_de}}</strong><br>
                            <small>{{ substr($item->luong_toi_thieu, 0, 2) }}
                                            - {{ substr($item->luong_toi_da, 0, 2)}} triệu</small>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Modal -->
    @include('layoutsHomePage.partials.applicationModal', ['tuyenDung' => $tuyenDung])
@endsection
<style>
    .company-logo {
    width: 120px; /* hoặc kích thước tùy ý */
    height: 120px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.company-logo img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain; /* hoặc 'cover' tùy theo hiệu ứng bạn muốn */
}

</style>
