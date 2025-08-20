<?php

namespace App\Helpers;

class MenuHelper
{
    public static function hasMenuPermission($menuKey)
    {
        if (!auth()->check()) {
            // dd('false');
            return false;
        }

        $user = auth()->user();
        $userRole = optional($user->vaiTros)->pluck('name')->toArray()[0];
        // dd($userRole);
        $menuPermissions = [
            'admin' => [
                'dashboard',
                'hoso',
                'phongban',
                'luong',
                'chamcong',
                'ungvien',
                // 'hopdong', // Admin không cần xem "Hợp đồng của tôi"
                'hopdong_quanly', // Quản lý hợp đồng (danh sách, lưu trữ, thống kê)
                // 'tintuyendung',
                // 'thongbao',
                'duyetdon',
                // 'xinnghiphep',
                'loainghiphep',
                // 'dondexuat',
                'thongke',
                'vaitro',
                'chucvu',
                'phongban'

            ],
            'hr' => [
                'dashboard',
                'hoso',
                'phongban',
                'ungvien',
                'luong',
                'chamcong',
                'hopdong',
                'hopdong_quanly', // Quản lý hợp đồng (danh sách, lưu trữ, thống kê)
                'tintuyendung',
                'thongbao',
                'duyetdon',
                'xinnghiphep',
                'loainghiphep',
                'dondexuat'
            ],
            'department' => [
                'dashboard',
                'yeucautuyendung',
                'hoso',
                'chamcong',
                'duyetdon',
                'xinnghiphep',
                'dondexuat',
                'hopdong' // Chỉ xem hợp đồng của mình
            ],
            'employee' => [
                'dashboard',
                'hoso',
                'chamcong',
                'xinnghiphep',
                'luong',
                'hopdong' // Chỉ xem hợp đồng của mình
            ]
        ];

        return isset($menuPermissions[$userRole]) &&
            in_array($menuKey, $menuPermissions[$userRole]);
    }

    public static function hasSubMenuPermission($menuKey, $subMenuKey)
    {
        if (!self::hasMenuPermission($menuKey)) {
            // dd('false');
            return false;
        }

        $user = auth()->user();
        $userRole = optional($user->vaiTros)->pluck('name')->toArray()[0];
        // dd($userRole);
        $subMenuPermissions = [
            'admin' => [
                'hoso' => ['qlhoso','qltk'],
                'chamcong' => ['danhsach', 'pheduyet', 'tangca', 'vitri', 'importcc'],
                'ungvien' => ['danhsach', 'phongvan', 'emaildagui', 'trungtuyen', 'luutru'],
                'duyetdon' => ['tuyendung', 'xinnghiphep'],
                'luong' => ['luong', 'phieuluong', 'danhsach'],
                'dondexuat' => ['danhsach'],
                'vaitro' => ['danhsach'],
                'chucvu' => ['danhsach'],
                'phongban' => ['danhsach'],
                // 'hopdong' => ['cua_toi'], // Admin không cần xem "Hợp đồng của tôi"
                'hopdong_quanly' => ['danhsach', 'luutru'], // Quản lý hợp đồng

                'thongke' => ['hopdong', 'chamcong', 'luong'],


                // 'xinnghiphep' => ['danhsach']

            ],
            'hr' => [
                'hoso' => ['qlhoso', 'hosocn'],
                'luong' => ['luong', 'phieuluong'],

                'ungvien' => ['danhsach', 'phongvan', 'emaildagui', 'trungtuyen', 'luutru'],
                'chamcong' => ['danhsach', 'pheduyet', 'tangca'],
                'duyetdon' => ['xinnghiphep'],
                'xinnghiphep' => ['danhsach', 'donxinnghiphep'],
                'thongbaotuyendung' => ['danhsach'],
                'dondexuat' => ['guidexuat'],
                'hopdong' => ['cua_toi'], // Chỉ xem hợp đồng của mình
                'hopdong_quanly' => ['danhsach', 'luutru'], // Quản lý hợp đồng


            ],
            'department' => [
                'hoso' => [ 'hosocn'],

                'chamcong' => ['danhsach', 'pheduyet', 'tangca', 'chamcong', 'donxintangca'],
                'duyetdon' => ['xinnghiphep'],
                'xinnghiphep' => ['danhsach', 'donxinnghiphep'],
                'dondexuat' => ['guidexuat'],
                'hopdong' => ['cua_toi'], // Chỉ xem hợp đồng của mình

            ],
            'employee' => [
                'chamcong' => ['chamcong', 'donxintangca'],
                'hoso' => ['hosocn'],
                'xinnghiphep' => ['donxinnghiphep'],
                'luong' => ['phieuluongnv'],
                'hopdong' => ['cua_toi'] // Chỉ xem hợp đồng của mình

            ]
        ];

        return isset($subMenuPermissions[$userRole][$menuKey]) &&
            in_array($subMenuKey, $subMenuPermissions[$userRole][$menuKey]);
    }
}
