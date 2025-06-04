<!-- Application Modal -->
<div id="applicationModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalJobTitle"></h2>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="applicationForm" action="/ungtuyen/store" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="tin_tuyen_dung_id" id="tin_tuyen_dung_id">
                
                <div class="form-group">
                    <label for="ho_ten">Họ và tên</label>
                    <input type="text" class="form-control" id="ho_ten" name="ho_ten" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="so_dien_thoai">Số điện thoại</label>
                    <input type="tel" class="form-control" id="so_dien_thoai" name="so_dien_thoai" required>
                </div>

                <div class="form-group">
                    <label for="kinh_nghiem">Kinh nghiệm làm việc (năm)</label>
                    <input type="number" class="form-control" id="kinh_nghiem" name="kinh_nghiem" required min="0">
                </div>

                <div class="form-group">
                    <label for="cv" class="form-label">CV của bạn</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
                        <label class="custom-file-label" for="cv" id="fileLabel">Chọn file CV (PDF, DOC, DOCX)</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="thu_xin_viec">Thư xin việc</label>
                    <textarea class="form-control" id="thu_xin_viec" name="thu_xin_viec" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Nộp đơn ứng tuyển</button>
            </form>
        </div>
    </div>
</div>

<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    border-radius: 8px;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover {
    color: black;
}

.form-group {
    margin-bottom: 15px;
}

.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.custom-file {
    position: relative;
    display: inline-block;
    width: 100%;
    margin-bottom: 15px;
}

.custom-file-input {
    position: relative;
    z-index: 2;
    width: 100%;
    height: calc(1.5em + 0.75rem + 2px);
    opacity: 0;
}

.custom-file-label {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 1;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #fff;
    cursor: pointer;
}

.btn-primary {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
}

.btn-primary:hover {
    background-color: #45a049;
}
</style>

@if ($errors->any())
<script>
    window.onload = function() {
        document.getElementById('applicationModal').style.display = 'block';
    };
</script>
@endif