<?php

namespace App\Http\Controllers;

use App\Models\YeuCau;
use App\Models\KhachHang;
use App\Models\NhanVien;
use App\Models\LichSuPhanCong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IncidentController extends Controller
{
    public function index()
    {
        try {
            // Lấy user hiện tại
            $taiKhoan = Auth::user();
            
            // Kiểm tra đăng nhập
            if (!$taiKhoan) {
                return redirect()->route('auth.login.form')
                    ->with('error', 'Vui lòng đăng nhập để tiếp tục.');
            }

            // Lấy thông tin khách hàng
            $khachHang = KhachHang::where('id_taikhoan', $taiKhoan->id_taikhoan)->first();

            if (!$khachHang) {
                return redirect()->route('auth.login.form')
                    ->with('error', 'Tài khoản của bạn chưa được liên kết với thông tin khách hàng. Vui lòng liên hệ quản trị viên.');
            }

            $loaiSuCo = [
                'Mất kết nối Internet' => 'internet',
                'Tốc độ chậm' => 'speed',
                'Mất tín hiệu' => 'disconnect',
                'Lỗi thiết bị' => 'modem',
                'Sự cố khác' => 'other'
            ];
            
            $thoiGianHen = [
                'Bất kỳ' => 'anytime',
                'Sáng (8h-12h)' => 'morning',
                'Chiều (13h-17h)' => 'afternoon',
                'Tối (18h-21h)' => 'evening'
            ];

            return view('forms.incident-report', compact('khachHang', 'loaiSuCo', 'thoiGianHen'));
        } catch (\Exception $e) {
            Log::error('Error in IncidentController@index: ' . $e->getMessage());
            return redirect()->route('auth.login.form')
                ->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }

    public function store(Request $request)
    {
        try {
            // Lấy user hiện tại
            $taiKhoan = Auth::user();
            
            if (!$taiKhoan) {
                return redirect()->route('auth.login.form')
                    ->with('error', 'Vui lòng đăng nhập để tiếp tục.');
            }

            $khachHang = KhachHang::where('id_taikhoan', $taiKhoan->id_taikhoan)->first();

            if (!$khachHang) {
                return redirect()->back()
                    ->with('error', 'Không tìm thấy thông tin khách hàng.');
            }

            $validated = $request->validate([
                'ten_thiet_bi' => 'required|string|max:255',
                'loai_succo' => 'required|in:internet,speed,disconnect,modem,other',
                'mo_ta' => 'required|string',
                'thoigian_hen' => 'required|in:anytime,morning,afternoon,evening',
                'file_dinh_kem.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,mp4'
            ]);

            $attachments = [];
            if ($request->hasFile('file_dinh_kem')) {
                foreach ($request->file('file_dinh_kem') as $file) {
                    $attachments[] = $file->store('incident-attachments', 'public');
                }
            }

            $yeuCau = YeuCau::create([
                'id_khach_hang' => $khachHang->id_khachhang,
                'ten_thiet_bi' => $validated['ten_thiet_bi'],
                'loai_succo' => $validated['loai_succo'],
                'mo_ta' => $validated['mo_ta'],
                'thoigian_hen' => $validated['thoigian_hen'],
                'trang_thai' => 'Chờ xử lý',
                'file_dinh_kem' => $attachments,
                'kinh_do' => $khachHang->kinh_do ?? 1,
                'vi_do' => $khachHang->vi_do ?? 1,
            ]);

            $this->timNhanVienGanNhat($yeuCau);

            return redirect()->back()->with('success', 'Báo cáo đã được gửi thành công! Chúng tôi sẽ liên hệ sớm nhất.');
        } catch (\Exception $e) {
            Log::error('Error in IncidentController@store: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi gửi báo cáo. Vui lòng thử lại sau.');
        }
    }

    private function timNhanVienGanNhat($yeuCau)
    {
        // Logic tìm nhân viên gần nhất
    }
}