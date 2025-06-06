@extends('layoutsEmploye.master')

@section('content-employee')
<section class="content-section" id="salary">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Bảng lương</h2>
        <button class="btn btn-primary">
            <i class="fas fa-download"></i>
            Tải bảng lương
        </button>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Tháng/Năm</th>
                    <th>Lương cơ bản</th>
                    <th>Phụ cấp</th>
                    <th>Khấu trừ</th>
                    <th>Thực nhận</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($bangLuongNhanVien as $luongNhanVien)
                <tr>
                    <td>{{$luongNhanVien->bangLuong->thang}}/{{$luongNhanVien->bangLuong->nam}}</td>
                    <td>{{number_format($luongNhanVien->luong_co_ban, 0,  '.',',') }}đ</td>
                    <td>{{number_format($luongNhanVien->tong_phu_cap, 0,  '.',',') }}đ</td>
                    <td>{{number_format($luongNhanVien->tong_khau_tru, 0, '.',',') }}đ</td>
                    <td>{{number_format($luongNhanVien->luong_thuc_nhan, 0, '.',',') }}đ</td>
                    <td>
                        <span class="status-badge {{ $luongNhanVien->bangLuong->trang_thai_label['class'] }}">
                            {{ $luongNhanVien->bangLuong->trang_thai_label['text'] }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('salary.show', $luongNhanVien->bangLuong->id) }}" class="btn btn-secondary"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</section>
@endsection


