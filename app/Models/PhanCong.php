<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhanCong extends Model
{
    use HasFactory;

    protected $table = 'phan_cong';
    protected $primaryKey = 'id_phancong';
    public $timestamps = true;

    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';

    // Các trạng thái phân công
    const TRANG_THAI = [
        'CHO_PHAN_HOI' => 'Chờ phản hồi',
        'DA_NHAN_VIEC' => 'Đã nhận việc',
        'TU_CHOI' => 'Từ chối',
        'DANG_DI_CHUYEN' => 'Đang di chuyển',
        'DANG_XU_LY' => 'Đang xử lý',
        'HOAN_THANH' => 'Hoàn thành'
    ];

    protected $fillable = [
        'id_nhanvien',
        'id_yeucau',
        'mo_ta',
        'create_at',
        'update_at',
        'thoi_gian_bat_dau',
        'thoi_gian_ket_thuc',
        'thoi_gian_phan_hoi',
        'khoang_cach',
        'trang_thai'
    ];

    protected $casts = [
        'create_at' => 'datetime',
        'update_at' => 'datetime',
        'thoi_gian_bat_dau' => 'datetime',
        'thoi_gian_ket_thuc' => 'datetime',
        'thoi_gian_phan_hoi' => 'datetime',
        'khoang_cach' => 'float'
    ];

    // Quan hệ với NhanVien
    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'id_nhanvien');
    }

    // Quan hệ với YeuCau
    public function yeuCau()
    {
        return $this->belongsTo(YeuCau::class, 'id_yeucau');
    }

    // Quan hệ với LichSuPhanCong
    public function lichSuPhanCongs()
    {
        return $this->hasMany(LichSuPhanCong::class, 'id_phan_cong');
    }

    // Helper method để tính thời gian phản hồi
    public function getThoiGianPhanHoi()
    {
        if ($this->thoi_gian_phan_hoi && $this->create_at) {
            return $this->thoi_gian_phan_hoi->diffInMinutes($this->create_at);
        }
        return null;
    }

    // Helper method để tính thời gian xử lý
    public function getThoiGianXuLy()
    {
        if ($this->thoi_gian_ket_thuc && $this->thoi_gian_bat_dau) {
            return $this->thoi_gian_ket_thuc->diffInMinutes($this->thoi_gian_bat_dau);
        }
        return null;
    }
}