@extends('layoutsAdmin.master')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card mt-4">
            <div class="card-header">
                <h4>Chi tiết thông báo</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

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
                            <td>
                                                @if($hopdong->loai_hop_dong == 'thu_viec')
                                                    Thử việc
                                                @elseif($hopdong->loai_hop_dong == 'chinh_thuc')
                                                    Chính thức
                                                @elseif($hopdong->loai_hop_dong == 'xac_dinh_thoi_han')
                                                    Xác định thời hạn
                                                @else
                                                    Không xác định thời hạn
                                                @endif
                                            </td>
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
                            
                            <td>
                                                @if($hopdong->trang_thai_ky == 'cho_ky')
                                                    <span class="badge badge-warning">Chờ ký</span>
                                                @elseif($hopdong->trang_thai_ky == 'da_ky')
                                                    <span class="badge badge-primary">Đã ký</span>
                                                @elseif($hopdong->trang_thai_ky == 'tu_choi_ky')
                                                    <span class="badge badge-danger">Từ chối ký</span>
                                                @else
                                                    <span class="badge badge-light">Không xác định</span>
                                                @endif
                                            </td>
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
                       
                        
                        <a href="{{ route('hopdong.ky', $hopdong->id) }}?from_notification=1" class="btn btn-success">
                            <i class="fas fa-signature"></i> Đồng ý ký hợp đồng
                        </a>
                        <button class="btn btn-danger" onclick="showTuChoiForm()">Từ chối ký</button>
                        
                        <!-- Form từ chối ký (ẩn ban đầu) -->
                        <div id="tuChoiForm" style="display: none; margin-top: 20px;">
                           
                            <form action="{{ route('hopdong.tu-choi-ky', $hopdong->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="ly_do_tu_choi">
                                        <strong>Lý do từ chối ký <span class="text-danger">*</span></strong>
                                    </label>
                                    <textarea 
                                        class="form-control @error('ly_do_tu_choi') is-invalid @enderror" 
                                        id="ly_do_tu_choi" 
                                        name="ly_do_tu_choi" 
                                        rows="4" 
                                        placeholder="Vui lòng nêu rõ lý do từ chối ký hợp đồng..."
                                        required></textarea>
                                    @error('ly_do_tu_choi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                   
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn từ chối ký hợp đồng này?')">
                                        <i class="fas fa-times-circle"></i> Gửi lý do từ chối
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="hideTuChoiForm()">
                                        <i class="fas fa-arrow-left"></i> Hủy
                                    </button>
                                </div>
                            </form>
                        </div>
                    @elseif($hopdong->trang_thai_ky == 'da_ky')
                        @if(\Illuminate\Support\Facades\Auth::id() == $hopdong->nguoi_ky_id)
                            <div class="alert alert-success mt-3">Bạn đã ký hợp đồng này.</div>
                        @else
                            <div class="alert alert-info mt-3">Hợp đồng đã được ký bởi {{ $hopdong->nguoiKy->hoSo->ho ?? '' }} {{ $hopdong->nguoiKy->hoSo->ten ?? '' }}.</div>
                        @endif
                    @elseif($hopdong->trang_thai_ky == 'tu_choi_ky')
                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-times-circle"></i>
                            <strong>Bạn đã từ chối ký hợp đồng này.</strong>
                        </div>
                        @if($hopdong->ghi_chu && str_contains($hopdong->ghi_chu, 'Từ chối ký:'))
                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle"></i>
                                <strong>Lý do từ chối:</strong>
                                <p class="mb-0 mt-2">{{ str_replace('Từ chối ký: ', '', $hopdong->ghi_chu) }}</p>
                            </div>
                        @endif
                    @endif
                @else
                    <div class="alert alert-warning">Không tìm thấy thông tin hợp đồng.</div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function showTuChoiForm() {
    document.getElementById('tuChoiForm').style.display = 'block';
    document.getElementById('ly_do_tu_choi').focus();
}

function hideTuChoiForm() {
    document.getElementById('tuChoiForm').style.display = 'none';
    document.getElementById('ly_do_tu_choi').value = '';
}
</script>
@endsection 