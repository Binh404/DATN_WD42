@extends('layoutsAdmin.master')
@section('title', 'Lương')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Main Content Start -->
<div class="content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-body">

				<div class="d-flex justify-content-between flex-wrap align-items-center mb-3">
					<!-- Bên trái: Tiêu đề + Lọc tháng/năm -->
					<div class="d-flex align-items-center gap-3 flex-wrap">
						<h3 class="font-weight-bold mb-0">Phiếu Lương</h3>
						<form method="GET" action="{{ route('luong.index') }}" class="d-flex flex-wrap gap-2 align-items-center mb-0">
							<div>
								<select name="thang" id="thang" class="form-select form-select-sm">
									<option value="">Tất cả</option>
									@for ($i = 1; $i <= 12; $i++)
										<option value="{{ $i }}" {{ $thang == $i ? 'selected' : '' }}>Tháng {{ $i }}</option>
									@endfor
								</select>
							</div>
							<div>
								<select name="nam" id="nam" class="form-select form-select-sm">
									<option value="">Tất cả</option>
									@for ($i = date('Y'); $i >= date('Y') - 5; $i--)
										<option value="{{ $i }}" {{ $nam == $i ? 'selected' : '' }}>{{ $i }}</option>
									@endfor
								</select>
							</div>
							<button type="submit" class="btn btn-sm btn-primary">
								<i class="fas fa-search"></i>
							</button>
						</form>
					</div>

					<!-- Bên phải: Dropdown chứa các action -->
					<div class="dropdown">
						<button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fas fa-cogs"></i> Thao tác
						</button>
						<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
							@php
								$thangHienTai = now()->month;
								$namHienTai = now()->year;
								$thangTruoc = $thangHienTai == 1 ? 12 : $thangHienTai - 1;
								$namTruoc = $thangHienTai == 1 ? $namHienTai - 1 : $namHienTai;
							@endphp
							<li>
								<a href="{{ route('luong.create', ['thang' => $thangTruoc, 'nam' => $namTruoc]) }}" class="dropdown-item">
									<i class="fas fa-calculator"></i> Tính lương tháng {{ $thangTruoc }}/{{ $namTruoc }}
								</a>
							</li>
							<li><a href="{{ route('luong.trang-thai-hien-tai') }}" class="dropdown-item"><i class="fas fa-chart-pie"></i> Trạng thái tính lương</a></li>
							<li><a href="{{ route('luong.export.luong') }}" class="dropdown-item"><i class="fas fa-file-excel"></i> Xuất Excel</a></li>
							<li>
								<form action="{{ route('luong.gui-mail-tat-ca') }}" method="POST" class="px-3 py-1">
									@csrf
									<input type="hidden" name="thang" value="{{ $thang }}">
									<input type="hidden" name="nam" value="{{ $nam }}">
									<button type="submit" class="btn btn-link p-0 text-start w-100">
										<i class="fas fa-envelope"></i> Gửi tất cả phiếu lương
									</button>
								</form>
							</li>
							<li>
								<form id="bulkMailForm" action="{{ route('luong.gui-mail-da-chon') }}" method="POST" class="px-3 py-1">
									@csrf
									<button type="submit" class="btn btn-link p-0 text-start w-100">
										<i class="fas fa-paper-plane"></i> Gửi mail đã chọn
									</button>
								</form>
							</li>
						</ul>
					</div>
				</div>

				<div class="table-responsive">
					<table id="salary" class="table table-sm table-bordered table-striped table-hover align-middle">
						<thead>
							<tr>
								<th><input type="checkbox" id="selectAll"></th>
								<th>STT</th>
								<th>Mã bảng lương</th>
								<th>Họ và tên</th>
								<th>Chức vụ</th>
								<th>Lương tháng</th>
								<th>Ngày công</th>
								<th>Thực lãnh</th>
								<th>Ngày tạo</th>
								<th>Thao tác</th>
							</tr>
						</thead>
						<tbody>
							@foreach($luongs as $index => $luong)
								<tr>
									<td><input type="checkbox" class="row-checkbox" name="selected_ids[]" value="{{ $luong->id }}" form="bulkMailForm"></td>
									<td>{{ ($luongs->currentPage() - 1) * $luongs->perPage() + $loop->iteration }}</td>
									<td>{{ $luong->bangLuong->ma_bang_luong ?? 'Không có mã' }}</td>
									<td>{{ $luong->nguoiDung->hoSo->ho ?? '' }} {{ $luong->nguoiDung->hoSo->ten ?? '' }}</td>
									<td>{{ optional($luong->nguoiDung->chucVu)->ten ?? 'Không có chức vụ' }}</td>
									<td>{{ $luong->luong_thang }}/{{ $luong->luong_nam }}</td>
									<td>{{ number_format($luong->so_ngay_cong) }}</td>
									<td>{{ number_format($luong->luong_thuc_nhan, 0, ',', '.') }} VNĐ</td>
									<td>{{ $luong->created_at->format('d/m/Y') }}</td>
									<td class="text-center">
                                        <div class="dropdown position-static">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('luong.chitiet', $luong->id) }}">
                                                        <i class="mdi mdi-eye"></i> Chi tiết
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('luong.pdf', ['user_id' => $luong->nguoi_dung_id, 'thang' => $luong->luong_thang, 'nam' => $luong->luong_nam]) }}">
                                                        <i class="mdi mdi-download"></i> Tải về
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('luong.delete', $luong->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phiếu lương này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="dropdown-item">
                                                            <i class="mdi mdi-delete me-2"></i> Xoá
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
										{{-- <div class="btn-group btn-group-sm" role="group">
											<a href="{{ route('luong.chitiet', $luong->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
											<a href="{{ route('luong.pdf', ['user_id' => $luong->nguoi_dung_id, 'thang' => $luong->luong_thang, 'nam' => $luong->luong_nam]) }}" class="btn btn-success"><i class="fas fa-download"></i></a>
											<form action="{{ route('luong.delete', $luong->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phiếu lương này?')">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
											</form>
										</div> --}}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="d-flex justify-content-end pe-3 mb-3">
				{{ $luongs->links() }}
			</div>
		</div>
	</div>
</div>
<!-- Main Content End -->
<!-- Modal cảnh báo -->
<div class="modal fade" id="warningModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-warning">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">Thông báo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body text-center">
        ⚠️ Vui lòng chọn ít nhất một nhân viên để gửi phiếu lương!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
<style>
	.table-responsive {
		overflow-x: auto;
		max-width: 100%;
	}
	.table {
		width: 100%;
		table-layout: auto;
		word-wrap: break-word;
	}
	#salary th:nth-child(1), #salary td:nth-child(1) { width: 40px; text-align: center; }
	#salary th:last-child, #salary td:last-child { width: 120px; text-align: center; }

    /* Tùy chỉnh select tháng/năm */
.form-select.form-select-sm {
    padding: 0.25rem 1.5rem 0.25rem 0.5rem; /* padding: top/right/bottom/left */
    font-size: 0.85rem; /* chữ nhỏ gọn hơn */
    height: auto; /* chiều cao vừa khít */
    min-width: 90px; /* không bị quá nhỏ */
    background-position: right 0.4rem center; /* mũi tên cách chữ ra 1 chút */
}

</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const bulkForm = document.getElementById('bulkMailForm');
    if (bulkForm) {
        bulkForm.addEventListener('submit', function (e) {
            const checked = document.querySelectorAll('.row-checkbox:checked');
            if (checked.length === 0) {
                e.preventDefault(); // Ngăn submit
                const modal = new bootstrap.Modal(document.getElementById('warningModal'));
                modal.show(); // Hiện modal cảnh báo
            }
        });
    }
});
</script>
@stop

