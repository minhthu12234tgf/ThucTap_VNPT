@php
    use App\Models\YeuCau;
@endphp

@extends('layouts.admin')

@section('title', 'Báo cáo sự cố')

@section('content')
    <!-- Debug auth status -->
    @if(Auth::check())
        <div class="alert alert-info">
            Đã đăng nhập: {{ Auth::user()->name }}
            <br>User ID: {{ Auth::id() }}
        </div>
    @else
        <div class="alert alert-warning">
            Chưa đăng nhập
        </div>
    @endif

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-lg rounded-4">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">BÁO CÁO SỰ CỐ INTERNET VNPT</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('incident.report.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Thông tin khách hàng -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Họ tên</label>
                                    <input type="text" class="form-control" value="{{ $khachHang->ho_ten }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" value="{{ $khachHang->sdt }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control" value="{{ $khachHang->vi_tri }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Hợp đồng</label>
                                    <select name="hop_dong_id" class="form-select" required>
                                        <option value="">-- Chọn hợp đồng --</option>
                                        @foreach($hopDongs as $hopDong)
                                          <option value="{{ $hopDong->id_hd }}" {{ old('hop_dong_id') == $hopDong->id_hd ? 'selected' : '' }}>
                                            {{ $hopDong->ten_hd }}
                                          </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Địa chỉ hợp đồng</label>
                                    <input type="text" class="form-control" name="dia_chi_hop_dong" value="{{ old('dia_chi_hop_dong') }}">
                                </div>
                            </div>

                            <!-- Loại sự cố -->
                            <div class="mb-3">
                                <label class="form-label">Loại sự cố</label>
                                <select class="form-select" name="loai_succo" required>
                                    <option value="">-- Chọn loại sự cố --</option>
                                    @foreach($loaiSuCo as $label => $value)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Thiết bị gặp sự cố</label>
                                <input type="text" class="form-control" name="ten_thiet_bi"
                                    placeholder="VD: Modem VNPT, Router TP-Link..." required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mô tả chi tiết sự cố</label>
                                <textarea class="form-control" name="mo_ta" rows="4"
                                    placeholder="Mô tả rõ tình trạng, thời điểm xảy ra sự cố..." required></textarea>
                            </div>
                            <!-- Thời gian hẹn -->
                            <div class="mb-3">
                                <label class="form-label">Thời gian hẹn</label>
                                <select class="form-select" name="thoigian_hen" required>
                                    @foreach($thoiGianHen as $label => $value)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Hình ảnh/Video sự cố (nếu có)</label>
                                <input type="file" class="form-control" name="file_dinh_kem[]" accept="image/*,video/*"
                                    multiple>
                                <small class="text-muted">Có thể tải lên nhiều file (tối đa 5MB/file)</small>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                    <i class="bi bi-send"></i> Gửi báo cáo
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center text-muted small">
                        VNPT hỗ trợ kỹ thuật 24/7 - Tổng đài: 1800 1166
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const hopDongSelect = document.querySelector('select[name="hop_dong_id"]');
  const diaChiInput = document.querySelector('input[name="dia_chi_hop_dong"]');
  // Lưu thông tin địa chỉ hợp đồng vào object
  const diaChiHopDong = {
    @foreach($hopDongs as $hopDong)
      "{{ $hopDong->id_hd }}": "{{ addslashes($hopDong->vi_tri_ld ?? '') }}",
    @endforeach
  };

  hopDongSelect.addEventListener('change', function () {
    const id = this.value;
    diaChiInput.value = diaChiHopDong[id] || '';
  });
});
</script>

@endsection