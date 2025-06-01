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
                <div class="company-logo">TV</div>
                <div class="company-details">
                    <h1>Senior Frontend Developer</h1>
                    <div class="company-name">TechVision Co.</div>
                </div>
            </div>

            <div class="job-meta">
                <div class="meta-item">
                    <div class="meta-label">Mức lương</div>
                    <div class="meta-value">25-35 triệu VND</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Địa điểm</div>
                    <div class="meta-value">Hà Nội</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Kinh nghiệm</div>
                    <div class="meta-value">3-5 năm</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Hình thức</div>
                    <div class="meta-value">Toàn thời gian</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Hạn nộp</div>
                    <div class="meta-value">30/06/2025</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Cấp bậc</div>
                    <div class="meta-value">Senior</div>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="job-detailss">
                <div class="section-title">Mô tả công việc</div>
                <div class="job-description">
                    Chúng tôi đang tìm kiếm một Senior Frontend Developer tài năng để tham gia vào đội ngũ phát triển sản
                    phẩm công nghệ hàng đầu. Bạn sẽ có cơ hội làm việc với những công nghệ tiên tiến nhất và đóng góp vào
                    việc xây dựng những ứng dụng web hiện đại, có tác động tích cực đến hàng triệu người dùng.
                </div>

                <div class="section-title">Yêu cầu công việc</div>
                <ul class="requirements-list">
                    <li>Có ít nhất 3-5 năm kinh nghiệm phát triển Frontend</li>
                    <li>Thành thạo React.js, Vue.js hoặc Angular</li>
                    <li>Kinh nghiệm với HTML5, CSS3, JavaScript (ES6+)</li>
                    <li>Hiểu biết về responsive design và cross-browser compatibility</li>
                    <li>Kinh nghiệm với Git, Webpack, và các build tools</li>
                    <li>Khả năng làm việc độc lập và trong nhóm</li>
                    <li>Tiếng Anh giao tiếp tốt</li>
                    <li>Có kinh nghiệm với TypeScript là một lợi thế</li>
                </ul>

                <div class="section-title">Kỹ năng yêu cầu</div>
                <div class="skills-tags">
                    <span class="skill-tag">React.js</span>
                    <span class="skill-tag">JavaScript</span>
                    <span class="skill-tag">TypeScript</span>
                    <span class="skill-tag">HTML5</span>
                    <span class="skill-tag">CSS3</span>
                    <span class="skill-tag">SASS/SCSS</span>
                    <span class="skill-tag">Git</span>
                    <span class="skill-tag">Webpack</span>
                    <span class="skill-tag">REST API</span>
                    <span class="skill-tag">Redux</span>
                </div>

                <div class="section-title">Quyền lợi</div>
                <div class="benefits-grid">
                    <div class="benefit-item">
                        <div class="benefit-icon">💰</div>
                        <div>Lương cạnh tranh + Bonus</div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">🏥</div>
                        <div>Bảo hiểm sức khỏe</div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">🌴</div>
                        <div>15 ngày phép/năm</div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">📚</div>
                        <div>Đào tạo & Phát triển</div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">🏢</div>
                        <div>Môi trường hiện đại</div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">⏰</div>
                        <div>Giờ làm linh hoạt</div>
                    </div>
                </div>
            </div>

            <div class="sidebar">
                <div class="sidebar-card">
                    <button class="apply-button" onclick="openApplicationModal('Frontend Developer', 1)">
                        Ứng tuyển ngay
                    </button>
                    <button class="save-button">
                        Lưu tin tuyển dụng
                    </button>
                </div>

                <div class="sidebar-card">
                    <div class="section-title">Thông tin công ty</div>
                    <p><strong>TechVision Co.</strong></p>
                    <p>Công ty công nghệ hàng đầu chuyên về phát triển ứng dụng web và mobile.</p>
                    <br>
                    <p><strong>Quy mô:</strong> 100-200 nhân viên</p>
                    <p><strong>Lĩnh vực:</strong> Công nghệ thông tin</p>
                    <p><strong>Website:</strong> techvision.com</p>
                </div>

                <div class="sidebar-card">
                    <div class="section-title">Việc làm liên quan</div>
                    <div style="space-y: 15px;">
                        <div style="padding: 15px; background: rgba(102, 126, 234, 0.05); border-radius: 12px; margin-bottom: 15px; cursor: pointer; transition: all 0.3s ease;"
                            onmouseover="this.style.background='rgba(102, 126, 234, 0.1)'"
                            onmouseout="this.style.background='rgba(102, 126, 234, 0.05)'">
                            <strong>Full-stack Developer</strong><br>
                            <small>CodeCraft Ltd. • 20-30 triệu</small>
                        </div>
                        <div style="padding: 15px; background: rgba(102, 126, 234, 0.05); border-radius: 12px; margin-bottom: 15px; cursor: pointer; transition: all 0.3s ease;"
                            onmouseover="this.style.background='rgba(102, 126, 234, 0.1)'"
                            onmouseout="this.style.background='rgba(102, 126, 234, 0.05)'">
                            <strong>React Developer</strong><br>
                            <small>StartupXYZ • 18-25 triệu</small>
                        </div>
                        <div style="padding: 15px; background: rgba(102, 126, 234, 0.05); border-radius: 12px; cursor: pointer; transition: all 0.3s ease;"
                            onmouseover="this.style.background='rgba(102, 126, 234, 0.1)'"
                            onmouseout="this.style.background='rgba(102, 126, 234, 0.05)'">
                            <strong>UI/UX Developer</strong><br>
                            <small>DesignHub • 22-28 triệu</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
