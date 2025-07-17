<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LichSuPhanCong extends Model
{
    use HasFactory;

    protected $table = 'lich_su_phan_cong';
    protected $primaryKey = 'id_lspc';
    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'update_at';

    protected $fillable = [
        'id_phan_cong',
        'ghi_chu',
        'created_at',
        'update_at'
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'update_at' => 'datetime'
    ];

    // Quan hệ với PhanCong
    public function phanCong()
    {
        return $this->belongsTo(PhanCong::class, 'id_phan_cong');
    }

    // Helper method để lấy thông tin đầy đủ
    public function getThongTinDayDu()
    {
        return $this->load(['phanCong.nhanVien', 'phanCong.yeuCau']);
    }

    // Helper method để format thời gian
    // public function getThoiGianFormat()
    // {
    //     return $this->created_at->format('d/m/Y H:i:s');
    // }

    // Helper method để tạo ghi chú tự động
    public static function taoGhiChu($phanCong, $hanhDong)
    {
        $nhanVien = $phanCong->nhanVien->ho_ten;
        $yeuCau = $phanCong->yeuCau->id_yeu_cau;
        
        return "Nhân viên {$nhanVien} {$hanhDong} yêu cầu #{$yeuCau}";
    }

    // Helper method để tạo lịch sử mới
    public static function taoLichSu($phanCong, $hanhDong)
    {
        return self::create([
            'id_phan_cong' => $phanCong->id_phancong,
            'ghi_chu' => self::taoGhiChu($phanCong, $hanhDong)
        ]);
    }
}