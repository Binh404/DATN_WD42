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
                // 'ungvien',
                'hopdong',
                'tintuyendung',
                'thongbao',
                'duyetdon',
                'xinnghiphep',
                'loainghiphep'
            ],
            'hr' => [
                'dashboard',
                'hoso',
                'phongban',
                'ungvien',
                'hopdong',
                'tintuyendung',
                'thongbao',
                'duyetdon',
                'xinnghiphep',
                'loainghiphep'
            ],
            'department' => [
                'dashboard',
                'hoso',
                'chamcong',
                'duyetdon',
                'xinnghiphep'
            ],
            'employee' => [
                'dashboard',
                'hoso',
                'chamcong',
                'xinnghiphep'
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
                'chamcong' => ['danhsach', 'pheduyet', 'tangca', 'vitri'],
                'ungvien' => ['danhsach', 'phongvan', 'emaildagui', 'trungtuyen', 'luutru'],
                'duyetdon' => ['tuyendung'],
                'luong' => ['luong', 'phieuluong']
            ],
            'hr' => [
                'ungvien' => ['danhsach', 'phongvan', 'emaildagui', 'trungtuyen', 'luutru'],
                'duyetdon' => ['tuyendung', 'xinnghiphep']
            ],
            'department' => [
                'chamcong' => ['danhsach', 'pheduyet', 'tangca'],
                'duyetdon' => ['xinnghiphep']
            ],
            'employee' => [
                'chamcong' => ['danhsach']
            ]
        ];

        return isset($subMenuPermissions[$userRole][$menuKey]) &&
               in_array($subMenuKey, $subMenuPermissions[$userRole][$menuKey]);
    }
}
