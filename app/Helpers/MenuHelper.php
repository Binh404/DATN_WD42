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
        $userRole = optional($user->vaiTros)->pluck('ten')->toArray()[0];
        // dd($userRole);
        $menuPermissions = [
            'admin' => [
                'dashboard',
                'hoso',
                'phongban',
                'luong',
                'chamcong',
                'ungvien',
                'hopdong',
                // 'tintuyendung',
                'thongbao',
                'duyetdon',
                // 'xinnghiphep',
                'loainghiphep',
                'dondexuat'

            ],
            'hr' => [
                'dashboard',
                'hoso',
                'phongban',
                'ungvien',
                'luong',
                'chamcong',
                'hopdong',
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
                'dondexuat'
            ],
            'employee' => [
                'dashboard',
                'hoso',
                'chamcong',
                'xinnghiphep',
                'luong'
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
        $userRole = optional($user->vaiTros)->pluck('ten')->toArray()[0];
        // dd($userRole);
        $subMenuPermissions = [
            'admin' => [
                'hoso' => ['qlhoso','qltk'],
                'chamcong' => ['danhsach', 'pheduyet', 'tangca', 'vitri', 'importcc'],
                'ungvien' => ['danhsach', 'phongvan', 'emaildagui', 'trungtuyen', 'luutru'],
                'duyetdon' => ['tuyendung', 'xinnghiphep'],
                'luong' => ['luong', 'phieuluong'],
                'dondexuat' => ['danhsach'],

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


            ],
            'department' => [
                'hoso' => [ 'hosocn'],

                'chamcong' => ['danhsach', 'pheduyet', 'tangca', 'chamcong', 'donxintangca'],
                'duyetdon' => ['xinnghiphep'],
                'xinnghiphep' => ['danhsach', 'donxinnghiphep'],
                'dondexuat' => ['guidexuat'],

            ],
            'employee' => [
                'chamcong' => ['chamcong', 'donxintangca'],
                'hoso' => ['hosocn'],
                'xinnghiphep' => ['donxinnghiphep'],
                'luong' => ['phieuluongnv']

            ]
        ];

        return isset($subMenuPermissions[$userRole][$menuKey]) &&
            in_array($subMenuKey, $subMenuPermissions[$userRole][$menuKey]);
    }
}
