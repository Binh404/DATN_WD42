@extends('layoutsHomePage.master')
@section('content')
<div id="home" class="page active">
    <section class="hero">
        <div class="container">
            <h1>Chào Mừng Đến Với TechCorp</h1>
            <p>Nơi kết nối tài năng với cơ hội - Xây dựng tương lai cùng nhau</p>
            <a href="{{url('homepage/job')}}" class="cta-button">
                Khám Phá Cơ Hội Việc Làm
            </a>
        </div>
    </section>

    <section class="features container">
        <div class="features-grid">
            <div class="feature-card">
                <i class="fas fa-users"></i>
                <h3>Đội Ngũ Chuyên Nghiệp</h3>
                <p>Làm việc cùng những chuyên gia hàng đầu trong ngành công nghệ với môi trường năng động và sáng tạo.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-rocket"></i>
                <h3>Phát Triển Nghề Nghiệp</h3>
                <p>Cơ hội thăng tiến rõ ràng với các chương trình đào tạo và phát triển kỹ năng liên tục.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-heart"></i>
                <h3>Phúc Lợi Tốt</h3>
                <p>Chế độ đãi ngộ hấp dẫn, bảo hiểm sức khỏe toàn diện và nhiều hoạt động team building thú vị.</p>
            </div>
        </div>
    </section>
</div>
@endsection