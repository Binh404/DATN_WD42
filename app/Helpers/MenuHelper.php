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
                // 'tintuyendung',
                // 'thongbao',
                'duyetdon',
                'xinnghiphep',
                'loainghiphep'
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
                'hoso' => ['qlhoso'],
                'chamcong' => ['danhsach', 'pheduyet', 'tangca', 'vitri'],
                'ungvien' => ['danhsach', 'phongvan', 'emaildagui', 'trungtuyen', 'luutru'],
                'duyetdon' => ['tuyendung'],
                'luong' => ['luong', 'phieuluong'],
                'xinnghiphep' => ['danhsach']

            ],
            'hr' => [
                'hoso' => ['qlhoso', 'hosocn'],
                'ungvien' => ['danhsach', 'phongvan', 'emaildagui', 'trungtuyen', 'luutru'],
                'chamcong' => ['danhsach', 'pheduyet', 'tangca'],
                'duyetdon' => [ 'xinnghiphep'],
                'xinnghiphep' => ['danhsach']

            ],
            'department' => [
                'hoso' => ['qlhoso', 'hosocn'],

                'chamcong' => ['danhsach', 'pheduyet', 'tangca', 'chamcong', 'donxintangca'],
                'duyetdon' => ['xinnghiphep'],
                'xinnghiphep' => ['danhsach','donxinnghiphep']

            ],
            'employee' => [
                'chamcong' => [ 'chamcong', 'donxintangca'],
                'hoso' => ['hosocn'],
                'xinnghiphep' => ['donxinnghiphep']

            ]
        ];

        return isset($subMenuPermissions[$userRole][$menuKey]) &&
               in_array($subMenuKey, $subMenuPermissions[$userRole][$menuKey]);
    }
}