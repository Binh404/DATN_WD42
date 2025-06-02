<div id="applicationModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalJobTitle" style="color: white; margin: 0;">Ứng Tuyển Vị Trí</h2>
        </div>
        <div class="modal-body">
            <div class="success-message" id="successMessage">
                <i class="fas fa-check-circle"></i>
                Đơn ứng tuyển của bạn đã được gửi thành công! Chúng tôi sẽ liên hệ với bạn sớm nhất có thể.
            </div>
            <form id="applicationForm" action="/ungtuyen/store" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="job_id" id="job_id" value="">
                <div class="form-group">
                    <label for="ten_ung_vien">Họ và Tên *</label>
                    <input type="text" id="ten_ung_vien" name="ten_ung_vien" required placeholder="Nhập họ và tên đầy đủ">
                </div>
                
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required placeholder="your.email@example.com">
                </div>
                
                <div class="form-group">
                    <label for="so_dien_thoai">Số Điện Thoại *</label>
                    <input type="tel" id="so_dien_thoai" name="so_dien_thoai" required placeholder="0123 456 789">
                </div>
                
                <div class="form-group">
                    <label for="kinh_nghiem">Kinh Nghiệm (năm)</label>
                    <select id="kinh_nghiem" name="kinh_nghiem">
                        <option value="">Chọn mức kinh nghiệm</option>
                        <option value="0-1">0-1 năm</option>
                        <option value="1-3">1-3 năm</option>
                        <option value="3-5">3-5 năm</option>
                        <option value="5+">Trên 5 năm</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="ky_nang">Kỹ Năng Chính</label>
                    <input type="text" id="ky_nang" name="ky_nang" placeholder="VD: JavaScript, React, Node.js, Python...">
                </div>
                
                <div class="form-group">
                    <label for="thu_gioi_thieu">Thư Giới Thiệu</label>
                    <textarea id="thu_gioi_thieu" name="thu_gioi_thieu" rows="4" 
                            placeholder="Giới thiệu ngắn gọn về bản thân và lý do muốn ứng tuyển vị trí này..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="tai_cv">Tải lên CV *</label>
                    <div class="file-upload">
                        <input type="file" id="tai_cv" name="tai_cv" accept=".pdf,.doc,.docx" required>
                        <label for="cv" class="file-upload-label">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; margin-bottom: 0.5rem; color: #4ecdc4;"></i><br>
                            <span id="fileLabel">Chọn file CV (PDF, DOC, DOCX)</span>
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    Gửi Đơn Ứng Tuyển
                </button>
            </form>
        </div>
    </div>
</div>