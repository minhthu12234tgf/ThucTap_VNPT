<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KhachHang extends Model
{
    use HasFactory;

    protected $table = 'khach_hang';
    protected $primaryKey = 'id_khachhang';
    public $timestamps = true;

    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';

    protected $fillable = [
        'ho_ten',
        'ngay_sinh',
        'gioi_tinh',
        'vi_tri',
        'sdt',
        'id_taikhoan',
        'anh_dai_dien',
        'create_at',
        'update_at'
    ];

    protected $casts = [
        'ngay_sinh' => 'date',
        'create_at' => 'datetime',
        'update_at' => 'datetime'
    ];

    // Quan hệ với TaiKhoan
    public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'id_taikhoan');
    }

    // Quan hệ với YeuCau
    public function yeuCaus()
    {
        return $this->hasMany(YeuCau::class, 'id_khach_hang');
    }

    // Quan hệ với HopDong
    public function hopDongs()
    {
        return $this->hasMany(HopDong::class, 'id_khachhang');
    }
}