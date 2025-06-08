<div id="applicationModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalJobTitle" style="color: white; margin: 0;">Ứng Tuyển Vị Trí</h2>
        </div>
        <div class="modal-body">
            <!-- <div class="success-message" id="successMessage">
                <i class="fas fa-check-circle"></i>
                Đơn ứng tuyển của bạn đã được gửi thành công! Chúng tôi sẽ liên hệ với bạn sớm nhất có thể.
            </div> -->
            <form id="applicationForm" action="/ungtuyen/store" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="tin_tuyen_dung_id" id="tin_tuyen_dung_id" value="{{ $tuyenDung->id ?? '' }}">
                <div class="form-group">
                    <label for="ten_ung_vien">Họ và Tên *</label>
                    <input type="text" id="ten_ung_vien" name="ten_ung_vien" placeholder="Nhập họ và tên đầy đủ" value="{{ old('ten_ung_vien') }}">
                    @error('ten_ung_vien')
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="text" id="email" name="email" placeholder="your.email@example.com" value="{{ old('email') }}">
                    @error('email')
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="so_dien_thoai">Số Điện Thoại *</label>
                    <input type="tel" id="so_dien_thoai" name="so_dien_thoai" placeholder="0123 456 789" value="{{ old('so_dien_thoai') }}">
                    @error('so_dien_thoai')
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="kinh_nghiem">Kinh Nghiệm</label>
                    <select id="kinh_nghiem" name="kinh_nghiem" value="{{ old('kinh_nghiem') }}">
                        <option value="">Chọn mức kinh nghiệm</option>
                        <option value="0-1">0-1 năm</option>
                        <option value="1-3">1-3 năm</option>
                        <option value="3-5">3-5 năm</option>
                        <option value="5+">Trên 5 năm</option>
                    </select>
                    @error('kinh_nghiem')
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="ky_nang">Kỹ Năng</label>
                    <input type="text" id="ky_nang" name="ky_nang" placeholder="VD: JavaScript, React, Node.js, Python..." value="{{ old('ky_nang') }}">
                    @error('ky_nang')
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="thu_gioi_thieu">Thư Giới Thiệu</label>
                    <textarea id="thu_gioi_thieu" name="thu_gioi_thieu" rows="4"
                        placeholder="Giới thiệu ngắn gọn về bản thân và lý do muốn ứng tuyển vị trí này..."></textarea>
                    @error('thu_gioi_thieu')
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="tai_cv">Tải lên CV *</label>
                    <div class="file-upload">
                        <input type="file" id="tai_cv" name="tai_cv" accept=".pdf,.doc,.docx" value="{{ old('tai_cv') }}">
                        <label for="tai_cv" class="file-upload-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Chọn file CV (PDF, DOC, DOCX)</span>
                        </label>
                    </div>
                    @error('tai_cv')
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    Gửi Đơn Ứng Tuyển
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    select {
        width: 100%;
        padding: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        color: white;
        font-size: 1rem;
        transition: all 0.3s ease;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1em;
    }

    select:focus {
        outline: none;
        border-color: #4ecdc4;
        box-shadow: 0 0 20px rgba(78, 205, 196, 0.3);
    }

    select option {
        background-color: #2d3748;
        color: white;
        padding: 1rem;
    }

    .error-message {
        color: #ff4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
    }

    .form-group input.error,
    .form-group select.error,
    .form-group textarea.error {
        border-color: #ff4444;
    }
</style>
@if ($errors->any())
<script>
    window.onload = function() {
        document.getElementById('applicationModal').style.display = 'block';
    };
</script>
@endif