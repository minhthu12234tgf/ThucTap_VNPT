<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // Logic to handle password reset link sending

        // This is typically done using a notification or mail service

        return back()->with('status', 'Link đặt lại mật khẩu đã được gửi đến email của bạn.');
    }
}
