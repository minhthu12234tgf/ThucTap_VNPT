<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NhanVien extends Model
{
    use HasFactory;

    protected $table = 'nhan_vien';
    protected $primaryKey = 'id_nhanvien';
    public $timestamps = true;

    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';

    // Các trạng thái của nhân viên
    const TRANG_THAI = [
        'TRUC_TUYEN' => 'Trực tuyến',
        'KHONG_TRUC_TUYEN' => 'Không trực tuyến',
        'DANG_BAN' => 'Đang bận'
    ];

    protected $fillable = [
        'ho_ten',
        'gioi_tinh',
        'ngay_sinh',
        'chuc_vu',
        'don_vi',
        'create_at',
        'update_at',
        'id_chi_nhanh',
        'id_khu_vuc',
        'id_tai_khoan',
        'kinh_do',
        'vi_do',
        'trang_thai',
        'anh_dai_dien'
    ];

    protected $casts = [
        'ngay_sinh' => 'date',
        'create_at' => 'date',
        'update_at' => 'datetime',
        'kinh_do' => 'double',
        'vi_do' => 'double'
    ];

    // Quan hệ với TaiKhoan
    public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'id_tai_khoan');
    }

    // Quan hệ với ChiNhanh
    // public function chiNhanh()
    // {
    //     return $this->belongsTo(ChiNhanh::class, 'id_chi_nhanh');
    // }

    // Quan hệ với KhuVuc
    // public function khuVuc()
    // {
    //     return $this->belongsTo(KhuVuc::class, 'id_khu_vuc');
    // }

    // Quan hệ với PhanCong
    public function phanCongs()
    {
        return $this->hasMany(PhanCong::class, 'id_nhanvien');
    }

    // Quan hệ với YeuCau
    public function yeuCaus()
    {
        return $this->hasMany(YeuCau::class, 'id_nhan_vien_duoc_phan_cong');
    }

    // Helper method để kiểm tra trạng thái
    public function isTrucTuyen()
    {
        return $this->trang_thai === self::TRANG_THAI['TRUC_TUYEN'];
    }

    public function isDangBan()
    {
        return $this->trang_thai === self::TRANG_THAI['DANG_BAN'];
    }

    // Helper method để tính khoảng cách với một điểm
    public function tinhKhoangCach($kinh_do, $vi_do)
    {
        return sqrt(
            pow($this->kinh_do - $kinh_do, 2) + 
            pow($this->vi_do - $vi_do, 2)
        );
    }

    // Helper method để lấy số công việc đang xử lý
    public function getSoCongViecDangXuLy()
    {
        return $this->phanCongs()
            ->whereIn('trang_thai', ['Đã nhận việc', 'Đang di chuyển', 'Đang xử lý'])
            ->count();
    }
}