<?php 

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PasswordOTPController extends Controller
{
public function sendOtp(Request $request)
{
$user = Auth::user();
$otp = rand(100000, 999999);

// Lưu OTP vào session (hoặc database)
Session::put('password_otp', $otp);
Session::put('otp_expires', now()->addMinutes(5));

// Gửi OTP qua email
Mail::raw("Mã OTP của bạn là: $otp", function ($message) use ($user) {
$message->to($user->email)->subject('Xác thực đổi mật khẩu');
});

return redirect()->route('password.otp-form')->with('status', 'Mã OTP đã được gửi đến email của bạn.');
}

    public function verifyOtp(Request $request)
        {
            $request->validate([
                'otp' => 'required|numeric',
                'password' => 'required|string|confirmed|min:8',
            ]);

                $otp = Session::get('password_otp');
                $expires = Session::get('otp_expires');

            if (!$otp || !$expires || now()->gt($expires)) {
                return back()->withErrors(['otp' => 'Mã OTP đã hết hạn.']);
            }

            if ($request->otp != $otp) {
                return back()->withErrors(['otp' => 'Mã OTP không đúng.']);
            }

                // Cập nhật mật khẩu
                $user = Auth::user();
                $user->password = Hash::make($request->password);
                $user->save();

                // Xóa session OTP
                Session::forget(['password_otp', 'otp_expires']);

                return redirect()->route('profile.edit')->with('status', 'Mật khẩu đã được cập nhật.');
        }
}