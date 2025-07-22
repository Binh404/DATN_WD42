@extends('layoutsAdmin.master')
@section('title', 'Yêu cầu tuyển dụng')

@section('content')

    <div class="container-fluid px-4">
        <div class="col-md-4">
            <h2 class="fw-bold text-primary mb-2">
                Yêu cầu tuyển dụng
            </h2>
        </div>

    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">
                    Tạo đơn
                </h5>
            </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="forms-sample ml-5 row g-3" action="{{ route('hr.tintuyendung.store') }}" method="POST"
                class="form-container" id="jobPostingForm" onsubmit="return validateForm(event)">
                @csrf

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Mã yêu cầu<span class="required">*</span></label>
                    <input type="text" id="ma" name="ma" placeholder="VD: JOB-2024-001"
                        value="{{ old('ma') }}" class="{{ $errors->has('ma') ? 'error' : '' }} form-control">
                    @error('ma')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="inputPassword4" class="form-label">Tiêu đề<span class="required">*</span></label>
                    <input type="text" id="tieu_de" name="tieu_de" placeholder="VD: Senior Frontend Developer"
                        value="{{ old('tieu_de') }}" class="{{ $errors->has('tieu_de') ? 'error' : '' }} form-control">
                    @error('tieu_de')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Số lượng<span class="required">*</span></label>
                    <input type="number" id="so_vi_tri" name="so_vi_tri"
                        value="{{ old('so_vi_tri', $yeuCau->so_luong ?? '') }}"
                        class="{{ $errors->has('so_vi_tri') ? 'error' : '' }} form-control">
                    @error('so_vi_tri')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputPassword4" class="form-label">Phòng ban<span class="required">*</span></label>
                    <select id="phong_ban_id" name="phong_ban_id"
                        class="{{ $errors->has('phong_ban_id') ? 'error' : '' }} form-control">
                        <option value="">Chọn phòng ban</option>
                        @foreach ($phongBans as $key => $item)
                            <option value="{{ $item->id }}"
                                {{ old('phong_ban_id') == $item->id || (isset($yeuCau) && $item->id === $yeuCau->phongBan->id) ? 'selected' : '' }}>
                                {{ $item->ten_phong_ban }}
                            </option>
                        @endforeach
                    </select>
                    @error('phong_ban_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Chức vụ<span class="required">*</span></label>
                    <select id="chuc_vu_id" name="chuc_vu_id"
                        class="{{ $errors->has('chuc_vu_id') ? 'error' : '' }} form-control">
                        @if (isset($yeuCau))
                            <option value="{{ $yeuCau->chuc_vu_id }}"
                                {{ old('chuc_vu_id') == $yeuCau->chuc_vu_id ? 'selected' : '' }}>
                                {{ $yeuCau->chucVu->ten }}
                            </option>
                        @endif
                    </select>
                    @error('chuc_vu_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>
                <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Vai trò<span class="required">*</span></label>
                    <select id="vai_tro_id" name="vai_tro_id"
                        class="{{ $errors->has('vai_tro_id') ? 'error' : '' }} form-control">
                        <option value="">Chọn vai trò</option>
                        @foreach ($vaiTros as $key => $item)
                            <option value="{{ $item->id }}">
                                {{ $item->ten }}
                            </option>
                        @endforeach
                    </select>
                    @error('vai_tro_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="form-label">Loại hợp đồng<span class="required">*</span></label>
                    <select id="loai_hop_dong" name="loai_hop_dong"
                        class="{{ $errors->has('loai_hop_dong') ? 'error' : '' }} form-control">
                        <option value="">Chọn loại hợp đồng</option>
                        <option value="thu_viec"
                            {{ old('loai_hop_dong') == 'thu_viec' || (isset($yeuCau) && $yeuCau->loai_hop_dong === 'thu_viec') ? 'selected' : '' }}>
                            Thử việc
                        </option>
                        <option value="xac_dinh_thoi_han"
                            {{ old('loai_hop_dong') == 'xac_dinh_thoi_han' || (isset($yeuCau) && $yeuCau->loai_hop_dong === 'xac_dinh_thoi_han') ? 'selected' : '' }}>
                            Xác định thời hạn
                        </option>
                        <option value="khong_xac_dinh_thoi_han"
                            {{ old('loai_hop_dong') == 'khong_xac_dinh_thoi_han' || (isset($yeuCau) && $yeuCau->loai_hop_dong === 'khong_xac_dinh_thoi_han') ? 'selected' : '' }}>
                            Không xác định thời hạn
                        </option>
                    </select>
                    @error('loai_hop_dong')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                </div>
                <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Cấp độ kinh nghiệm<span class="required">*</span></label>
                    <select id="cap_do_kinh_nghiem" name="cap_do_kinh_nghiem"
                        class="{{ $errors->has('cap_do_kinh_nghiem') ? 'error' : '' }} form-control">
                        <option value="">Chọn cấp độ</option>
                        <option value="intern" {{ old('cap_do_kinh_nghiem') == 'intern' ? 'selected' : '' }}>Intern
                        </option>
                        <option value="fresher" {{ old('cap_do_kinh_nghiem') == 'fresher' ? 'selected' : '' }}>Fresher
                        </option>
                        <option value="junior" {{ old('cap_do_kinh_nghiem') == 'junior' ? 'selected' : '' }}>Junior
                        </option>
                        <option value="middle" {{ old('cap_do_kinh_nghiem') == 'middle' ? 'selected' : '' }}>Middle
                        </option>
                        <option value="senior" {{ old('cap_do_kinh_nghiem') == 'senior' ? 'selected' : '' }}>Senior
                        </option>
                    </select>
                    @error('cap_do_kinh_nghiem')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="inputPassword4" class="form-label">Kinh nghiệm tối thiểu<span
                            class="required">*</span></label>
                    <input type="number" id="kinh_nghiem_toi_thieu" name="kinh_nghiem_toi_thieu"
                        value="{{ old('kinh_nghiem_toi_thieu', $yeuCau->kinh_nghiem_toi_thieu ?? '') }}"
                        class="{{ $errors->has('kinh_nghiem_toi_thieu') ? 'error' : '' }} form-control">
                    @error('kinh_nghiem_toi_thieu')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">King nghiệm tối đa<span class="required">*</span></label>
                    <input type="number" id="kinh_nghiem_toi_da" name="kinh_nghiem_toi_da"
                        value="{{ old('kinh_nghiem_toi_da', $yeuCau->kinh_nghiem_toi_da ?? '') }}"
                        class="{{ $errors->has('kinh_nghiem_toi_da') ? 'error' : '' }} form-control">
                    @error('kinh_nghiem_toi_da')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="inputEmail4" class="form-label">Trình độ học vấn<span class="required">*</span></label>
                    <select id="trinh_do_hoc_van" name="trinh_do_hoc_van"
                        class="{{ $errors->has('trinh_do_hoc_van') ? 'error' : '' }} form-control">
                        <option value="">Chọn trình độ</option>
                        <option value="Trung cấp"
                            {{ old('trinh_do_hoc_van') == 'Trung cấp' || (isset($yeuCau) && $yeuCau->trinh_do_hoc_van === 'Trung cấp') ? 'selected' : '' }}>
                            Trung cấp
                        </option>
                        <option value="Cao đẳng"
                            {{ old('trinh_do_hoc_van') == 'Cao đẳng' || (isset($yeuCau) && $yeuCau->trinh_do_hoc_van === 'Cao đẳng') ? 'selected' : '' }}>
                            Cao đẳng
                        </option>
                        <option value="Đại học"
                            {{ old('trinh_do_hoc_van') == 'Đại học' || (isset($yeuCau) && $yeuCau->trinh_do_hoc_van === 'Đại học') ? 'selected' : '' }}>
                            Đại học
                        </option>
                    </select>
                    @error('trinh_do_hoc_van')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Lương tối thiểu</label>
                    <input type="number" id="luong_toi_thieu" name="luong_toi_thieu" placeholder="10000000"
                        value="{{ old('luong_toi_thieu', $yeuCau->luong_toi_thieu ?? '') }}"
                        class="{{ $errors->has('luong_toi_thieu') ? 'error' : '' }} form-control">
                    @error('luong_toi_thieu')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="inputEmail4" class="form-label">Lương tối đa<span class="required">*</span></label>
                    <input type="number" id="luong_toi_da" name="luong_toi_da" placeholder="20000000"
                        value="{{ old('luong_toi_da', $yeuCau->luong_toi_da ?? '') }}"
                        class="{{ $errors->has('luong_toi_da') ? 'error' : '' }} form-control">
                    @error('luong_toi_da')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="inputEmail4" class="form-label">Hạn nộp hồ sơ<span class="required">*</span></label>
                    <input type="date" id="han_nop_ho_so" name="han_nop_ho_so" value="{{ old('han_nop_ho_so') }}"
                        class="{{ $errors->has('han_nop_ho_so') ? 'error' : '' }}">
                    @error('han_nop_ho_so')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="inputEmail4" class="form-label">Cho phép làm việc từ xa<span
                            class="required">*</span></label>
                    <input type="checkbox" id="lam_viec_tu_xa" name="lam_viec_tu_xa" value="1"
                        {{ old('lam_viec_tu_xa') ? 'checked' : '' }}>
                    @error('lam_viec_tu_xa')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="inputEmail4" class="form-label">Tuyển gấp<span class="required">*</span></label>
                    <input type="checkbox" id="tuyen_gap" name="tuyen_gap" value="1"
                        {{ old('tuyen_gap') ? 'checked' : '' }}>
                    @error('tuyen_gap')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="inputEmail4" class="form-label">Kỹ năng yêu cầu<span class="required">*</span></label>
                    <textarea id="ky_nang_yeu_cau" name="ky_nang_yeu_cau" placeholder="Các yêu cầu về kinh nghiệm, kỹ năng, tính cách..."
                        class="{{ $errors->has('ky_nang_yeu_cau') ? 'error' : '' }}">
                        {{ is_array(old('ky_nang_yeu_cau'))
                            ? implode(', ', old('ky_nang_yeu_cau'))
                            : old(
                                'ky_nang_yeu_cau',
                                is_array($yeuCau->ky_nang_yeu_cau ?? null) ? implode(', ', $yeuCau->ky_nang_yeu_cau) : $yeuCau->ky_nang_yeu_cau,
                            ) }}
                    </textarea>


                    @error('ky_nang_yeu_cau')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <input type="hidden" name="yeu_cau_id" id="yeu_cau_id" value="{{ $yeuCau->id }}">


                <div class="form-group col-md-6">
                    <label for="inputEmail4" class="form-label">Mô tả công việc<span class="required">*</span></label>
                    <textarea id="mo_ta_cong_viec" name="mo_ta_cong_viec" placeholder="Mô tả chi tiết về công việc, trách nhiệm chính..."
                        class="{{ $errors->has('mo_ta_cong_viec') ? 'error' : '' }}">{{ old('mo_ta_cong_viec', $yeuCau->mo_ta_cong_viec ?? '') }}</textarea>
                    @error('mo_ta_cong_viec')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="inputEmail4" class="form-label">Yêu cầu ứng viên<span class="required">*</span></label>
                    <textarea id="yeu_cau" name="yeu_cau" placeholder="Các yêu cầu về kinh nghiệm, kỹ năng, tính cách..."
                        class="{{ $errors->has('yeu_cau') ? 'error' : '' }}">{{ old('yeu_cau', $yeuCau->yeu_cau ?? '') }}</textarea>
                    @error('yeu_cau')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="inputEmail4" class="form-label">Phúc lợi</label>
                    <textarea id="phuc_loi" name="phuc_loi"
                        placeholder="Các phúc lợi dành cho nhân viên: bảo hiểm, thưởng, nghỉ phép..."
                        class="{{ $errors->has('phuc_loi') ? 'error' : '' }}">{{ old('phuc_loi') }}</textarea>
                    @error('phuc_loi')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary me-2">Đăng tin</button>
                <button class="btn btn-light">Hủy</button>
            </form>
        </div>
    </div>



    <style>
        .header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            padding: 20px;
            text-align: center;
            color: white;
        }

        .header h1 {
            font-size: 25px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            font-size: 17px;
            opacity: 0.9;
        }

        .form-container {
            padding: 40px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .form-section {
            background: #f8f9ff;
            padding: 25px;
            border-radius: 15px;
            border-left: 4px solid #4facfe;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: #4facfe;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2d3748;
        }

        .required {
            color: #e53e3e;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #4facfe;
            box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
            transform: translateY(-1px);
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin: 0;
        }

        .skills-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .skill-tag {
            background: #4facfe;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .skill-tag button {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        .add-skill {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .add-skill input {
            flex: 1;
        }

        .add-skill button {
            background: #48bb78;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-skill button:hover {
            background: #38a169;
            transform: translateY(-1px);
        }

        .status-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .status-btn {
            padding: 10px 20px;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-btn.active {
            background: #4facfe;
            color: white;
            border-color: #4facfe;
        }

        .submit-section {
            text-align: center;
            padding: 30px;
            background: #f7fafc;
            margin: 0 -40px -40px -40px;
        }

        .submit-btn {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(79, 172, 254, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(79, 172, 254, 0.4);
        }

        .draft-btn {
            background: #718096;
            margin-right: 15px;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 4px;
        }

        .preview-btn {
            background: #805ad5;
            margin-left: 15px;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 2rem;
            }

            .form-container {
                padding: 20px;
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>


    <script>
        let skills = [];

        // Khởi tạo skills từ dữ liệu có sẵn
        const kyNangYeuCau = @json($yeuCau->ky_nang_yeu_cau ?? []);
        if (Array.isArray(kyNangYeuCau)) {
            skills.push(...kyNangYeuCau);
        }
        renderSkills();

        function addSkill() {
            const input = document.getElementById('skillInput');
            const skill = input.value.trim();

            if (skill && !skills.includes(skill)) {
                skills.push(skill);
                renderSkills();
                input.value = '';
            } else if (skill && skills.includes(skill)) {
                alert('Kỹ năng này đã được thêm!');
            }
        }

        function removeSkill(skill) {
            skills = skills.filter(s => s !== skill);
            renderSkills();
        }

        function renderSkills() {
            const container = document.getElementById('skillsContainer');

            if (skills.length === 0) {
                container.innerHTML = '<div style="color: #666; font-style: italic;">Chưa có kỹ năng nào</div>';
            } else {
                container.innerHTML = skills.map(skill => `
            <div class="skill-tag">
                ${escapeHtml(skill)}
                <button type="button" onclick="removeSkill('${escapeHtml(skill).replace(/'/g, '\\\'')}')" title="Xóa">×</button>
            </div>
        `).join('');
            }

            updateHiddenInputs();
        }

        function updateHiddenInputs() {
            // Xóa các input cũ
            const oldInputs = document.querySelectorAll('input[name="ky_nang_yeu_cau[]"]');
            oldInputs.forEach(input => input.remove());

            const form = document.getElementById('jobPostingForm');

            // Nếu có skills, tạo hidden input cho mỗi skill
            if (skills.length > 0) {
                skills.forEach(skill => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ky_nang_yeu_cau[]'; // Quan trọng: phải có []
                    input.value = skill;
                    form.appendChild(input);
                });
            } else {
                // Nếu không có skills, tạo một input rỗng để đảm bảo field tồn tại
                const emptyInput = document.createElement('input');
                emptyInput.type = 'hidden';
                emptyInput.name = 'ky_nang_yeu_cau[]';
                emptyInput.value = '';
                form.appendChild(emptyInput);
            }
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Event listeners
        document.getElementById('skillInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addSkill();
            }
        });

        document.getElementById('jobPostingForm').addEventListener('submit', function(e) {
            updateHiddenInputs();
            document.getElementById('trang_thai').value = 'dang_tuyen';
        });

        function saveDraft() {
            updateHiddenInputs();
            document.getElementById('trang_thai').value = 'nhap';
            document.getElementById('jobPostingForm').submit();
        }

        function validateForm(event) {
            const tieuDe = document.getElementById('tieu_de').value.trim();
            const ma = document.getElementById('ma').value.trim();
            const soLuong = document.getElementById('so_vi_tri').value.trim();
            const phongBan = document.getElementById('phong_ban_id').value.trim();
            const chucVu = document.getElementById('chuc_vu_id').value.trim();
            const loaiHopDong = document.getElementById('loai_hop_dong').value.trim();
            const kinhNghiemToiThieu = document.getElementById('kinh_nghiem_toi_thieu').value.trim();
            const kinhNghiemToiDa = document.getElementById('kinh_nghiem_toi_da').value.trim();
            const moTa = document.getElementById('mo_ta_cong_viec').value.trim();
            const trinhDoHocVan = document.getElementById('trinh_do_hoc_van').value.trim();
            const luongToiThieu = document.getElementById('luong_toi_thieu').value.trim();
            const luongToiDa = document.getElementById('luong_toi_da').value.trim();
            const hanNop = document.getElementById('han_nop_ho_so').value.trim();
            const phucLoi = document.getElementById('phuc_loi').value.trim();

            const yeuCau = document.getElementById('yeu_cau').value.trim();

            // Xóa lỗi cũ
            document.querySelectorAll('.validation-error').forEach(e => e.remove());
            document.querySelectorAll('input, select, textarea').forEach(field => {
                field.style.border = '';
            });

            let isValid = true;

            // Validate mã (bắt buộc, ít nhất 3 ký tự)
            if (ma === '') {
                showValidationError('ma', 'Mã yêu cầu không được để trống');
                isValid = false;
            } else if (ma.length < 3) {
                showValidationError('ma', 'Mã yêu cầu phải có ít nhất 3 ký tự');
                isValid = false;
            }

            if (tieuDe === '') {
                showValidationError('tieu_de', 'Tiêu đề không được để trống');
                isValid = false;
            }


            if (hanNop === '') {
                showValidationError('han_nop_ho_so', 'Hạn nộp hồ sơ không được để trống');
                isValid = false;
            } else {
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                const hanNopDate = new Date(hanNop);

                if (hanNopDate <= today) {
                    showValidationError('han_nop_ho_so', 'Hạn nộp hồ sơ phải là ngày trong tương lai');
                    isValid = false;
                }
            }

            // Validate số lượng (bắt buộc, số nguyên > 0)
            if (soLuong === '') {
                showValidationError('so_vi_tri', 'Số lượng không được để trống');
                isValid = false;
            } else if (soLuong < 1 || !Number.isInteger(Number(soLuong))) {
                showValidationError('so_vi_tri', 'Số lượng phải là số nguyên lớn hơn 0');
                isValid = false;
            }

            // Validate loại hợp đồng (bắt buộc)
            if (loaiHopDong === '') {
                showValidationError('loai_hop_dong', 'Vui lòng chọn loại hợp đồng');
                isValid = false;
            }

            if (chucVu === '') {
                showValidationError('chuc_vu_id', 'Vui lòng chọn chức vụ');
                isValid = false;
            }

            if (trinhDoHocVan === '') {
                showValidationError('trinh_do_hoc_van', 'Vui lòng chọn trình độ học vấn');
                isValid = false;
            }

            // Validate lương (nếu có nhập thì phải hợp lệ)
            if (luongToiThieu !== '' && (isNaN(luongToiThieu) || parseFloat(luongToiThieu) < 0)) {
                showValidationError('luong_toi_thieu', 'Lương tối thiểu phải là số không âm');
                isValid = false;
            } else if (luongToiThieu === '') {
                showValidationError('luong_toi_thieu', 'Vui lòng điền lương tối thiểu');
                isValid = false;
            }

            if (luongToiDa !== '' && (isNaN(luongToiDa) || parseFloat(luongToiDa) < 0)) {
                showValidationError('luong_toi_da', 'Lương tối đa phải là số không âm');
                isValid = false;
            } else if (luongToiDa === '') {
                showValidationError('luong_toi_thieu', 'Vui lòng điền lương tối đa');
                isValid = false;
            }

            // Validate range lương (nếu cả 2 đều có giá trị)
            if (luongToiThieu !== '' && luongToiDa !== '' &&
                !isNaN(luongToiThieu) && !isNaN(luongToiDa) &&
                parseFloat(luongToiThieu) >= parseFloat(luongToiDa)) {
                showValidationError('luong_toi_da', 'Lương tối đa phải lớn hơn lương tối thiểu');
                isValid = false;
            }

            // Validate kinh nghiệm (nếu có nhập thì phải hợp lệ)
            if (kinhNghiemToiThieu !== '' && (isNaN(kinhNghiemToiThieu) || parseFloat(kinhNghiemToiThieu) < 0)) {
                showValidationError('kinh_nghiem_toi_thieu', 'Kinh nghiệm tối thiểu phải là số không âm');
                isValid = false;
            } else if (kinhNghiemToiThieu === '') {
                showValidationError('kinh_nghiem_toi_thieu', 'Vui lòng điền kinh nghiệm tối thiểu');
                isValid = false;
            }

            if (kinhNghiemToiDa !== '' && (isNaN(kinhNghiemToiDa) || parseFloat(kinhNghiemToiDa) < 0)) {
                showValidationError('kinh_nghiem_toi_da', 'Kinh nghiệm tối đa phải là số không âm');
                isValid = false;
            } else if (kinhNghiemToiDa === '') {
                showValidationError('kinh_nghiem_toi_da', 'Vui lòng điền kinh nghiệm tối đa');
                isValid = false;
            }

            // Validate range kinh nghiệm (nếu cả 2 đều có giá trị)
            if (kinhNghiemToiThieu !== '' && kinhNghiemToiDa !== '' &&
                !isNaN(kinhNghiemToiThieu) && !isNaN(kinhNghiemToiDa) &&
                parseFloat(kinhNghiemToiThieu) >= parseFloat(kinhNghiemToiDa)) {
                showValidationError('kinh_nghiem_toi_da', 'Kinh nghiệm tối đa phải lớn hơn kinh nghiệm tối thiểu');
                isValid = false;
            }

            if (moTa === '') {
                showValidationError('mo_ta_cong_viec', 'Vui lòng điền mô tả công việc');
                isValid = false;
            }

            if (yeuCau === '') {
                showValidationError('yeu_cau', 'Vui lòng điền yêu cầu');
                isValid = false;
            }


            // Scroll to first error if any
            if (!isValid) {
                event.preventDefault();
                const firstError = document.querySelector('.validation-error');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }


            return isValid;
        }

        function showValidationError(fieldId, message) {
            const field = document.getElementById(fieldId);
            if (!field) return;

            const error = document.createElement('div');
            error.className = 'validation-error';
            error.style.color = '#dc3545';
            error.style.fontSize = '0.875rem';
            error.style.marginTop = '0.25rem';
            error.style.display = 'block';
            error.textContent = message;

            field.parentNode.appendChild(error);
            field.style.border = '1px solid #dc3545';
        }

        // Thêm event listener để xóa lỗi khi user nhập lại
        document.addEventListener('DOMContentLoaded', function() {
            const fields = ['ma', 'so_luong', 'chuc_vu_id', 'loai_hop_dong', 'trinh_do_hoc_van',
                'luong_toi_thieu', 'luong_toi_da', 'kinh_nghiem_toi_thieu', 'kinh_nghiem_toi_da',
                'mo_ta_cong_viec', 'yeu_cau'
            ];

            fields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.addEventListener('input', function() {
                        // Xóa lỗi của field hiện tại
                        const error = this.parentNode.querySelector('.validation-error');
                        if (error) {
                            error.remove();
                            this.style.border = '';
                        }
                    });
                }
            });
        });
    </script>
@endsection
