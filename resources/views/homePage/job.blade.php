@extends('layoutsHomePage.master')
@section('content')
    <div id="jobs" class="page">
        <section class="jobs-content">
            <div class="container">
                <h2 style="color: white; text-align: center; margin-bottom: 3rem; font-size: 3rem;">
                    Cơ Hội Nghề Nghiệp
                </h2>
                <div class="jobs-grid" id="jobsGrid">
                    {{-- <a href="{{url('/homepage/job/detail')}}" class="job-card-link">
                        <div class="job-card">
                            <h3 class="job-title">Frontend Developer</h3>
                            <div class="job-company">TechCorp</div>
                            <p style="margin-bottom: 1rem; opacity: 0.9;">Phát triển giao diện người dùng với React.js và
                                TypeScript</p>
                            <div class="job-details">
                                <span class="job-tag"><i class="fas fa-map-marker-alt"></i> TP.HCM</span>
                                <span class="job-tag"><i class="fas fa-clock"></i>Full-time</span>
                                <span class="job-tag"><i class="fas fa-money-bill-wave"></i> $15-25 triệu</span>
                            </div>
                            <button class="apply-btn">
                                <i class="fas fa-paper-plane"></i>
                                Ứng Tuyển Ngay
                            </button>
                        </div>
                    </a> --}}

                        @foreach ($tuyenDung as $job)
                        <a href="{{route("tuyendung.getJobDetail",$job->id)}}" class="job-card-link">
                            {{-- <a href=""></a> --}}
                        <div class="job-card">
                                <h3 class="job-title">{{$job->tieu_de}}</h3>
                            <div class="job-company">DV Tech</div>
                            <p style="margin-bottom: 1rem; opacity: 0.9;">{{$job->mo_ta_cong_viec}}</p>
                            <div class="job-details">
                                <span class="job-tag"><i class="fas fa-map-marker-alt"></i> TP.HN</span>
                                <span class="job-tag"><i class="fas fa-clock"></i>Full-time</span>
                                {{-- <span class="job-tag"><i class="fas fa-money-bill-wave"></i> $15-25 triệu</span> --}}
                            </div>
                            <button class="apply-btn">
                                <i class="fas fa-paper-plane"></i>
                                Ứng Tuyển Ngay
                            </button>
                            </div>
                             </a>
                            @endforeach


                    {{-- <a href="{{url('/homepage/job/detail')}}" class="job-card-link">
                        <div class="job-card">
                            <h3 class="job-title">Frontend Developer</h3>
                            <div class="job-company">TechCorp</div>
                            <p style="margin-bottom: 1rem; opacity: 0.9;">Phát triển giao diện người dùng với React.js và
                                TypeScript</p>
                            <div class="job-details">
                                <span class="job-tag"><i class="fas fa-map-marker-alt"></i> TP.HCM</span>
                                <span class="job-tag"><i class="fas fa-clock"></i>Full-time</span>
                                <span class="job-tag"><i class="fas fa-money-bill-wave"></i> $15-25 triệu</span>
                            </div>
                            <button class="apply-btn">
                                <i class="fas fa-paper-plane"></i>
                                Ứng Tuyển Ngay
                            </button>
                        </div>
                    </a>
                    <a href="{{url('/homepage/job/detail')}}" class="job-card-link">
                        <div class="job-card">
                            <h3 class="job-title">Frontend Developer</h3>
                            <div class="job-company">TechCorp</div>
                            <p style="margin-bottom: 1rem; opacity: 0.9;">Phát triển giao diện người dùng với React.js và
                                TypeScript</p>
                            <div class="job-details">
                                <span class="job-tag"><i class="fas fa-map-marker-alt"></i> TP.HCM</span>
                                <span class="job-tag"><i class="fas fa-clock"></i>Full-time</span>
                                <span class="job-tag"><i class="fas fa-money-bill-wave"></i> $15-25 triệu</span>
                            </div>
                            <button class="apply-btn">
                                <i class="fas fa-paper-plane"></i>
                                Ứng Tuyển Ngay
                            </button>
                        </div>
                    </a>
                    <a href="{{url('/homepage/job/detail')}}" class="job-card-link">
                        <div class="job-card">
                            <h3 class="job-title">Frontend Developer</h3>
                            <div class="job-company">TechCorp</div>
                            <p style="margin-bottom: 1rem; opacity: 0.9;">Phát triển giao diện người dùng với React.js và
                                TypeScript</p>
                            <div class="job-details">
                                <span class="job-tag"><i class="fas fa-map-marker-alt"></i> TP.HCM</span>
                                <span class="job-tag"><i class="fas fa-clock"></i>Full-time</span>
                                <span class="job-tag"><i class="fas fa-money-bill-wave"></i> $15-25 triệu</span>
                            </div>
                            <button class="apply-btn">
                                <i class="fas fa-paper-plane"></i>
                                Ứng Tuyển Ngay
                            </button>
                        </div>
                    </a>
                    <a href="{{url('/homepage/job/detail')}}" class="job-card-link">
                        <div class="job-card">
                            <h3 class="job-title">Frontend Developer</h3>
                            <div class="job-company">TechCorp</div>
                            <p style="margin-bottom: 1rem; opacity: 0.9;">Phát triển giao diện người dùng với React.js và
                                TypeScript</p>
                            <div class="job-details">
                                <span class="job-tag"><i class="fas fa-map-marker-alt"></i> TP.HCM</span>
                                <span class="job-tag"><i class="fas fa-clock"></i>Full-time</span>
                                <span class="job-tag"><i class="fas fa-money-bill-wave"></i> $15-25 triệu</span>
                            </div>
                            <button class="apply-btn">
                                <i class="fas fa-paper-plane"></i>
                                Ứng Tuyển Ngay
                            </button>
                        </div>
                    </a> --}}


                </div>
            </div>
        </section>
    </div>
@endsection
<style>
    <style>
.jobs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    padding: 20px;
}

.job-card {
    height: 365px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 16px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.job-card p {
    flex-grow: 1;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}
</style>

</style>
