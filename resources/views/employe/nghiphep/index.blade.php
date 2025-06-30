@extends('layoutsEmploye.master')

@section('content-employee')
    <style>
        .action-btn {
            display: inline-block;
            padding: 6px 10px;
            margin-right: 5px;
            border-radius: 4px;
            color: #fff;
            text-decoration: none;
            transition: 0.2s;
        }

        .action-btn.delete {
            background-color: #dc3545;
            /* đỏ */
        }

        .action-btn.view {
            background-color: #007bff;
            /* xanh */
        }

        .action-btn:hover {
            opacity: 0.8;
        }

        .cho-duyet {
            background-color: rgb(243, 220, 191);
            border-radius: 10px;
            padding: 3px;
        }

        .da-duyet {
            background-color: rgb(104, 248, 9);
            border-radius: 10px;
            padding: 3px;
        }

        .tu-choi {
            background-color: rgb(250, 142, 10);
            border-radius: 10px;
            padding: 3px;
        }

        .huy-bo {
            background-color: rgb(237, 36, 32);
            border-radius: 10px;
            padding: 3px;
            color: white;
        }
    </style>
    <section class="content-section" id="leave">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Trạng thái đơn</h2>
            <div>
                <a href="{{ url('/employee/so-du-nghi-phep') }}" style="text-decoration: none;">
                    <button class="btn btn-danger">
                        Số dư nghỉ phép
                    </button>
                </a>

                <a href="{{ route('nghiphep.create') }}">
                    <button class="btn btn-success">
                        <i class="fas fa-plus"></i>
                        Tạo đơn nghỉ phép
                    </button>
                </a>

            </div>

        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày tạo</th>
                        <th>Từ ngày</th>
                        <th>Đến ngày</th>
                        <th>Lý do</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($donXinNghis as $key => $item)
                        <tr>
                            <td>{{ $item->ma_don_nghi }}</td>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td>{{ $item->ngay_bat_dau->format('d/m/Y') }}</td>
                            <td>{{ $item->ngay_ket_thuc->format('d/m/Y') }}</td>

                            <td>{{ $item->ly_do }}</td>
                            <td>
                                <span
                                    class="{{ $item->trang_thai == 'cho_duyet' ? 'cho-duyet' : ($item->trang_thai == 'da_duyet' ? 'da-duyet' : ($item->trang_thai == 'tu_choi' ? 'tu-choi' : 'huy-bo')) }}">
                                    {{ $item->trang_thai == 'cho_duyet' ? 'Chờ duyệt' : ($item->trang_thai == 'da_duyet' ? 'Đã duyệt' : ($item->trang_thai == 'tu_choi' ? 'Từ chối' : 'Hủy bỏ')) }}
                                </span>

                            </td>
                            <td>
                                <a href="{{ route('nghiphep.cancel', $item->id) }}" class="action-btn delete"
                                    title="Xoá"
                                    onclick="return confirm('Bạn có chắc chắn muốn hủy đơn nghỉ phép này không?')">
                                    <i class="fas fa-times"></i>
                                </a>

                                <a href="{{ route('nghiphep.show', ['id' => $item->id]) }}" class="action-btn view"
                                    title="Xem">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </section>
@endsection
