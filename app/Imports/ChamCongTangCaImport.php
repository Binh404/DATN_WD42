<?php

namespace App\Imports;

use App\Models\DangKyTangCa;
use App\Models\NguoiDung;
use App\Models\thucHienTangCa;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ChamCongTangCaImport implements WithMultipleSheets
{
    use Importable;

    protected $errors = [];
    protected $successCount = 0;
    protected $skipCount = 0;

    public function sheets(): array
    {
        return [
            'Dữ liệu chấm công' => new ChamCongTangCaDataImport($this),
        ];
    }

    public function addResults(array $errors, int $successCount, int $skipCount)
    {
        $this->errors = array_merge($this->errors, $errors);
        $this->successCount += $successCount;
        $this->skipCount += $skipCount;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    public function getSkipCount(): int
    {
        return $this->skipCount;
    }
}

class ChamCongTangCaDataImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    protected $errors = [];
    protected $successCount = 0;
    protected $skipCount = 0;
    protected $parentImport;

    public function __construct(ChamCongTangCaImport $parentImport)
    {
        $this->parentImport = $parentImport;
    }

    public function collection(Collection $rows)
    {
        DB::beginTransaction();

        try {
            foreach ($rows as $index => $row) {
                $this->processRow($row, $index + 2); // +2 vì có header
            }

            // Truyền kết quả lên parent import
            $this->parentImport->addResults($this->errors, $this->successCount, $this->skipCount);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();
            Log::error('Import ChamCong failed: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function processRow($row, $rowNumber)
    {
        try {
            // Kiểm tra sự tồn tại của các cột bắt buộc
            if (!isset($row['email']) || empty($row['email'])) {
                $this->errors[] = "Dòng {$rowNumber}: Thiếu hoặc không hợp lệ cột email";
                $this->skipCount++;
                return;
            }

            if (!isset($row['ngay_cham_cong']) || empty($row['ngay_cham_cong'])) {
                $this->errors[] = "Dòng {$rowNumber}: Thiếu hoặc không hợp lệ cột ngày chấm công";
                $this->skipCount++;
                return;
            }

            // Tìm user theo email
            $user = NguoiDung::where('email', $row['email'])->first();

            if (!$user) {
                $this->errors[] = "Dòng {$rowNumber}: Không tìm thấy nhân viên với email {$row['email']}";
                $this->skipCount++;
                return;
            }

            // Parse ngày chấm công
            $ngayChamCong = $this->parseDate($row['ngay_cham_cong']);
            if (!$ngayChamCong) {
                $this->errors[] = "Dòng {$rowNumber}: Ngày chấm công không hợp lệ";
                $this->skipCount++;
                return;
            }

            // Tìm hoặc tạo đăng ký tăng ca
            $dangKyTangCa = $this->findOrCreateDangKyTangCa($user->id, $ngayChamCong, $row);
            // dd($dangKyTangCa);
            // Parse thời gian thực tế
            $gioVaoThucTe = $this->parseTime($row['gio_vao_thuc_te'] ?? null);
            $gioRaThucTe = $this->parseTime($row['gio_ra_thuc_te'] ?? null);

            // Cập nhật số giờ tăng ca dự kiến
            // $dangKyTangCa->gio_bat_dau = $this->parseTime($row['gio_vao_thuc_te'] ?? '18:00');
            // $dangKyTangCa->gio_ket_thuc = $this->parseTime($row['gio_ra_thuc_te'] ?? '22:00');
            // dump([
            //     'gio_bat_dau' => $dangKyTangCa->gio_bat_dau,
            //     'gio_ket_thuc' => $dangKyTangCa->gio_ket_thuc,
            // ]);

            // $dangKyTangCa->tinhSoGioTangCa(); // Cập nhật so_gio_tang_ca

            // $dangKyTangCa->save();
            // dump('Số giờ:', $dangKyTangCa->so_gio_tang_ca);

            // dd($dangKyTangCa);

            // Tạo hoặc cập nhật bản ghi chấm công
            $chamCong = thucHienTangCa::updateOrCreate(
                [
                    'dang_ky_tang_ca_id' => $dangKyTangCa->id,
                ],
                [
                    'gio_bat_dau_thuc_te' => $gioVaoThucTe,
                    'gio_ket_thuc_thuc_te' => $gioRaThucTe,
                    'so_gio_tang_ca_thuc_te' => 0, // Sẽ được cập nhật bởi capNhatSoGio
                    'so_cong_tang_ca' => 0, // Sẽ được cập nhật bởi capNhapSoCong
                    'trang_thai' => 'chua_lam', // Sẽ được cập nhật bởi capNhatTrangThai
                    'ghi_chu' => $row['ghi_chu'] ?? '',
                ]
            );

            // Cập nhật số giờ tăng ca thực tế
            if ($gioVaoThucTe && $gioRaThucTe) {
                $chamCong->gio_bat_dau_thuc_te = $gioVaoThucTe;
                $chamCong->gio_ket_thuc_thuc_te = $gioRaThucTe;
                $chamCong->capNhatSoGio();
            }

            // Cập nhật trạng thái
            $soGioDuKien = $dangKyTangCa->so_gio_tang_ca ?? 0;
            $chamCong->capNhatTrangThai($soGioDuKien);

            // Cập nhật số công
            $loaiTangCa = $dangKyTangCa->loai_tang_ca ?? 'ngay_thuong';
            $chamCong->capNhapSoCong($loaiTangCa, $soGioDuKien);

            // Lưu bản ghi
            $chamCong->save();
            // dd($chamCong);
            $this->successCount++;

        } catch (Throwable $e) {
            $this->errors[] = "Dòng {$rowNumber}: " . $e->getMessage();
            $this->skipCount++;
        }
    }

    protected function parseDate($dateString)
    {
        try {
            if (empty($dateString)) {
                return null;
            }
            return Carbon::createFromFormat('d/m/Y', $dateString)->format('Y-m-d');
        } catch (Throwable $e) {
            return null;
        }
    }

    protected function parseTime($timeString)
    {
        try {
            if (empty($timeString)) {
                return null;
            }
            return Carbon::createFromFormat('H:i', $timeString)->format('H:i:s');
        } catch (Throwable $e) {
            return null;
        }
    }

    protected function findOrCreateDangKyTangCa($userId, $ngayTangCa, $row)
    {
        return DangKyTangCa::firstOrCreate(
            [
                'nguoi_dung_id' => $userId,
                'ngay_tang_ca' => $ngayTangCa,
            ],
            [
                'gio_bat_dau' => $this->parseTime($row['gio_vao_thuc_te'] ?? '18:00'),
                'gio_ket_thuc' => $this->parseTime($row['gio_ra_thuc_te'] ?? '22:00'),
                'so_gio_tang_ca' => isset($row['so_gio_lam']) ? floatval($row['so_gio_lam']) : 4,
                'loai_tang_ca' => $row['loai_tang_ca'] ?? 'ngay_thuong',
                'trang_thai' => 'da_duyet',
                'ly_do_tang_ca' => $row['ly_do_tang_ca'] ?? 'Import từ Excel',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string',
            'ngay_cham_cong' => 'required|string',
            'gio_vao_thuc_te' => 'nullable|string',
            'gio_ra_thuc_te' => 'nullable|string',
            'so_gio_lam' => 'nullable|numeric',
            'so_cong' => 'nullable|numeric',
            'trang_thai' => 'nullable|string',
            'ghi_chu' => 'nullable|string',
            'loai_tang_ca' => 'nullable|string',
            'ly_do_tang_ca' => 'nullable|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'email.required' => 'Email là bắt buộc',
            'ngay_cham_cong.required' => 'Ngày chấm công là bắt buộc',
        ];
    }

    public function onError(Throwable $error)
    {
        $this->errors[] = $error->getMessage();
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->errors[] = "Dòng {$failure->row()}: " . implode(', ', $failure->errors());
        }
    }
}
