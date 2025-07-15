<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NhanVien;
use App\Models\YeuCau;

class DashboardController extends Controller
{
    public function index()
    {
        $listNhanVien = NhanVien::select(
            'ho_ten',
            'trang_thai',
            'vi_do',
            'kinh_do',
        )
            ->where('trang_thai', '!=', 'Không trực tuyến')
            ->whereNotNull('trang_thai')
            ->get()
            ->map(fn($nv) => [
                'ho_ten' => $nv->ho_ten,
                'trang_thai' => $nv->trang_thai,
                'vi_do' => $nv->vi_do,
                'kinh_do' => $nv->kinh_do,
                'anh_dai_dien' => './assets/img/vnpt.jpg',
                'loai' => 'employee'
            ]);

        $listYeuCau = YeuCau::join('khach_hang', 'yeu_cau.id_khach_hang', '=', 'khach_hang.id_khachhang')
            ->select(
                'khach_hang.ho_ten as ho_ten',
                'yeu_cau.trang_thai as trang_thai',
                'yeu_cau.vi_do as vi_do',
                'yeu_cau.kinh_do as kinh_do',
            )
            ->where('yeu_cau.trang_thai', 'Chờ xử lý')
            ->get()
            ->map(fn($yc) => [
                'ho_ten' => $yc->ho_ten,
                'trang_thai' => $yc->trang_thai,
                'vi_do' => $yc->vi_do,
                'kinh_do' => $yc->kinh_do,
                'anh_dai_dien' => './assets/img/user.png',
                'loai' => 'customer'
            ]);

        $allData = $listNhanVien->concat($listYeuCau); // concat nhanh hơn merge

        // Đếm số lượng nhân viên và yêu cầu theo trạng thái
        $statusEmployeeCounts = [
            'truc_tuyen' => NhanVien::where('trang_thai', 'Trực tuyến')->count(),
            'dang_ban' => NhanVien::where('trang_thai', 'Đang bận')->count(),
            'khong_truc_tuyen' => NhanVien::where('trang_thai', 'Không trực tuyến')->count(),
        ];

        $requestCounts = YeuCau::where('trang_thai', 'Chờ xử lý')->count();

        // Truyền dữ liệu vào view
        return view('pages.admin.dashboard', [
            'statusEmployeeCounts' => $statusEmployeeCounts,
            'requestCounts' => $requestCounts,
            'allData' => $allData
        ]);
    }

    public function getEmployeeAndRequests(Request $request)
    {
        $listNhanVien = NhanVien::select(
            'ho_ten',
            'trang_thai',
            'vi_do',
            'kinh_do',
        )
            ->where('trang_thai', '!=', 'Không trực tuyến')
            ->whereNotNull('trang_thai')
            ->get()
            ->map(fn($nv) => [
                'ho_ten' => $nv->ho_ten,
                'trang_thai' => $nv->trang_thai,
                'vi_do' => $nv->vi_do,
                'kinh_do' => $nv->kinh_do,
                'anh_dai_dien' => './assets/img/vnpt.jpg',
                'loai' => 'employee'
            ]);

        $listYeuCau = YeuCau::join('khach_hang', 'yeu_cau.id_khach_hang', '=', 'khach_hang.id_khachhang')
            ->select(
                'khach_hang.ho_ten as ho_ten',
                'yeu_cau.trang_thai as trang_thai',
                'yeu_cau.vi_do as vi_do',
                'yeu_cau.kinh_do as kinh_do',
            )
            ->where('yeu_cau.trang_thai', 'Chờ xử lý')
            ->get()
            ->map(fn($yc) => [
                'ho_ten' => $yc->ho_ten,
                'trang_thai' => $yc->trang_thai,
                'vi_do' => $yc->vi_do,
                'kinh_do' => $yc->kinh_do,
                'anh_dai_dien' => './assets/img/user.png',
                'loai' => 'customer'
            ]);

        $allData = $listNhanVien->concat($listYeuCau); // concat nhanh hơn merge

        return response()->json([
            'status' => 'success',
            'data' => $allData
        ]);
    }
}
