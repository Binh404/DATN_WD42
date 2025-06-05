@extends('layouts.master')
@section('title', 'Sửa Cầu Tuyển Dụng')

@section('content')

    <div class="container">
        <div class="header">
            <h1>Cập Nhật Yêu Cầu Tuyển Dụng</h1>
        </div>

        <div class="form-container">
            <form id="recruitmentForm" action="{{ route('department.yeucautuyendung.update', ['id' => $yeuCau->id]) }}"
                method="POST">
                @csrf
                @method('PUT')

                <div class="section-title">Thông Tin Cơ Bản</div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="ma">Mã Yêu Cầu <span class="required">*</span></label>
                        <input type="text" id="ma" name="ma" value="{{ $yeuCau->ma }}"
                            placeholder="VD: YC001">
                        @error('ma')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="so_luong">Số Lượng Cần Tuyển <span class="required">*</span></label>
                        <input type="number" id="so_luong" name="so_luong" min="1" placeholder="1"
                            value="{{ $yeuCau->so_luong }}">
                        @error('so_luong')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>



                    <div class="form-group">
                        <label for="chuc_vu_id">Chức Vụ</label>
                        <select id="chuc_vu_id" name="chuc_vu_id">
                            <option value="">-- Chọn Chức Vụ --</option>
                            @foreach ($chucVus as $chucVu)
                                <option {{ $chucVu->id === $yeuCau->chuc_vu_id ? 'selected' : '' }}
                                    value="{{ $chucVu->id }}">{{ $chucVu->ten }}</option>
                            @endforeach
                        </select>
                        @error('chuc_vu_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="loai_hop_dong">Loại Hợp Đồng <span class="required">*</span></label>
                        <select id="loai_hop_dong" name="loai_hop_dong">
                            <option {{ $yeuCau->loai_hop_dong === 'thu_viec' ? 'selected' : '' }} value="thu_viec">Thử Việc
                            </option>
                            <option {{ $yeuCau->loai_hop_dong === 'chinh_thuc' ? 'selected' : '' }} value="chinh_thuc">
                                Chính
                                Thức</option>
                            <option {{ $yeuCau->loai_hop_dong === 'chinh_thuc' ? 'selected' : '' }} value="chinh_thuc">Thời
                                Vụ</option>
                            <option {{ $yeuCau->loai_hop_dong === 'thoi_han' ? 'selected' : '' }} value="thoi_han">Có Thời
                                Hạn</option>
                        </select>
                        @error('loai_hop_dong')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="trinh_do_hoc_van">Trình Độ Học Vấn</label>
                        <select id="trinh_do_hoc_van" name="trinh_do_hoc_van">
                            <option {{ $yeuCau->trinh_do_hoc_van === 'Trung cấp' ? 'selected' : '' }} value="Trung cấp">
                                Trung cấp</option>
                            <option {{ $yeuCau->trinh_do_hoc_van === 'Cao đẳng' ? 'selected' : '' }} value="Cao đẳng">Cao
                                đẳng</option>
                            <option {{ $yeuCau->trinh_do_hoc_van === 'Đại học' ? 'selected' : '' }} value="Đại học">Đại học
                            </option>
                        </select>
                        @error('trinh_do_hoc_van')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="section-title">Mức Lương & Kinh Nghiệm</div>

                <div class="card">
                    <div class="form-group">
                        <label>Mức Lương (VNĐ)</label>
                        <div class="salary-range">
                            <input type="number" id="luong_toi_thieu" name="luong_toi_thieu" placeholder="Lương tối thiểu"
                                min="0" value="{{ $yeuCau->luong_toi_thieu }}">
                            <span>đến</span>
                            <input type="number" id="luong_toi_da" name="luong_toi_da" placeholder="Lương tối đa"
                                min="0" value="{{ $yeuCau->luong_toi_da }}">
                        </div>
                        @error('luong_toi_thieu')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        @error('luong_toi_da')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Kinh Nghiệm (năm)</label>
                        <div class="experience-range">
                            <input type="number" id="kinh_nghiem_toi_thieu" name="kinh_nghiem_toi_thieu"
                                placeholder="Tối thiểu" min="0" value="{{ $yeuCau->kinh_nghiem_toi_thieu }}">
                            <span>đến</span>
                            <input type="number" id="kinh_nghiem_toi_da" name="kinh_nghiem_toi_da" placeholder="Tối đa"
                                min="0" value="{{ $yeuCau->kinh_nghiem_toi_da }}">
                        </div>
                    </div>
                    @error('kinh_nghiem_toi_thieu')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    @error('kinh_nghiem_toi_da')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="section-title">Mô Tả Chi Tiết</div>

                <div class="form-group full-width">
                    <label for="mo_ta_cong_viec">Mô Tả Công Việc</label>
                    <textarea id="mo_ta_cong_viec" name="mo_ta_cong_viec"
                        placeholder="Mô tả chi tiết về công việc, trách nhiệm và quyền hạn...">{{ $yeuCau->mo_ta_cong_viec }}</textarea>
                    @error('mo_ta_cong_viec')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="yeu_cau">Yêu Cầu Ứng Viên</label>
                    <textarea id="yeu_cau" name="yeu_cau" placeholder="Các yêu cầu về trình độ, kinh nghiệm, kỹ năng...">{{ $yeuCau->yeu_cau }}</textarea>
                    @error('yeu_cau')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="ky_nang_yeu_cau">Kỹ Năng Yêu Cầu</label>
                    <textarea id="ky_nang_yeu_cau" name="ky_nang_yeu_cau" placeholder="Các kỹ năng chuyên môn, kỹ năng mềm cần thiết...">{{ $yeuCau->ky_nang_yeu_cau }}</textarea>
                    @error('ky_nang_yeu_cau')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="ghi_chu">Ghi Chú</label>
                    <textarea id="ghi_chu" name="ghi_chu" placeholder="Các thông tin bổ sung khác...">{{ $yeuCau->ghi_chu }}</textarea>
                    @error('ghi_chu')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="btn-container">
                    <button type="button" class="btn btn-secondary">Hủy Bỏ</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 4px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: rgb(56, 160, 212);
            color: white;
            padding: 10px;
            text-align: center;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .form-container {
            padding: 40px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 12px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .salary-range {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 15px;
            align-items: center;
        }

        .salary-range span {
            text-align: center;
            font-weight: 600;
            color: #667eea;
        }

        .experience-range {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 15px;
            align-items: center;
        }

        .experience-range span {
            text-align: center;
            font-weight: 600;
            color: #667eea;
        }

        .section-title {
            font-size: 19px;
            font-weight: 600;
            color: #333;
            margin: 40px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #e1e5e9;
        }

        .section-title:first-child {
            margin-top: 0;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #e1e5e9;
        }

        .btn {
            padding: 15px 40px;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-primary {

            background-color: #667eea
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #dd0d0d;
            border: 2px solid #e1e5e9;
        }

        .btn-secondary:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        .required {
            color: #e74c3c;
        }

        .card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid #e1e5e9;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .salary-range,
            .experience-range {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .salary-range span,
            .experience-range span {
                display: none;
            }

            .container {
                margin: 10px;
            }

            .form-container {
                padding: 20px;
            }

            .header {
                padding: 20px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .btn-container {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 1.2rem;
        }
    </style>
@endsection
