<?php

namespace App\Providers;

use App\Models\HoSoNguoiDung;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;



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
        Route::aliasMiddleware('role', CheckRole::class);
        Paginator::useBootstrapFive(); // Hiển thị phân trang theo Bootstrap 5
        View::composer('layoutsEmploye.*', function ($view) {
        $nguoiDung = Auth::user();

        if ($nguoiDung) {
            $hoSo = HoSoNguoiDung::where('nguoi_dung_id', $nguoiDung->id)->first();
            $view->with('nguoiDung', $nguoiDung)->with('hoSo', $hoSo);
        }
    });
    View::composer('layoutsAdmin.*', function ($view) {
        if (Auth::check()) {
            $user = Auth::user();
            $notifications = $user->notifications()->take(5)->get();
            $unreadCount = $user->unreadNotifications()->count();
            $view->with(compact('notifications', 'unreadCount'));
        }
    });
    }
}
