<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;



class LoginController extends Controller
{
    use VerifyRecaptcha;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): RedirectResponse
    {
        try {
            // 1. Validate the incoming request
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
                'g-recaptcha-response' => ['required'],
            ], [
                'email.required' => 'Email là bắt buộc.',
                'email.email' => 'Email không hợp lệ.',
                'password.required' => 'Mật khẩu là bắt buộc.',
                'g-recaptcha-response.required' => 'Vui lòng xác minh reCAPTCHA.',
            ]);
            // Verify reCAPTCHA
            if (!$this->verifyRecaptcha($request)) {
                Log::channel('login')->warning('reCAPTCHA verification failed.');
                return back()->withErrors(['captcha' => 'Xác minh reCAPTCHA không thành công.']);
            }

            // Attempt authentication
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                // Check if the user account is active
                if ($user->trang_thai == 0) {
                    // If the account is inactive, log out the user
                    Auth::logout();
                    Log::channel('login')->warning('Login attempt failed - account inactive.', ['email' => $user->email, 'ip' => $request->ip()]);
                    return back()->withErrors(['auth_failed' => 'Tài khoản của bạn đã bị vô hiệu hóa.']);
                }

                // Regenerate session to prevent session fixation attacks
                $request->session()->regenerate();
                Log::channel('login')->info('User logged in successfully.', [
                    'email' => $request->input('email'),
                    'timestamp' => Carbon::now()->toDateTimeString(),
                    'ip' => $request->ip(),
                    'user_agent' => $request->header('User-Agent')
                ]);
                return redirect()->intended(route('dashboard.index'));
            }

            //Handle failed authentication
            Log::channel('login')->warning('Failed login attempt.', [
                'email' => $request->input('email'),
                'ip' => $request->ip(),
            ]);
            return back()->withErrors([
                'auth_failed' => 'Email hoặc mật khẩu không chính xác.',
            ]);
        } catch (ValidationException $e) {
            // Log validation errors
            Log::channel('login')->error('Login validation failed.', [
                'errors' => $e->errors(),
                'input_email' => $request->input('email'),
                'ip' => $request->ip(),
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            // Catch any other unexpected errors
            Log::channel('login')->error('An unexpected error occurred during login.', [
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'email' => $request->input('email'),
                'ip' => $request->ip(),
            ]);
            return back()->withErrors(['error-login' => 'Đã xảy ra lỗi không mong muốn. Vui lòng thử lại sau.']);
        }
    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Ghi log đăng xuất nếu có người dùng đăng nhập
        if ($user) {
            Log::channel('login')->info('Đăng xuất thành công', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'time' => now()->format('Y-m-d H:i:s')
            ]);
        }
        return redirect()->route('auth.login.form');
    }
}
