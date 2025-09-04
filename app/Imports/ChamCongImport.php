<?php

namespace App\Imports;

use App\Models\BangLuong;
use App\Models\ChamCong;
use App\Models\Luong;
use App\Models\NguoiDung;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Exception;
use Throwable;

class ChamCongImport implements WithMultipleSheets
{
    use Importable;

    protected $errors = [];
    protected $successCount = 0;
    protected $skipCount = 0;

    public function sheets(): array
    {
        return [
            'Dữ liệu chấm công' => new ChamCongDataImport($this),
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

class ChamCongDataImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    protected $errors = [];
    protected $successCount = 0;
    protected $skipCount = 0;
    protected $parentImport;

    public function __construct(ChamCongImport $parentImport)
    {
        $this->parentImport = $parentImport;
    }

    public function collection(Collection $rows)
    {
        DB::beginTransaction();

        try {
            foreach ($rows as $index => $row) {
                $this->processRow($row, $index + 2);
            }

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
        // dd($row);
        try {
            // Kiểm tra các trường bắt buộc
            if (!isset($row['email']) || empty($row['email'])) {
                $this->errors[] = "Dòng {$rowNumber}: Thiếu email";
                $this->skipCount++;
                return;
            }

            if (!isset($row['ngay_cham_cong']) || empty($row['ngay_cham_cong'])) {
                $this->errors[] = "Dòng {$rowNumber}: Thiếu ngày chấm công";
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
            $ngayChamCong = Carbon::parse($ngayChamCong);
            $daChot = BangLuong::where('nguoi_xu_ly_id', $user->id)
                ->where('thang', $ngayChamCong->format('m'))
                ->where('nam', $ngayChamCong->format('Y'))
                ->exists();
            if ($daChot) {
                $this->errors[] = "Dòng {$rowNumber}: Lương tháng {$ngayChamCong->format('m/Y')} của {$row['email']} đã chốt";
                $this->skipCount++;
                return;
            }

            // Kiểm tra trùng lặp
            $existingRecord = ChamCong::kiemTraDaChamCong($user->id, $ngayChamCong);
            if ($existingRecord) {
                $this->errors[] = "Dòng {$rowNumber}: Đã tồn tại chấm công cho {$row['email']} ngày {$row['ngay_cham_cong']}";
                $this->skipCount++;
                return;
            }

            // Tạo bản ghi chấm công
            $chamCong = new ChamCong();
            $chamCong->nguoi_dung_id = $user->id;
            $chamCong->ngay_cham_cong = $ngayChamCong;

            // Chỉ parse những trường có dữ liệu
            $chamCong->gio_vao = $row['gio_vao'] ?? null;
            $chamCong->gio_ra = $row['gio_ra'] ?? null;
            // $chamCong->gio_vao = $this->parseDateTime($row['gio_vao'] ?? null, $ngayChamCong);
            // $chamCong->gio_ra = $this->parseDateTime($row['gio_ra'] ?? null, $ngayChamCong);
            $chamCong->ghi_chu = $row['ghi_chu'] ?? null;
            // dump($chamCong->gio_vao);
            $chamCong->trang_thai_duyet = 1;
            $chamCong->ghi_chu_duyet = "Thêm từ file excel";

            // Sử dụng method từ model để tự động tính toán
            $chamCong = $chamCong->capNhatTrangThai();
            // $chamCong->so_gio_lam = $chamCong->tinhSoGioLam();
            // $chamCong->so_cong = $chamCong->tinhSoCong();

            $chamCong->save();

            $this->successCount++;

        } catch (Throwable $e) {
            $this->errors[] = "Dòng {$rowNumber}: " . $e->getMessage();
            $this->skipCount++;
        }
    }

    protected function parseDate($dateString)
    {
        if (empty($dateString)) {
            return null;
        }

        try {
            $formats = ['Y-m-d', 'd/m/Y', 'm/d/Y', 'd-m-Y', 'Y/m/d'];

            foreach ($formats as $format) {
                $date = \DateTime::createFromFormat($format, $dateString);
                if ($date && $date->format($format) === $dateString) {
                    return $date->format('Y-m-d');
                }
            }

            return Carbon::parse($dateString)->format('Y-m-d');
        } catch (Exception $e) {
            return null;
        }
    }

    protected function parseDateTime($timeString, $date)
    {
        if (empty($timeString)) {
            return null;
        }

        try {
            // Nếu đã là datetime đầy đủ
            if (strlen($timeString) > 8) {
                return Carbon::parse($timeString);
            }

            // Nếu chỉ là time, kết hợp với ngày
            $time = Carbon::createFromFormat('H:i', $timeString);
            return Carbon::parse($date)->setTime($time->hour, $time->minute, 0);
        } catch (Exception $e) {
            return null;
        }
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string',
            'ngay_cham_cong' => 'required|string',
            'gio_vao' => 'nullable|string',
            'gio_ra' => 'nullable|string',
            'ghi_chu' => 'nullable|string',
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

    // Header mapping tối giản cho file Excel/CSV
    public function getHeaderMapping()
    {
        return [
            'Email' => 'email',
            'Ngày chấm công' => 'ngay_cham_cong',
            'Giờ vào' => 'gio_vao',
            'Giờ ra' => 'gio_ra',
            'Ghi chú' => 'ghi_chu'
        ];
    }
}
