@extends('layoutsAdmin.master')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card mt-4">
            <div class="card-header">
                <h4>Chi tiết thông báo</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    {{ $notification->data['message'] }}
                </div>

                @if($hopdong)
                    <h5>Thông tin hợp đồng</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Số hợp đồng</th>
                            <td>{{ $hopdong->so_hop_dong }}</td>
                        </tr>
                        <tr>
                            <th>Loại hợp đồng</th>
                            <td>{{ $hopdong->loai_hop_dong }}</td>
                        </tr>
                        <tr>
                            <th>Ngày bắt đầu</th>
                            <td>{{ $hopdong->ngay_bat_dau }}</td>
                        </tr>
                        <tr>
                            <th>Ngày kết thúc</th>
                            <td>{{ $hopdong->ngay_ket_thuc }}</td>
                        </tr>
                        <tr>
                            <th>Lương cơ bản</th>
                            <td>{{ number_format($hopdong->luong_co_ban) }}</td>
                        </tr>
                        <tr>
                            <th>Phụ cấp</th>
                            <td>{{ number_format($hopdong->phu_cap) }}</td>
                        </tr>
                        <tr>
                            <th>Trạng thái ký</th>
                            <td>{{ $hopdong->trang_thai_ky }}</td>
                        </tr>
                        <tr>
                            <th>File hợp đồng</th>
                            <td>
                                @if($hopdong->duong_dan_file)
                                    <a href="{{ asset('storage/' . $hopdong->duong_dan_file) }}" target="_blank" class="btn btn-sm btn-primary">Xem file hợp đồng</a>
                                @else
                                    <span class="text-danger">Không có file</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    @if($hopdong->trang_thai_ky == 'cho_ky')
                        <form action="{{ route('hopdong.xacnhanky', $hopdong->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <input type="hidden" name="notification_id" value="{{ $notification->id }}">
                            <button type="submit" class="btn btn-success">Đồng ý ký hợp đồng</button>
                        </form>
                        <button class="btn btn-danger" onclick="document.getElementById('tuChoiForm').style.display='block'">Từ chối ký</button>
                        <form id="tuChoiForm" action="{{ route('hopdong.tuchoiky', $hopdong->id) }}" method="POST" style="display:none; margin-top:10px;">
                            @csrf
                            <div class="form-group">
                                <label>Lý do từ chối:</label>
                                <textarea name="ly_do_tu_choi" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger mt-2">Gửi lý do từ chối</button>
                        </form>
                    @elseif($hopdong->trang_thai_ky == 'da_ky')
                        @if(\Illuminate\Support\Facades\Auth::id() == $hopdong->nguoi_ky_id)
                            <div class="alert alert-success mt-3">Bạn đã ký hợp đồng này.</div>
                        @else
                            <div class="alert alert-info mt-3">Hợp đồng đã được ký bởi {{ $hopdong->nguoiKy->hoSo->ho ?? '' }} {{ $hopdong->nguoiKy->hoSo->ten ?? '' }}.</div>
                        @endif
                    @elseif($hopdong->trang_thai_ky == 'tu_choi_ky')
                        <div class="alert alert-warning mt-3">Bạn đã từ chối ký hợp đồng này.</div>
                    @endif
                @else
                    <div class="alert alert-warning">Không tìm thấy thông tin hợp đồng.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 