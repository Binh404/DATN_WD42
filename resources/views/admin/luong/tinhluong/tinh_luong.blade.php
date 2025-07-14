@extends('layoutsAdmin.master') {{-- hoặc layout bạn đang dùng --}}

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif
<div class="container">
    <h4 class="mb-3">Tính lương nhân viên</h4>
    <form action="{{ route('luong.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="ma_bang_luong" class="form-label">Mã bảng lương</label>
        <input type="text" name="ma_bang_luong" id="ma_bang_luong" class="form-control" value="{{ $maBangLuong }}" readonly>
    </div>

    <div class="mb-3">
        <label class="form-label">Nhân viên</label>
       <select name="nguoi_dung_id" id="nhanVienSelect" class="form-control" onchange="capNhatSoCong()">
            <option value="">– Chọn nhân viên –</option>
            @foreach ($nhanViens as $nv)
                @if ($nv->hoSo)
                    <option value="{{ $nv->id }}">
                        {{ $nv->hoSo->ma_nhan_vien }} - {{ $nv->hoSo->ho }} {{ $nv->hoSo->ten }}
                    </option>
                @endif
            @endforeach
        </select>

    </div>

    <div class="mb-3">
    <label class="form-label">Số ngày công</label>
    <input type="text" name="so_ngay_cong" id="soCongInput" class="form-control" value="{{ old('so_ngay_cong') }}">
</div>
    <div class="mb-3">
        <label class="form-label">Số ngày công OT</label>
        <input type="number" name="so_cong_tang_ca" id="soCongTangCaInput" class="form-control" value="{{ old('so_ngay_cong_tang_ca') }}">

    </div>

    </div>


    {{-- <div class="mb-3">
        <label class="form-label">Phụ cấp (chức vụ, xăng xe, ăn trưa...)</label>
        <div class="input-group">
            <input type="text" class="form-control" name="phu_cap" value="{{ old('phu_cap') }}" placeholder="Chọn 'tính phụ cấp' để biết số tiền phụ cấp">
            <button type="button" class="btn btn-primary">Tính phụ cấp</button>
        </div>
    </div> --}}

   <div class="mb-3">
    <label class="form-label">Ngày tính lương</label>
    <input type="date" class="form-control" name="ngay_tinh_luong"
        value="{{ old('ngay_tinh_luong', \Carbon\Carbon::now()->toDateString()) }}">
</div>


    <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea name="mo_ta" class="form-control" id="editor">{{ old('mo_ta') }}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Người tính lương</label>
        <input type="text" readonly class="form-control rounded " style="color: #a5a7a8;background-color: #d9d9d9;" value="{{ auth()->user()->ten_dang_nhap }}">
    </div>
    <button type="submit" class="btn btn-success">Cập nhật</button>
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
