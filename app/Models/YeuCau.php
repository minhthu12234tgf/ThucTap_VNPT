<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class YeuCau extends Model
{
    use HasFactory;

    protected $table = 'yeu_cau';
    protected $primaryKey = 'id_yeu_cau';
    public $timestamps = true;

    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';

    // Các trạng thái của yêu cầu
    const TRANG_THAI = [
        'CHO_XU_LY' => 'Chờ xử lý',
        'DA_TIEP_NHAN' => 'Đã tiếp nhận',
        'DANG_XU_LY' => 'Đang xử lý',
        'CHO_PHAN_HOI' => 'Chờ phản hồi',
        'HOAN_THANH' => 'Hoàn thành',
        'DA_HUY' => 'Đã huỷ'
    ];

    // Các loại sự cố
    const LOAI_SU_CO = [
        'INTERNET' => 'internet',
        'SPEED' => 'speed',
        'DISCONNECT' => 'disconnect',
        'MODEM' => 'modem',
        'OTHER' => 'other'
    ];

    // Thời gian hẹn
    const THOI_GIAN = [
        'ANYTIME' => 'anytime',
        'MORNING' => 'morning',
        'AFTERNOON' => 'afternoon',
        'EVENING' => 'evening'
    ];

    // Mức độ ưu tiên
    const UU_TIEN = [
        'NORMAL' => 'normal',
        'URGENT' => 'urgent'
    ];

    protected $fillable = [
        'id_khach_hang',
        'ma_hopdong',
        'ten_thiet_bi',
        'loai_succo',
        'mo_ta',
        'thoigian_hen',
        'trang_thai',
        'id_nhan_vien_duoc_phan_cong',
        'create_at',
        'update_at',
        'file_dinh_kem'
    ];

    protected $casts = [
        'create_at' => 'datetime',
        'update_at' => 'datetime',
        'file_dinh_kem' => 'json'
    ];

    // Quan hệ với KhachHang
    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'id_khach_hang');
    }

    // Quan hệ với HopDong
    public function hopDong()
    {
        return $this->belongsTo(HopDong::class, 'ma_hopdong', 'id_hd');
    }

    // Quan hệ với NhanVien
    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'id_nhan_vien_duoc_phan_cong');
    }

    // Quan hệ với PhanCong
    public function phanCongs()
    {
        return $this->hasMany(PhanCong::class, 'id_yeucau');
    }
}