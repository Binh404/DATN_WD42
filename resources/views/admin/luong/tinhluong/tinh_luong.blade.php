@extends('layoutsAdmin.master') {{-- hoặc layout bạn đang dùng --}}

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> {{ session('info') }}
    </div>
@endif

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Tính lương nhân viên</h4>
        <a href="{{ route('luong.danh-sach-da-tinh-luong', ['thang' => $thang, 'nam' => $nam]) }}"
           class="btn btn-info">
            <i class="fas fa-list"></i> Xem danh sách đã tính lương
        </a>
    </div>

    <!-- Thông tin tháng/năm được chọn -->
    <div class="alert alert-info">
        <strong>Quy tắc tính lương:</strong> Chỉ được phép tính lương cho tháng trước khi đã sang tháng mới.<br>
        <strong>Thông tin:</strong> Bạn đang tính lương cho tháng {{ $thang }}/{{ $nam }}.
        Tháng hiện tại: {{ $thangNamHienTai['thang'] }}/{{ $thangNamHienTai['nam'] }}.
        @if(isset($canTinhLuong) && $canTinhLuong)

        @else
            <span class="text-danger">✗ Không thể tính lương cho tháng này (chỉ được tính lương tháng trước)</span>
        @endif
    </div>

    @if(isset($warningMessage))
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> {{ $warningMessage }}
        </div>
    @endif

    @if(isset($canTinhLuong) && $canTinhLuong)
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <strong>Tháng {{ $thang }}/{{ $nam }} có thể tính lương!</strong>
            Bạn có thể tiếp tục tính lương cho nhân viên.
        </div>
    @endif

    <form action="{{ route('luong.store') }}" method="POST" {{ isset($canTinhLuong) && !$canTinhLuong ? 'onsubmit="return false;"' : '' }}>
    @csrf

    <div class="mb-3">
        <label for="ma_bang_luong" class="form-label">Mã bảng lương</label>
        <input type="text" name="ma_bang_luong" id="ma_bang_luong" class="form-control" value="{{ $maBangLuong }}" readonly>
    </div>

    <div class="mb-3">
        <label class="form-label">Nhân viên <span class="text-muted">(Chỉ hiển thị nhân viên chưa được tính lương)</span></label>
       <select name="nguoi_dung_id" id="nhanVienSelect" class="form-control" onchange="capNhatSoCong()" required {{ isset($canTinhLuong) && !$canTinhLuong ? 'disabled' : '' }}>
            <option value="">– Chọn nhân viên –</option>
            @foreach ($nhanViensChuaTinhLuong as $nv)
                @if ($nv->hoSo)
                    <option value="{{ $nv->id }}">
                        {{ $nv->hoSo->ma_nhan_vien }} - {{ $nv->hoSo->ho }} {{ $nv->hoSo->ten }}
                    </option>
                @endif
            @endforeach
        </select>
        <small class="form-text text-muted">Có {{ $nhanViensChuaTinhLuong->count() }} nhân viên chưa được tính lương</small>
    </div>

    <div class="mb-3">
        <label class="form-label">Số ngày công</label>
        <input type="text" name="so_ngay_cong" id="soCongInput" class="form-control" value="{{ old('so_ngay_cong') }}" {{ isset($canTinhLuong) && !$canTinhLuong ? 'disabled' : '' }}>
    </div>
    <div class="mb-3">
        <label class="form-label">Số ngày công OT</label>
       <input
        type="number"
        step="0.1"
        min="0"
        name="so_cong_tang_ca"
        id="soCongTangCaInput"
        class="form-control"
        value="{{ old('so_ngay_cong_tang_ca') }}"
        {{ isset($canTinhLuong) && !$canTinhLuong ? 'disabled' : '' }}
    >
    </div>

    <div class="mb-3">
        <label class="form-label">Ngày tính lương</label>
        <input type="date" class="form-control" name="ngay_tinh_luong"
        value="{{ old('ngay_tinh_luong', \Carbon\Carbon::now()->toDateString()) }}" {{ isset($canTinhLuong) && !$canTinhLuong ? 'disabled' : '' }}>
    </div>

    <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea name="mo_ta" class="form-control" id="editor" {{ isset($canTinhLuong) && !$canTinhLuong ? 'disabled' : '' }}>{{ old('mo_ta') }}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Người tính lương</label>
        <input type="text" readonly class="form-control rounded " style="color: #a5a7a8;background-color: #d9d9d9;" value="{{ auth()->user()->ten_dang_nhap }}">
    </div>

    @if(isset($canTinhLuong) && $canTinhLuong)
        <button type="submit" class="btn btn-success">Cập nhật</button>
    @else
        <button type="button" class="btn btn-secondary" disabled>Không thể tính lương</button>
        @php
            $thangTruoc = $thangNamHienTai['thang'] == 1 ? 12 : $thangNamHienTai['thang'] - 1;
            $namTruoc = $thangNamHienTai['thang'] == 1 ? $thangNamHienTai['nam'] - 1 : $thangNamHienTai['nam'];
        @endphp
        <a href="{{ route('luong.create', ['thang' => $thangTruoc, 'nam' => $namTruoc]) }}" class="btn btn-primary">
            <i class="fas fa-calculator"></i> Tính lương tháng {{ $thangTruoc }}/{{ $namTruoc }} (tháng trước)
        </a>
        <div class="mt-2">
            <small class="text-muted">
                <i class="fas fa-info-circle"></i>
                Bạn chỉ có thể tính lương cho tháng trước. Để tính lương tháng {{ $thangNamHienTai['thang'] }}/{{ $thangNamHienTai['nam'] }},
                hãy đợi đến tháng {{ $thangNamHienTai['thang'] + 1 > 12 ? 1 : $thangNamHienTai['thang'] + 1 }}/{{ $thangNamHienTai['thang'] + 1 > 12 ? $thangNamHienTai['nam'] + 1 : $thangNamHienTai['nam'] }}.
            </small>
        </div>
    @endif
</form>

</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>
<script>
    const bangChamCong = @json($bangChamCong); // Ví dụ: { "1": 6, "2": 7, ... }
    const congTangCa = @json($congTangCa); // Ví dụ: { "1": 2, "2": 3, ... }
    const nhanViensChuaTinhLuong = @json($nhanViensChuaTinhLuong); // Danh sách nhân viên chưa tính lương

    function capNhatSoCong() {
        const nhanVienId = document.getElementById('nhanVienSelect').value;
        if (!nhanVienId) return;

        const soCong = parseFloat(bangChamCong[nhanVienId]) ?? 0;
        document.getElementById('soCongInput').value = soCong;

        const soCongTangCa = parseFloat(congTangCa[nhanVienId]) ;
        document.getElementById('soCongTangCaInput').value = soCongTangCa;
    }

    // Nếu bạn muốn tự động gọi hàm khi chọn nhân viên:
    document.getElementById('nhanVienSelect').addEventListener('change', capNhatSoCong);
</script>

@endpush
