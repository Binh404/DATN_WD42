<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class HopDongRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'nguoi_dung_id' => 'required|exists:nguoi_dung,id',
            'chuc_vu_id' => 'required|exists:chuc_vu,id',
            'loai_hop_dong' => 'required|string',
            'ngay_bat_dau' => [
                'required',
                'date',
            ],
            'ngay_ket_thuc' => [
                'required',
                'date',
                'after:ngay_bat_dau', // Ngày kết thúc > ngày bắt đầu
            ],
            'luong_co_ban' => 'required|numeric|min:0',
            'phu_cap' => 'nullable|numeric|min:0',
            'hinh_thuc_lam_viec' => 'required|string',
            'dia_diem_lam_viec' => 'required|string',
            'dieu_khoan' => 'required|string',
            'ghi_chu' => 'nullable|string',
        ];

        // Thêm validation cho file nếu là tạo mới
        if ($this->isMethod('POST')) {
            $rules['so_hop_dong'] = 'required|string|unique:hop_dong_lao_dong,so_hop_dong';
            $rules['file_hop_dong'] = 'required|file|mimes:pdf,doc,docx|max:2048';
            // Thêm validation ngày bắt đầu >= ngày hiện tại chỉ khi tạo mới
            $rules['ngay_bat_dau'][] = 'after_or_equal:today';
        } else {
            // Nếu là cập nhật, file không bắt buộc
            $rules['file_hop_dong'] = 'nullable|file|mimes:pdf,doc,docx|max:2048';
            $rules['trang_thai_ky'] = 'required|in:cho_ky,da_ky';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nguoi_dung_id.required' => 'Vui lòng chọn nhân viên.',
            'nguoi_dung_id.exists' => 'Nhân viên không tồn tại.',
            'chuc_vu_id.required' => 'Vui lòng chọn chức vụ.',
            'chuc_vu_id.exists' => 'Chức vụ không tồn tại.',
            'so_hop_dong.required' => 'Vui lòng nhập số hợp đồng.',
            'so_hop_dong.unique' => 'Số hợp đồng đã tồn tại.',
            'loai_hop_dong.required' => 'Vui lòng chọn loại hợp đồng.',
            'ngay_bat_dau.required' => 'Vui lòng chọn ngày bắt đầu.',
            'ngay_bat_dau.date' => 'Ngày bắt đầu không hợp lệ.',
            'ngay_bat_dau.after_or_equal' => 'Ngày bắt đầu phải từ ngày hôm nay trở đi.',
            'ngay_ket_thuc.required' => 'Vui lòng chọn ngày kết thúc.',
            'ngay_ket_thuc.date' => 'Ngày kết thúc không hợp lệ.',
            'ngay_ket_thuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'luong_co_ban.required' => 'Vui lòng nhập lương cơ bản.',
            'luong_co_ban.numeric' => 'Lương cơ bản phải là số.',
            'luong_co_ban.min' => 'Lương cơ bản không được âm.',
            'phu_cap.numeric' => 'Phụ cấp phải là số.',
            'phu_cap.min' => 'Phụ cấp không được âm.',
            'hinh_thuc_lam_viec.required' => 'Vui lòng chọn hình thức làm việc.',
            'dia_diem_lam_viec.required' => 'Vui lòng nhập địa điểm làm việc.',
            'dieu_khoan.required' => 'Vui lòng nhập điều khoản hợp đồng.',
            'file_hop_dong.required' => 'Vui lòng chọn file hợp đồng.',
            'file_hop_dong.file' => 'File hợp đồng không hợp lệ.',
            'file_hop_dong.mimes' => 'File hợp đồng phải có định dạng PDF, DOC hoặc DOCX.',
            'file_hop_dong.max' => 'File hợp đồng không được vượt quá 2MB.',
            'trang_thai_ky.required' => 'Vui lòng chọn trạng thái ký.',
            'trang_thai_ky.in' => 'Trạng thái ký không hợp lệ.',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Kiểm tra thêm logic phức tạp nếu cần
            $ngayBatDau = $this->input('ngay_bat_dau');
            $ngayKetThuc = $this->input('ngay_ket_thuc');

            if ($ngayBatDau && $ngayKetThuc) {
                $batDau = Carbon::parse($ngayBatDau);
                $ketThuc = Carbon::parse($ngayKetThuc);
                $today = Carbon::today();

                // Kiểm tra ngày bắt đầu >= ngày hiện tại chỉ khi tạo mới
                if ($this->isMethod('POST') && $batDau->lt($today)) {
                    $validator->errors()->add('ngay_bat_dau', 'Ngày bắt đầu >= Ngày hiện tại.');
                }

                // Kiểm tra ngày kết thúc > ngày bắt đầu
                if ($ketThuc->lte($batDau)) {
                    $validator->errors()->add('ngay_ket_thuc', 'Ngày kết thúc > Ngày bắt đầu.');
                }

                // Kiểm tra thời hạn hợp đồng không quá ngắn (tùy chọn)
                $soNgay = $batDau->diffInDays($ketThuc);
                if ($soNgay < 1) {
                    $validator->errors()->add('ngay_ket_thuc', 'Thời hạn hợp đồng phải ít nhất 1 ngày.');
                }
            }
        });
    }
} 