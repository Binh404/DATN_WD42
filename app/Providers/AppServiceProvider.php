<?php

namespace App\Providers;

use App\Models\HoSoNguoiDung;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive(); // Hiển thị phân trang theo Bootstrap 5
        View::composer('layoutsEmploye.*', function ($view) {
        $nguoiDung = Auth::user();

        if ($nguoiDung) {
            $hoSo = HoSoNguoiDung::where('nguoi_dung_id', $nguoiDung->id)->first();
            $view->with('nguoiDung', $nguoiDung)->with('hoSo', $hoSo);
        }
    });
    }
}
