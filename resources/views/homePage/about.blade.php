@extends('layoutsHomePage.master')
@section('content')
<div id="about" class="page">
    <section class="about-content">
        <div class="container">
            <div class="about-card">
                <h2 style="color: #4ecdc4; margin-bottom: 2rem; font-size: 2.5rem;">Về Chúng Tôi</h2>
                <p style="font-size: 1.2rem; margin-bottom: 2rem;">
                    TechCorp là một công ty công nghệ hàng đầu chuyên phát triển các giải pháp phần mềm sáng tạo. 
                    Với hơn 10 năm kinh nghiệm trong ngành, chúng tôi tự hào mang đến những sản phẩm chất lượng cao 
                    và dịch vụ xuất sắc cho khách hàng trên toàn thế giới.
                </p>
                <p style="font-size: 1.1rem;">
                    Chúng tôi tin rằng con người là tài sản quý giá nhất, vì vậy chúng tôi cam kết tạo ra một 
                    môi trường làm việc tích cực, khuyến khích sự sáng tạo và phát triển cá nhân.
                </p>
            </div>

            <div class="about-card">
                <h3 style="color: #ff6b6b; margin-bottom: 1.5rem; font-size: 2rem;">Thông Tin Liên Hệ</h3>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <strong>Địa chỉ</strong><br>
                            123 Đường Nguyễn Văn Linh, Quận 7, TP.HCM
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <strong>Điện thoại</strong><br>
                            (028) 1234 5678
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <strong>Email</strong><br>
                            hr@techcorp.com.vn
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-globe"></i>
                        <div>
                            <strong>Website</strong><br>
                            www.techcorp.com.vn
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection