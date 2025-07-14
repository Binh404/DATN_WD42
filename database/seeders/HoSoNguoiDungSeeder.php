<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB; // ✅ Import đúng DB
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class HoSoNguoiDungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ho_so_nguoi_dung')->insert([
            [
                'id' => 1,
                'nguoi_dung_id' => 1,
                'ma_nhan_vien' => 'NV001',
                'ho' => 'Nguyễn',
                'ten' => 'Văn Admin',
                'email_cong_ty' => 'admin@company.com',
                'so_dien_thoai' => '0901234567',
                'ngay_sinh' => '1985-01-15',
                'gioi_tinh' => 'nam',
                'dia_chi_hien_tai' => '123 Đường ABC, Quận 1, TP.HCM',
                'dia_chi_thuong_tru' => '456 Đường XYZ, Huyện DEF, Tỉnh GHI',
                'cmnd_cccd' => '123456789012',
                'so_ho_chieu' => 'A1234567',
                'tinh_trang_hon_nhan' => 'da_ket_hon',
                'anh_dai_dien' => '/images/avatars/admin.jpg',
                'lien_he_khan_cap' => 'Nguyễn Thị B',
                'sdt_khan_cap' => '0987654321',
                'quan_he_khan_cap' => 'Vợ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nguoi_dung_id' => 2,
                'ma_nhan_vien' => 'HR001',
                'ho' => 'Trần',
                'ten' => 'Thị Mai',
                'email_cong_ty' => 'hr.manager@company.com',
                'so_dien_thoai' => '0901234568',
                'ngay_sinh' => '1988-05-20',
                'gioi_tinh' => 'nu',
                'dia_chi_hien_tai' => '789 Đường HR, Quận 2, TP.HCM',
                'dia_chi_thuong_tru' => '321 Đường Home, Huyện ABC, Tỉnh XYZ',
                'cmnd_cccd' => '123456789013',
                'so_ho_chieu' => null,
                'tinh_trang_hon_nhan' => 'doc_than',
                'anh_dai_dien' => '/images/avatars/hr-manager.jpg',
                'lien_he_khan_cap' => 'Trần Văn C',
                'sdt_khan_cap' => '0987654322',
                'quan_he_khan_cap' => 'Cha',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nguoi_dung_id' => 3,
                'ma_nhan_vien' => 'HR002',
                'ho' => 'Lê',
                'ten' => 'Văn Hùng',
                'email_cong_ty' => 'hr.staff@company.com',
                'so_dien_thoai' => '0901234569',
                'ngay_sinh' => '1992-08-10',
                'gioi_tinh' => 'nam',
                'dia_chi_hien_tai' => '456 Đường Staff, Quận 3, TP.HCM',
                'dia_chi_thuong_tru' => '654 Đường Origin, Huyện DEF, Tỉnh GHI',
                'cmnd_cccd' => '123456789014',
                'so_ho_chieu' => null,
                'tinh_trang_hon_nhan' => 'doc_than',
                'anh_dai_dien' => '/images/avatars/hr-staff.jpg',
                'lien_he_khan_cap' => 'Lê Thị D',
                'sdt_khan_cap' => '0987654323',
                'quan_he_khan_cap' => 'Mẹ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'nguoi_dung_id' => 4,
                'ma_nhan_vien' => 'IT001',
                'ho' => 'Phạm',
                'ten' => 'Minh Tuấn',
                'email_cong_ty' => 'it.manager@company.com',
                'so_dien_thoai' => '0901234570',
                'ngay_sinh' => '1986-12-25',
                'gioi_tinh' => 'nam',
                'dia_chi_hien_tai' => '789 Đường IT, Quận 4, TP.HCM',
                'dia_chi_thuong_tru' => '987 Đường Tech, Huyện GHI, Tỉnh JKL',
                'cmnd_cccd' => '123456789015',
                'so_ho_chieu' => 'B7654321',
                'tinh_trang_hon_nhan' => 'da_ket_hon',
                'anh_dai_dien' => '/images/avatars/it-manager.jpg',
                'lien_he_khan_cap' => 'Phạm Thị E',
                'sdt_khan_cap' => '0987654324',
                'quan_he_khan_cap' => 'Vợ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'nguoi_dung_id' => 5,
                'ma_nhan_vien' => 'IT002',
                'ho' => 'Nguyễn',
                'ten' => 'Minh Hùng',
                'email_cong_ty' => 'it.staff@company.com',
                'so_dien_thoai' => '0901234571',
                'ngay_sinh' => '1990-07-15',
                'gioi_tinh' => 'nam',
                'dia_chi_hien_tai' => '123 Đường Staff, Quận 5, TP.HCM',
                'dia_chi_thuong_tru' => '321 Đường Origin, Huyện DEF, Tийnh GHI',
                'cmnd_cccd' => '123456789016',
                'so_ho_chieu' => null,
                'tinh_trang_hon_nhan' => 'doc_than',
                'anh_dai_dien' => '/images/avatars/it-staff.jpg',
                'lien_he_khan_cap' => 'Nguyễn Thị F',
                'sdt_khan_cap' => '0987654325',
                'quan_he_khan_cap' => 'Mẹ',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);


    }
}
