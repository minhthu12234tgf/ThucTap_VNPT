<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HopDong extends Model
{
    use HasFactory;

    protected $table = 'hop_dong';
    protected $primaryKey = 'id_hd';
    public $timestamps = true;
    public $incrementing = false; // Vì id_hd là varchar
    protected $keyType = 'string';  // Xác định kiểu của primary key

    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';

    // Các loại dịch vụ
    const LOAI_DICH_VU = [
        'INTERNET' => 'Internet',
        'INTERNET_TRUYEN_HINH' => 'Internet-Truyền Hình'
    ];

    protected $fillable = [
        'id_hd',
        'ten_hd',
        'ngay_lap',
        'ngay_huy',
        'loai_dv',
        'id_khachhang',
        'ghi_chu',
        'vi_tri_ld',
        'create_at',
        'update_at'
    ];

    protected $casts = [
        'ngay_lap' => 'date',
        'ngay_huy' => 'date',
        'create_at' => 'datetime',
        'update_at' => 'datetime'
    ];

    // Quan hệ với KhachHang
    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'id_khachhang');
    }

    // Quan hệ với YeuCau
    public function yeuCaus()
    {
        return $this->hasMany(YeuCau::class, 'ma_hopdong', 'id_hd');
    }

    // Helper method để kiểm tra hợp đồng còn hiệu lực
    public function isActive()
    {
        return !$this->ngay_huy || $this->ngay_huy->isFuture();
    }

    // Helper method để lấy thời hạn hợp đồng
    public function getThoiHan()
    {
        if ($this->ngay_huy) {
            return $this->ngay_lap->diffInDays($this->ngay_huy);
        }
        return null;
    }

    // Helper method để kiểm tra loại dịch vụ
    public function hasInternetService()
    {
        return in_array($this->loai_dv, [
            self::LOAI_DICH_VU['INTERNET'],
            self::LOAI_DICH_VU['INTERNET_TRUYEN_HINH']
        ]);
    }

    public function hasTruyenHinhService()
    {
        return $this->loai_dv === self::LOAI_DICH_VU['INTERNET_TRUYEN_HINH'];
    }
}