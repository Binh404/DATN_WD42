<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ThemeController extends Controller
{
    public function toggle(): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            $user->theme = $user->theme === 'dark' ? 'light' : 'dark';
            $user->save();
        }

        return redirect()->back();
    }
}