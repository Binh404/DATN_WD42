@extends('layoutsAdmin.master')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Chi tiết thông báo</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        </div>
                    @endif

                    <div class="alert alert-info">
                        {{ $notification->data['message'] }}
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            {{ $notification->data['message'] }}
                        </div>

                        <!-- Thông tin người gửi hợp đồng -->
                        @if ($hopdong && $hopdong->nguoiGuiHopDong && $hopdong->nguoiGuiHopDong->hoSo)
                            <div class="alert alert-success">
                                <i class="fas fa-user-tie"></i>
                                <strong>Người gửi hợp đồng:</strong>
                                {{ $hopdong->nguoiGuiHopDong->hoSo->ho ?? '' }}
                                {{ $hopdong->nguoiGuiHopDong->hoSo->ten ?? '' }}
                                {{-- @if ($hopdong->nguoiGuiHopDong->vaiTro)
                                    <span
                                        class="badge badge-info ml-2">{{ ucfirst($hopdong->nguoiGuiHopDong->vaiTro) }}</span>
                                @endif --}}
                            </div>
                        @endif

                        @if ($hopdong)
                            <h5>Thông tin hợp đồng</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Số hợp đồng</th>
                                    <td>{{ $hopdong->so_hop_dong }}</td>
                                </tr>
                                <tr>
                                    <th>Loại hợp đồng</th>
                                    <td>
                                        @if ($hopdong->loai_hop_dong == 'thu_viec')
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
                                    <th>Lương </th>
                                    <td>{{ number_format($hopdong->luong_co_ban) }}</td>
                                </tr>
                                <tr>
                                    <th>Phụ cấp</th>
                                    <td>{{ number_format($hopdong->phu_cap) }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái ký</th>

                                    <td>
                                        @if ($hopdong->trang_thai_ky == 'cho_ky')
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
                                        @if ($hopdong->duong_dan_file)
                                            @php
                                                $files = explode(';', $hopdong->duong_dan_file);
                                                $files = array_filter($files); // Loại bỏ các phần tử rỗng
                                            @endphp
                                            <div class="mb-2">
                                                @foreach ($files as $index => $file)
                                                    @if ($file)
                                                        @php
                                                            $fileName = basename(trim($file));
                                                            $fileExtension = strtolower(
                                                                pathinfo(trim($file), PATHINFO_EXTENSION),
                                                            );
                                                        @endphp
                                                        <div class="mb-2">
                                                            <a href="{{ asset('storage/' . trim($file)) }}" target="_blank"
                                                                class="btn btn-info btn-sm me-2" title="Xem file">
                                                                @if ($fileExtension == 'pdf')
                                                                    <i class="fas fa-file-pdf"></i>
                                                                @elseif(in_array($fileExtension, ['doc', 'docx']))
                                                                    <i class="fas fa-file-word"></i>
                                                                @elseif(in_array($fileExtension, ['xls', 'xlsx']))
                                                                    <i class="fas fa-file-excel"></i>
                                                                @elseif(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                    <i class="fas fa-file-image"></i>
                                                                @else
                                                                    <i class="fas fa-file"></i>
                                                                @endif
                                                                File {{ $index + 1 }}: {{ $fileName }}
                                                            </a>

                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-danger">Không có file</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <!-- File hợp đồng đã ký -->
                            @if ($hopdong->file_hop_dong_da_ky)
                                <div class="mt-4">
                                    <h5 class="text-success mb-3">
                                        <i class="fas fa-file-signature"></i> File hợp đồng đã ký
                                    </h5>
                                    @php
                                        $signedFiles = explode(';', $hopdong->file_hop_dong_da_ky);
                                        $signedFiles = array_filter($signedFiles); // Loại bỏ các phần tử rỗng
                                    @endphp

                                    <div class="mb-2">
                                        @foreach ($signedFiles as $index => $filePath)
                                            @php
                                                $signedFileName = basename($filePath);
                                                $signedFileExtension = strtolower(
                                                    pathinfo($filePath, PATHINFO_EXTENSION),
                                                );
                                            @endphp
                                            <div class="mb-2">
                                                <a href="{{ asset('storage/' . $filePath) }}" target="_blank"
                                                    class="btn btn-success btn-sm me-2" title="Xem file">
                                                    <i class="fas fa-file-signature"></i>
                                                    File đã ký {{ $index + 1 }}: {{ $signedFileName }}
                                                </a>

                                            </div>
                                        @endforeach

                                        <!-- Thông tin ký chung cho tất cả file -->
                                        @if ($hopdong->thoi_gian_ky)
                                            <small class="text-success d-block mt-2">
                                                <i class="fas fa-calendar-check"></i>
                                                Đã ký: {{ $hopdong->thoi_gian_ky->format('d/m/Y H:i') }}
                                            </small>
                                        @endif
                                        @if ($hopdong->nguoiKy && $hopdong->nguoiKy->hoSo)
                                            <small class="text-success d-block">
                                                <i class="fas fa-user-check"></i>
                                                Ký bởi:
                                                {{ $hopdong->nguoiKy->hoSo->ho . ' ' . $hopdong->nguoiKy->hoSo->ten }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if ($hopdong->trang_thai_ky == 'cho_ky')


                                <div class="btn-group-custom ">
                                    <a href="{{ route('hopdong.ky', $hopdong->id) }}?from_notification=1"
                                        class="btn btn-success">
                                        <i class="fas fa-signature"></i> Đồng ý ký hợp đồng
                                    </a>
                                    <button class="btn btn-danger" onclick="showTuChoiForm()">
                                        <i class="fas fa-times-circle"></i> Từ chối ký
                                    </button>
                                </div>

                                <!-- Form từ chối ký (ẩn ban đầu) -->
                                <div id="tuChoiForm" style="display: none; margin-top: 20px;">

                                    <form action="{{ route('hopdong.tu-choi-ky', $hopdong->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="ly_do_tu_choi">
                                                <strong>Lý do từ chối ký <span class="text-danger">*</span></strong>
                                            </label>
                                            <textarea class="form-control @error('ly_do_tu_choi') is-invalid @enderror" id="ly_do_tu_choi" name="ly_do_tu_choi"
                                                rows="4" placeholder="Vui lòng nêu rõ lý do từ chối ký hợp đồng..." required></textarea>
                                            @error('ly_do_tu_choi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                        <div class="form-group">
                                            <div class="btn-group-custom">
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn từ chối ký hợp đồng này?')">
                                                    <i class="fas fa-times-circle"></i> Gửi lý do từ chối
                                                </button>
                                                <button type="button" class="btn btn-secondary" onclick="hideTuChoiForm()">
                                                    <i class="fas fa-arrow-left"></i> Hủy
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @elseif($hopdong->trang_thai_ky == 'da_ky')
                                @if (\Illuminate\Support\Facades\Auth::id() == $hopdong->nguoi_ky_id)
                                    <div class="alert alert-success mt-3">Bạn đã ký hợp đồng này.</div>
                                @else
                                    <div class="alert alert-info mt-3">Hợp đồng đã được ký bởi
                                        {{ $hopdong->nguoiKy->hoSo->ho ?? '' }} {{ $hopdong->nguoiKy->hoSo->ten ?? '' }}.
                                    </div>
                                @endif
                            @elseif($hopdong->trang_thai_ky == 'tu_choi_ky')
                                @php
                                    $nguoiTuChoi = $hopdong->nguoiDung;
                                    $tenNguoiTuChoi =
                                        $nguoiTuChoi && $nguoiTuChoi->hoSo
                                            ? $nguoiTuChoi->hoSo->ho . ' ' . $nguoiTuChoi->hoSo->ten
                                            : 'N/A';
                                    $isCurrentUser = \Illuminate\Support\Facades\Auth::id() == $hopdong->nguoi_dung_id;
                                @endphp

                                <div class="alert alert-warning mt-3">
                                    <i class="fas fa-times-circle"></i>
                                    <strong>
                                        @if ($isCurrentUser)
                                            Bạn đã từ chối ký hợp đồng này.
                                        @else
                                            Nhân viên {{ $tenNguoiTuChoi }} đã từ chối ký hợp đồng này.
                                        @endif
                                    </strong>
                                </div>
                                @if ($hopdong->ghi_chu && str_contains($hopdong->ghi_chu, 'Từ chối ký:'))
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle"></i>
                                        <strong>Lý do từ chối:</strong>
                                        <p class="mb-0 mt-2">{{ str_replace('Từ chối ký: ', '', $hopdong->ghi_chu) }}</p>
                                    </div>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <style>
            .btn-group-custom {
                display: flex;
                gap: 0.5rem;
                flex-wrap: wrap;
            }

            .btn-group-custom .btn {
                margin-bottom: 0.5rem;
            }

            @media (max-width: 576px) {
                .btn-group-custom {
                    flex-direction: column;
                }

                .btn-group-custom .btn {
                    width: 100%;
                    margin-bottom: 0.5rem;
                }
            }
        </style>

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
