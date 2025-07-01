@extends('layouts.master')
@section('title', 'lương')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Salary</h1>
      </div>
      {{-- <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('salary') }}">Payments</a></li>
          <li class="breadcrumb-item active">Salary</li>
        </ol>
      </div> --}}
    </div>
  </div>
</div>
<!-- Breadcrumbs End -->

<!-- Session Message Section Start -->
@include('layouts.partials.error-message')
<!-- Session Message Section End -->

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    	<div class="d-flex justify-content-between col-12 pl-0">
	                    	<h4 class="card-title pt-2 font-weight-bold">Employee Salaries</h4>
	                        <div class="text-right row">
	                        	<div class="form-group">
									{{-- <input id="month" class="form-control" value="{{$month}}" type="month"> --}}
                                   <form method="GET" action="{{ route('luong.index') }}" class="row align-items-end mb-3">
                                        <!-- Tháng -->
                                        <div class="col-md-3">
                                            <label for="thang" class="form-label">Tháng</label>
                                            <select class="form-control" id="thang" name="thang">
                                                <option value="">-- Chọn tháng --</option>
                                                @for($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}" {{ request('thang') == $i ? 'selected' : '' }}>
                                                        Tháng {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>

                                        <!-- Năm -->
                                        <div class="col-md-3">
                                            <label for="nam" class="form-label">Năm</label>
                                            <select class="form-control" id="nam" name="nam">
                                                <option value="">-- Chọn năm --</option>
                                                @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                                                    <option value="{{ $year }}" {{ request('nam') == $year ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>

                                        <!-- Nút tìm -->
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fas fa-search"></i> Tìm kiếm
                                            </button>
                                        </div>
                                    </form>
								</div>
	                        </div>
	                    </div>

						<hr class="mt-0">

						<div class="table-responsive">
                            <table id="salary" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>Họ và tên</th>
										<th>Số giờ làm</th>
										<th>Tổng lương</th>
										{{-- <th>Số công</th> --}}
										<th> Actions </th>
									</tr>
								</thead>
								<tbody>
									@foreach($luongTheoNguoi as $nguoi)
                                        <tr>
                                            <td>{{ $nguoi->ho_ten }}</td>
                                            <td>{{ number_format($nguoi->tong_gio_lam) }}</td>
                                            <td>{{ number_format($nguoi->tong_luong) }}</td>
                                            <td>
                                            <a href="{{ route('luong.chitiet', [
                                                'user_id' => $nguoi->id,
                                                'thang' => request('thang', now()->month),
                                                'nam' => request('nam', now()->year)
                                            ]) }}" class="btn btn-info btn-sm">
                                                Xem chi tiết
                                            </a>

                                        </td>
                                        </tr>
                                    @endforeach

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Main Content End -->

{{-- <script>
    $(document).ready(function () {
        $('#salary').DataTable({
          	"paging": true,
          	"lengthChange": true,
          	"searching": true,
          	"ordering": true,
          	"info": true,
          	"autoWidth": false,
          	"responsive": true,
      		"buttons": ["copy", "csv", "excel", "pdf"]
    	}).buttons().container().appendTo('#salary_wrapper .col-md-6:eq(0)');
    });

    $(document).ready(function () {
        $("#month").change(function(e){
            var url = "{{route('salary.show')}}/" + $(this).val();

            if (url) {
                window.location = url;
            }
            return false;
        });
    });
</script> --}}
@stop
