@extends('layoutsHomePage.master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Ứng Tuyển: {{$tuyenDung->tieu_de}}</h2>
                </div>
                <div class="card-body">
                    <form id="applicationForm" action="/ungtuyen/store" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="tin_tuyen_dung_id" value="{{ $tuyenDung->id }}">
                        
                        <div class="form-group mb-3">
                            <label for="ten_ung_vien">Họ và Tên *</label>
                            <input type="text" class="form-control" id="ten_ung_vien" name="ten_ung_vien" value="{{ old('ten_ung_vien') }}" placeholder="Nhập họ và tên đầy đủ">
                            @error('ten_ung_vien')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="your.email@example.com">
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="so_dien_thoai">Số Điện Thoại *</label>
                            <input type="tel" class="form-control" id="so_dien_thoai" name="so_dien_thoai" value="{{ old('so_dien_thoai') }}" placeholder="0123 456 789">
                            @error('so_dien_thoai')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="kinh_nghiem">Kinh Nghiệm</label>
                            <select class="form-control" id="kinh_nghiem" name="kinh_nghiem">
                                <option value="">Chọn mức kinh nghiệm</option>
                                <option value="0-1" {{ old('kinh_nghiem') == '0-1' ? 'selected' : '' }}>0-1 năm</option>
                                <option value="1-3" {{ old('kinh_nghiem') == '1-3' ? 'selected' : '' }}>1-3 năm</option>
                                <option value="3-5" {{ old('kinh_nghiem') == '3-5' ? 'selected' : '' }}>3-5 năm</option>
                                <option value="5+" {{ old('kinh_nghiem') == '5+' ? 'selected' : '' }}>Trên 5 năm</option>
                            </select>
                            @error('kinh_nghiem')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="ky_nang">Kỹ Năng</label>
                            <input type="text" class="form-control" id="ky_nang" name="ky_nang" value="{{ old('ky_nang') }}" placeholder="VD: JavaScript, React, Node.js, Python...">
                            @error('ky_nang')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="thu_gioi_thieu">Thư Giới Thiệu</label>
                            <textarea class="form-control" id="thu_gioi_thieu" name="thu_gioi_thieu" rows="4" placeholder="Giới thiệu ngắn gọn về bản thân và lý do muốn ứng tuyển vị trí này...">{{ old('thu_gioi_thieu') }}</textarea>
                            @error('thu_gioi_thieu')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="tai_cv">Tải lên CV *</label>
                            <input type="file" class="form-control" id="tai_cv" name="tai_cv" accept=".pdf,.doc,.docx">
                            @error('tai_cv')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Gửi Đơn Ứng Tuyển
                            </button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 