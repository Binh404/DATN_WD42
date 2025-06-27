<div id="advanceModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Tạo đơn tạm ứng lương</h3>
            <button class="close" onclick="closeModal('advanceModal')">&times;</button>
        </div>
        <form onsubmit="submitAdvance(event)">
            <div class="form-group">
                <label class="form-label">Số tiền tạm ứng</label>
                <input type="number" class="form-control" required placeholder="Nhập số tiền">
            </div>
            <div class="form-group">
                <label class="form-label">Lý do tạm ứng</label>
                <select class="form-control" required>
                    <option value="">Chọn lý do</option>
                    <option value="personal">Cá nhân</option>
                    <option value="medical">Y tế</option>
                    <option value="family">Gia đình</option>
                    <option value="other">Khác</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Mô tả chi tiết</label>
                <textarea class="form-control" rows="4" placeholder="Mô tả chi tiết lý do tạm ứng"></textarea>
            </div>
            <div style="text-align: right;">
                <button type="button" class="btn btn-secondary"
                    onclick="closeModal('advanceModal')">Hủy</button>
                <button type="submit" class="btn btn-primary">Gửi đơn</button>
            </div>
        </form>
    </div>
</div>



<div id="salaryDetailModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Chi tiết bảng lương</h3>
            <button class="close" onclick="closeModal('salaryDetailModal')">&times;</button>
        </div>
        <div id="salaryDetailContent">
            <!-- Nội dung chi tiết sẽ được load bằng JS -->
        </div>
    </div>
</div>