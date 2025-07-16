<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $count = DB::table('hop_dong')
            ->whereDate('ngay_lap', DB::raw('CURDATE()'))
            ->count('id_hd');

        $countPhanHoi = DB::table('phan_hoi')
            ->where(function ($query) {
                $query->whereDate('create_at', DB::raw('CURDATE()'))
                      ->orWhereDate('update_at', DB::raw('CURDATE()'));
            })
            ->count('id_phanhoi');
        $countYeuCauChoDuyet = DB::table('yeu_cau')
                ->where('trang_thai', 'Chờ xử lý')
                ->count('id_yeu_cau');

        $countKhachHangHuy = DB::table('hop_dong')
                ->whereDate('ngay_huy', DB::raw('CURDATE()'))
                ->count('id_hd');
        $data = DB::table('yeu_cau')
                ->join('khach_hang', 'yeu_cau.id_khach_hang', '=', 'khach_hang.id_khachhang')
                ->leftjoin('nhan_vien', 'yeu_cau.id_nhan_vien_duoc_phan_cong', '=', 'nhan_vien.id_nhanvien')
                ->select(
                    'khach_hang.ho_ten',
                    'yeu_cau.ten_thiet_bi',
                    'yeu_cau.mo_ta',
                    'yeu_cau.trang_thai',
                    'nhan_vien.ho_ten as ten_nhan_vien',
                    'yeu_cau.create_at',
                    'yeu_cau.update_at'
                )
                ->orderByDesc('yeu_cau.create_at')
                ->limit(10)
                ->get();

        return view('pages.admin.dashboard', compact(
            'count',
            'countPhanHoi',
            'countYeuCauChoDuyet',
            'countKhachHangHuy',
            'data'
        ));
    }

    public function send(Request $request)
    {
        return response()->json([
            'message' => 'Data received successfully',
            'data' => $request->all(),
        ]);
    }
}
