<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuPermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
         // Chia sẻ menu permissions cho tất cả views
        View::composer('*', function ($view) {
            $menuPermissions = $this->getMenuPermissions();
            $view->with('menuPermissions', $menuPermissions);
        });
    }
    private function getMenuPermissions()
    {
        return [
            'admin' => [
                'dashboard',
                'hoso',
                'phongban',
                'luong',
                'chamcong',
                'ungvien',
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
    }
}
