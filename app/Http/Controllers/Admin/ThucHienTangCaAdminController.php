<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ChamCongTangCaExport;
use App\Http\Controllers\Controller;
use App\Imports\ChamCongImport;
use App\Imports\ChamCongTangCaImport;
use App\Models\PhongBan;
use App\Models\thucHienTangCa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;


class ThucHienTangCaAdminController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
            $query = thucHienTangCa::with([
                'dangKyTangCa' => function ($q) {
                    $q->select('id', 'ngay_tang_ca', 'nguoi_duyet_id', 'nguoi_dung_id'); // chỉ chọn cột cần thiết
                    $q->with([
                        'nguoiDuyet:id,email', // thay bằng cột bạn cần
                        'nguoiDung' => function ($q2) {
                            $q2->select('id', 'email', 'phong_ban_id','vai_tro_id'); // chọn các cột cần dùng
                            $q2->with([
                                'phongBan:id,ten_phong_ban',
                                'hoSo:id,nguoi_dung_id,ma_nhan_vien,ho,ten,anh_dai_dien', // ví dụ: chỉ chọn vài trường từ hồ sơ
                                'vaiTro:id,ten_hien_thi',
                            ]);
                        }
                    ]);
                }
            ]);
            // Tìm kiếm theo tên nhân viên
            if ($request->filled('ten_nhan_vien')) {
                $tenNhanVien = $request->get('ten_nhan_vien');
                $query->whereHas('dangKyTangCa.nguoiDung.hoSo', function ($q) use ($tenNhanVien) {
                    $q->where('ho', 'LIKE', "%{$tenNhanVien}%")
                        ->orWhere('ten', 'LIKE', "%{$tenNhanVien}%")
                        ->orWhereRaw("CONCAT(ho, ' ', ten) LIKE ?", ["%{$tenNhanVien}%"]);
                });
            }

            // Tìm kiếm theo phòng ban
            if ($request->filled('phong_ban_id')) {
                $query->whereHas('dangKyTangCa.nguoiDung', function ($q) use ($request) {
                    $q->where('phong_ban_id', $request->get('phong_ban_id'));
                });
            }

            // Tìm kiếm theo trạng thái
            if ($request->filled('trang_thai')) {
                $query->where('trang_thai', $request->get('trang_thai'));
            }

            // Tìm kiếm theo ngày cụ thể
            if ($request->filled('ngay_cham_cong')) {
                $query->whereHas('dangKyTangCa', function ($q) use ($request) {
                    $q->where('ngay_tang_ca', $request->get('ngay_cham_cong'));
                });
            }

            // Tìm kiếm theo khoảng thời gian
            if ($request->filled('tu_ngay')) {
                $query->whereHas('dangKyTangCa', function ($q) use ($request) {
                    $q->where('ngay_tang_ca', '>=', $request->get('tu_ngay'));
                });
            }

            if ($request->filled('den_ngay')) {
                $query->whereHas('dangKyTangCa', function ($q) use ($request) {
                     $q->where('ngay_tang_ca', '<=', $request->get('den_ngay'));
                });

            }

            // Tìm kiếm theo tháng và năm
            if ($request->filled('thang')) {
                $query->whereHas('dangKyTangCa', function ($q) use ($request) {
                      $q->whereMonth('ngay_tang_ca', $request->get('thang'));
                });
            }

            if ($request->filled('nam')) {
                $query->whereHas('dangKyTangCa', function ($q) use ($request) {
                      $q->whereYear('ngay_tang_ca', $request->get('nam'));
                });


            }


            $phongBan = PhongBan::orderBy('ten_phong_ban')->get();
            // Lấy các trạng thái để hiển thị trong dropdown
            $trangThaiList = [
                'chua_lam' => 'Chưa làm',
                'dang_lam' => 'Đang làm',
                'hoan_thanh' => 'Hoàn thành',
                'khong_hoan_thanh' => 'Không hoàn thành',
            ];
            $user = auth()->user();
            if ($user->coVaiTro('Admin') || $user->coVaiTro('HR')) {
                // Admin và HR xem tất cả dữ liệu, không giới hạn
            } else if ($user->coVaiTro('department')) {
                $phongBanId = $user->phong_ban_id;
                $userId = $user->id;

                $query->whereHas('dangKyTangCa.nguoiDung', function ($q) use ($phongBanId, $userId) {
                    $q->where('phong_ban_id', $phongBanId)
                    ->where('id', '<>', $userId)
                    ->whereHas('vaiTro', function ($v) {
                        $v->whereNotIn('ten', ['Admin', 'HR', 'department']); // loại vai trò không hợp lệ
                    })
                    ;
                });

                // // Lọc chỉ những người cùng phòng ban và không lấy user hiện tại
                // $query->whereHas('nguoiDung', function ($q) use ($phongBanId, $userId) {
                //     $q->where('phong_ban_id', $phongBanId)
                //     ->where('id', '<>', $userId);
                // });
            } else {
                // Nếu không phải Admin, HR, department thì không có quyền xem
                abort(403, 'Bạn  có quyền truy cập.');
            }

            $danhSachTangCa = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ;
            // dd($danhSachTangCa);
            //thống kê
            $soLuongTangCa = $danhSachTangCa->count();
            $soLuongChuaHoanThanh = $danhSachTangCa->where('trang_thai', 'khong_hoan_thanh')->count();
            $soLuongHoanThanh = $danhSachTangCa->where('trang_thai', 'hoan_thanh')->count();
            $tyLeHoanThanh = $soLuongHoanThanh > 0 ? round(($soLuongHoanThanh / $soLuongTangCa) * 100, 2) : 0;
            $tyLeChuaHoanThanh = $soLuongChuaHoanThanh > 0 ? round(($soLuongChuaHoanThanh / $soLuongTangCa) * 100, 2) : 0;
            $soGioTangCa = $danhSachTangCa->sum('so_gio_tang_ca_thuc_te');
            // dd($soGioTangCa, $soLuongTangCa, $soLuongChuaHoanThanh, $soLuongHoanThanh);

            return view('admin.cham-cong.quan_ly_tang_ca.index',compact(
                 'phongBan', 'trangThaiList',
                 'danhSachTangCa', 'soLuongTangCa', 'tyLeChuaHoanThanh',
                 'tyLeHoanThanh', 'soGioTangCa'));

    }
    public function show($id)
    {
        $chamCongTangCa = thucHienTangCa::with('dangKyTangCa')->find($id);
        $chamCongTangCa->load(['dangKyTangCa.nguoiDung.hoSo', 'dangKyTangCa.nguoiDung.phongBan','dangKyTangCa.nguoiDung']);
        $user = auth()->user();

        if ($user->coVaiTro('Admin') || $user->coVaiTro('HR')) {
            // Admin, HR xem được hết
        } else if ($user->coVaiTro('department')) {
             $target = $chamCongTangCa->dangKyTangCa->nguoiDung;

                if (
                    $target->phong_ban_id !== $user->phong_ban_id || // khác phòng ban
                    $target->id === $user->id ||                     // chính họ
                    $target->coVaiTro('Admin') ||                    // loại bỏ Admin
                    $target->coVaiTro('HR') ||                       // loại bỏ HR
                    $target->coVaiTro('department')                  // loại bỏ trưởng phòng
                ) {
                    abort(403, 'Bạn không có quyền xem bản ghi này.');
                }
        } else {
            abort(403, 'Bạn không có quyền xem bản ghi này.');
        }
        // dd($chamCongTangCa->nguoiDung);
        return view('admin.cham-cong.quan_ly_tang_ca.show', compact('chamCongTangCa'));
    }
    public function edit($id)
    {
        $thucHienTangCa = thucHienTangCa::with(['dangKyTangCa', 'dangKyTangCa.nguoiDung.hoSo', 'dangKyTangCa.nguoiDung.phongBan','dangKyTangCa.nguoiDung'])->findOrFail($id);
        // dd($chamCong->gio_vao);
        $user = auth()->user();

        if ($user->coVaiTro('Admin') || $user->coVaiTro('HR')) {
            // Admin, HR xem được hết
        } else if ($user->coVaiTro('department')) {
             $target = $thucHienTangCa->dangKyTangCa->nguoiDung;

                if (
                    $target->phong_ban_id !== $user->phong_ban_id || // khác phòng ban
                    $target->id === $user->id ||                     // chính họ
                    $target->coVaiTro('Admin') ||                    // loại bỏ Admin
                    $target->coVaiTro('HR') ||                       // loại bỏ HR
                    $target->coVaiTro('department')                  // loại bỏ trưởng phòng
                ) {
                    abort(403, 'Bạn không có quyền xem bản ghi này.');
                }
        } else {
            abort(403, 'Bạn không có quyền xem bản ghi này.');
        }
        // Lấy danh sách nhân viên với thông tin hồ sơ và phòng ban
        // $nhanVien = NguoiDung::with(['hoSo', 'phongBan'])
        //     ->whereHas('hoSo')
        //     ->orderBy('id')
        //     ->get();
        // dd($thucHienTangCa);
        // Danh sách trạng thái chấm công
        $trangThaiList = [
            'chua_lam' => 'Chưa làm',
            'dang_lam' => 'Đang làm',
            'hoan_thanh' => 'Hoàn thành',
            'khong_hoan_thanh' => 'Không hoàn thành',
        ];

        return view('admin.cham-cong.quan_ly_tang_ca.edit', compact('thucHienTangCa', 'trangThaiList'));
    }
    public function update(Request $request, $id)
    {
        $thucHienTangCa = thucHienTangCa::layBanGhiTheoDonTangCaById($id);
        $user = auth()->user();

        if ($user->coVaiTro('Admin') || $user->coVaiTro('HR')) {
            // Admin, HR xem được hết
        } else if ($user->coVaiTro('department')) {
             $target = $thucHienTangCa->dangKyTangCa->nguoiDung;

                if (
                    $target->phong_ban_id !== $user->phong_ban_id || // khác phòng ban
                    $target->id === $user->id ||                     // chính họ
                    $target->coVaiTro('Admin') ||                    // loại bỏ Admin
                    $target->coVaiTro('HR') ||                       // loại bỏ HR
                    $target->coVaiTro('department')                  // loại bỏ trưởng phòng
                ) {
                    abort(403, 'Bạn không có quyền xem bản ghi này.');
                }
        } else {
            abort(403, 'Bạn không có quyền xem bản ghi này.');
        }
        if (!$thucHienTangCa) {
            return back()->withErrors(['error' => 'Bản ghi tăng ca không tồn tại'])->withInput();
        }

        $validated = $request->validate([
            'nguoi_dung_id' => 'required|exists:nguoi_dung,id',
            'gio_vao' => 'required|date_format:H:i',
            'gio_ra' => 'nullable|date_format:H:i',
            'trang_thai' => 'required|in:chua_lam,dang_lam,hoan_thanh,khong_hoan_thanh',
            'ghi_chu' => 'nullable|string|max:1000',
        ], [
            'nguoi_dung_id.required' => 'Vui lòng chọn nhân viên',
            'nguoi_dung_id.exists' => 'Nhân viên không tồn tại',
            'gio_vao.required' => 'Vui lòng nhập giờ vào',
            'gio_vao.date_format' => 'Giờ vào không đúng định dạng (HH:MM)',
            'gio_ra.date_format' => 'Giờ ra không đúng định dạng (HH:MM)',
            'trang_thai.required' => 'Vui lòng chọn trạng thái',
            'trang_thai.in' => 'Trạng thái không hợp lệ',
            'ghi_chu.max' => 'Ghi chú không được vượt quá 1000 ký tự',
        ]);

        try {
            // Kiểm tra logic giờ vào và giờ ra
            if ($validated['gio_ra']) {
                $gioVao = Carbon::createFromFormat('H:i', $validated['gio_vao']);
                $gioRa = Carbon::createFromFormat('H:i', $validated['gio_ra']);

                if ($gioRa->lessThanOrEqualTo($gioVao)) {
                    $gioRa->addDay(); // Giả sử giờ ra là ngày tiếp theo nếu nhỏ hơn giờ vào
                }
            }

            // Chuẩn bị dữ liệu cập nhật
            $dataUpdate = [
                'gio_bat_dau_thuc_te' => $validated['gio_vao'],
                'gio_ket_thuc_thuc_te' => $validated['gio_ra'] ?? null,
                'trang_thai' => $validated['trang_thai'],
                'ghi_chu' => $validated['ghi_chu'],
            ];

            DB::beginTransaction();

            // Cập nhật bản ghi
            $thucHienTangCa->update($dataUpdate);

            // Tính toán số giờ tăng ca thực tế
            if ($thucHienTangCa->gio_ket_thuc_thuc_te) {
                $soGioTangCa = $thucHienTangCa->capNhatSoGio();

                // Cập nhật trạng thái dựa trên số giờ
                $trangThai = $thucHienTangCa->capNhatTrangThai($soGioTangCa);

                // Cập nhật số công tăng ca
                $soCong = $thucHienTangCa->capNhapSoCong($thucHienTangCa->loai_tang_ca, $soGioTangCa);

                // Cập nhật lại các giá trị tính toán
                $thucHienTangCa->update([
                    'so_gio_tang_ca_thuc_te' => $soGioTangCa,
                    'trang_thai' => $trangThai,
                    'so_cong_tang_ca' => $soCong
                ]);
            }

            DB::commit();

            return redirect()->route('admin.chamcong.tangCa.show', $thucHienTangCa->id)
                ->with('success', 'Cập nhật bản ghi chấm công thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            // \Log::error('Lỗi cập nhật chấm công: ' . $e->getMessage());

            return back()->withErrors([
                'error' => 'Có lỗi xảy ra khi cập nhật. Vui lòng thử lại!'
            ])->withInput();
        }
    }
    public function destroy($id){

        $thucHienTangCa = ThucHienTangCa::findOrFail($id);
        if(!$thucHienTangCa){
            return redirect()->route('admin.chamcong.tangCa.index')
            ->with('error', 'Bản ghi chấm công khôn tại!');
        }
        $user = auth()->user();

        if ($user->coVaiTro('Admin') || $user->coVaiTro('HR')) {
            // Admin, HR xem được hết
        } else if ($user->coVaiTro('department')) {
            // Department chỉ xem được nếu cùng phòng ban và không phải chính họ
            $target = $thucHienTangCa->dangKyTangCa->nguoiDung;

                if (
                    $target->phong_ban_id !== $user->phong_ban_id || // khác phòng ban
                    $target->id === $user->id ||                     // chính họ
                    $target->coVaiTro('Admin') ||                    // loại bỏ Admin
                    $target->coVaiTro('HR') ||                       // loại bỏ HR
                    $target->coVaiTro('department')                  // loại bỏ trưởng phòng
                ) {
                    abort(403, 'Bạn không có quyền xem bản ghi này.');
                }
        } else {
            abort(403, 'Bạn không có quyền xem bản ghi này.');
        }
        $thucHienTangCa->delete();
        return redirect()->route('admin.chamcong.tangCa.index')
            ->with('success', 'Xóa bản ghi chấm công!');
    }
    /**
     * Xuất dữ liệu chấm công theo yêu cầu
     */
    public function export(Request $request)
    {
        // dd($request->all());
        // Lấy dữ liệu theo điều kiện tìm kiếm
        $query = ThucHienTangCa::with(['dangKyTangCa', 'dangKyTangCa.nguoiDung.hoSo', 'dangKyTangCa.nguoiDung.phongBan','dangKyTangCa.nguoiDung'])
            ->orderBy('id', 'desc');

        // Áp dụng các filter giống như trong index
        $this->applyFilters($query, $request);

        $chamCong = $query->get();
        // dd($chamCong);
        // Tạo tên file
        $fileName = 'cham-cong-tang-ca' . date('Y-m-d-H-i-s');

        return Excel::download(new ChamCongTangCaExport($chamCong), $fileName . '.xlsx');
    }
    /**
     * Áp dụng các filter tìm kiếm
     */
    private function applyFilters($query, $request)
    {
        if ($request->filled('ten_nhan_vien')) {
            $query->whereHas('dangKyTangCa.nguoiDung.hoSo', function ($q) use ($request) {
                $q->where('ho', 'like', '%' . $request->ten_nhan_vien . '%')
                  ->orWhere('ten', 'like', '%' . $request->ten_nhan_vien . '%');
            });
        }

        if ($request->filled('phong_ban_id')) {
            $query->whereHas('dangKyTangCa.nguoiDung', function ($q) use ($request) {
                $q->where('phong_ban_id', $request->phong_ban_id);
            });
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        if ($request->filled('ngay_cham_cong')) {
            $query->whereHas('dangKyTangCa', function ($q) use ($request) {
                    $q->where('ngay_tang_ca', $request->get('ngay_cham_cong'));
            });
        }

        if ($request->filled('tu_ngay')) {
             $query->whereHas('dangKyTangCa', function ($q) use ($request) {
                $q->where('ngay_tang_ca', '>=', $request->get('tu_ngay'));
            });
        }

        if ($request->filled('den_ngay')) {
             $query->whereHas('dangKyTangCa', function ($q) use ($request) {
                    $q->where('ngay_tang_ca', '<=', $request->get('den_ngay'));
            });
        }

        if ($request->filled('thang') && $request->filled('nam')) {
                $query->whereHas('dangKyTangCa', function ($q) use ($request) {
                    $q->whereMonth('ngay_tang_ca', $request->get('thang'))
                      ->whereYear('ngay_tang_ca', $request->get('nam'));
                });
        } elseif ($request->filled('thang')) {
            $query->whereHas('dangKyTangCa', function ($q) use ($request) {
                    $q->whereMonth('ngay_tang_ca', $request->get('thang'));
            });
        } elseif ($request->filled('nam')) {
             $query->whereHas('dangKyTangCa', function ($q) use ($request) {
                    $q->whereYear('ngay_tang_ca', $request->get('nam'));
            });
        }
    }




}
