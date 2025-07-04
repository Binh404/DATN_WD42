@extends('layouts.master')

@section('content')
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Chi tiết Phiếu Lương</h1>
			</div>
		</div>
	</div>
</div>

<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="text-center mb-4">
							@if(isset($platform->logo))
								<img src="{{ asset($platform->logo) }}" alt="Logo" width="60">
							@else
								<h3>CÔNG TY DV TECH</h3>
							@endif
							<p>Địa chỉ: 123 Đường Trịnh Văn Bô, TP.HN - MST: 0101234567</p>
						</div>

						<h5  class="mb-3 bg-dark">Thông tin nhân viên</h5>
						<table class="table">
							<tr><td>Họ tên:</td><td>{{ $nhanVien->ho }} {{ $nhanVien->ten }}</td></tr>
							<tr><td>Mã nhân viên:</td><td>{{ $nhanVien->ma_nhan_vien }}</td></tr>
                            <tr><td>Email:</td><td>{{ $nhanVien->email }}</td></tr>
							<tr><td>Chức vụ:</td><td>{{ $nhanVien->chuc_vu ?? '---' }}</td></tr>
							<tr><td>Phòng ban:</td><td>{{ $nhanVien->ten_phong_ban ?? '---' }}</td></tr>
							<tr><td>Kỳ lương:</td><td>Tháng {{ $thang }}/{{ $nam }}</td></tr>
							<tr><td>Ngày lập phiếu:</td><td>{{ date('d/m/Y') }}</td></tr>
						</table>

						{{-- <h5 class="mt-4 bg-dark">Chi tiết lương</h5>
						<table class="table table-bordered">
							<tr><th>Lương cơ bản</th><td>{{ number_format($nhanVien->luong_co_ban ?? 0) }} VND</td></tr>
							<tr><th>Phụ cấp</th><td>{{ number_format($nhanVien->phu_cap ?? 0) }} VND</td></tr>
							<tr><th>Thưởng</th><td>{{ number_format($nhanVien->thuong ?? 0) }} VND</td></tr>
							<tr><th>Làm thêm giờ</th><td>{{ number_format($nhanVien->phu_cap_tang_ca ?? 0) }} VND</td></tr>
							<tr><th>Tổng thu nhập</th><td>{{ number_format(($nhanVien->luong_co_ban ?? 0) + ($nhanVien->phu_cap ?? 0) + ($nhanVien->thuong ?? 0) + ($nhanVien->phu_cap_tang_ca ?? 0)) }} VND</td></tr>
						</table> --}}



						<h5 class="mt-4 bg-dark">Thông tin ngày công</h5>
						<table class="table table-bordered">
							<tr><th>Số giờ làm</th><td>{{ number_format($tongGioLam, 0) }}</td></tr>
							{{-- <tr><th>Số ngày công</th><td>{{ $soCong ?? '---' }}</td></tr> --}}
							<tr><th>Số ngày nghỉ có lương</th><td>{{ $nghiCoLuong ?? 0 }}</td></tr>
							<tr><th>Số ngày nghỉ không lương</th><td>{{ $nghiKhongLuong ?? 0 }}</td></tr>
						</table>

                        {{-- <h5 class="mt-4 bg-dark">Các khoản khấu trừ</h5>
						<table class="table table-bordered">
							<tr><th>Thuế TNCN</th><td>{{ number_format($nhanVien->thue_tncn ?? 0) }} VND</td></tr>
							<tr><th>Bảo hiểm xã hội</th><td>{{ number_format($nhanVien->bhxh ?? 0) }} VND</td></tr>
							<tr><th>Bảo hiểm y tế</th><td>{{ number_format($nhanVien->bhyt ?? 0) }} VND</td></tr>
							<tr><th>Khấu trừ khác</th><td>{{ number_format($nhanVien->khoan_khac ?? 0) }} VND</td></tr>
							<tr><th>Tổng lương</th><td>{{ number_format($tongLuong) }} VND</td></tr>
						</table> --}}
                        <h5 class="mt-4 bg-dark">Lương thực lĩnh</h5>
						<table class="table table-bordered">
							<tr><th>Tổng</th><td>{{ number_format($tongLuong) }} VND</td></tr>
						</table>
						{{-- <h5 class="mt-4">Ký xác nhận</h5>
						<div class="row">
							<div class="col-md-6 text-center">
								<p><strong>Người lập phiếu</strong></p>
								<p style="margin-top: 80px">(Ký tên)</p>
							</div>
							<div class="col-md-6 text-center">
								<p><strong>Người nhận phiếu</strong></p>
								<p style="margin-top: 80px">(Ký tên)</p>
							</div>
						</div> --}}
						<hr>
						{{-- <p><strong>Ghi chú:</strong> Nếu có sai sót trong phiếu lương, vui lòng liên hệ bộ phận nhân sự.</p> --}}
						<a href="{{ route('luong.index', ['thang' => $thang, 'nam' => $nam]) }}" class="btn btn-secondary mt-3">Quay lại</a>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('luong.pdf', ['user_id' => $nhanVien->nguoi_dung_id, 'thang' => $thang, 'nam' => $nam]) }}" class="btn btn-primary">
                                <i class="fas fa-file-pdf"></i> Xuất PDF
                            </a>
                            <a href="#" onclick="window.print()" class="btn btn-secondary">
                                <i class="fas fa-print"></i> In
                            </a>

                        </div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
