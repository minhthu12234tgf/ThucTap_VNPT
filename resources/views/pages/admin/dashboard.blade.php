{{-- Kế thừa từ layout admin --}}
@extends('layouts.admin')

{{-- Đặt tiêu đề trang --}}
@section('title', 'Trang chủ')

{{-- Nội dung chính của trang --}}
@section('content')
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <!--begin::Col-->
                <!--begin::Col 1-->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>{{$count}}</h3>
                            <p>Khách Hàng Đăng Ký Mới</p>
                        </div>
                        <div style="text-align: center;">
                            <svg class="small-box-icon" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 16 16" fill="currentColor"
                                style="width: 60px; height: 60px; transition: transform 0.3s;"
                                onmouseover="this.style.transform='scale(1.2)'"
                                onmouseout="this.style.transform='scale(1)'">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                <path d="M13 8.5a.5.5 0 0 1 .5.5v1.5H15a.5.5 0 0 1 0 1h-1.5V13a.5.5 0 0 1-1 0v-1.5H11a.5.5 0 0 1 0-1h1.5V9a.5.5 0 0 1 .5-.5z"/>
                                <path d="M1 13s-1 0-1-1 1-4 7-4 7 3 7 4-1 1-1 1H1z"/>
                            </svg>
                        </div>
                        <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            Chi Tiết <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>

                <!--begin::Col 2-->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>{{$countPhanHoi}}</h3>
                            <p>Phản Hồi Mới</p>
                        </div>
                        <div style="text-align: center;">
                            <svg class="small-box-icon" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 16 16" fill="currentColor"
                                style="width: 60px; height: 60px; transition: transform 0.3s;"
                                onmouseover="this.style.transform='scale(1.2)'"
                                onmouseout="this.style.transform='scale(1)'">
                                <path d="M8 2a6 6 0 1 0 4.472 10.002c.527.176 1.057.353 1.6.53.206.07.428.148.652.233a.5.5 0 0 0 .672-.56c-.103-.529-.227-1.027-.364-1.5A6 6 0 0 0 8 2z"/>
                                <path d="M4.5 7a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm3 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm3 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                            </svg>
                        </div>                     
                        <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            Chi Tiết <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>

                <!--begin::Col 3-->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>{{$countYeuCauChoDuyet}}</h3>
                            <p>Yêu Cầu Chờ Xử Lý</p>
                        </div>                       
                        <div style="text-align: center;">
                            <svg class="small-box-icon" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 16 16" fill="currentColor"
                            style="width: 60px; height: 60px; transition: transform 0.3s;"
                            onmouseover="this.style.transform='scale(1.2)'"
                            onmouseout="this.style.transform='scale(1)'">
                            <path d="M8.515 3.957A.5.5 0 0 1 9 4.5v3.707l2.146 2.147a.5.5 0 0 1-.708.708l-2.292-2.292A.5.5 0 0 1 8 8V4.5a.5.5 0 0 1 .515-.543z"/>
                            <path d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 1 1 .92-.4A4 4 0 1 0 8 4a.5.5 0 0 1 0-1z"/>
                        </svg>
                        </div>
                        <a href="#" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                            Chi Tiết <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>

                <!--begin::Col 4-->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>{{$countKhachHangHuy}}</h3>
                            <p>Khách Hàng Hủy Hợp Đồng Hôm Nay</p>
                        </div>
                        <div style="text-align: center;">
                            <svg class="small-box-icon" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 16 16" fill="currentColor"
                            style="width: 60px; height: 60px; transition: transform 0.3s;"
                            onmouseover="this.style.transform='scale(1.2)'"
                            onmouseout="this.style.transform='scale(1)'">
                            <path d="M10.854 5.646a.5.5 0 1 0-.708.708L11.293 7l-1.147 1.146a.5.5 0 0 0 .708.708L12 7.707l1.146 1.147a.5.5 0 0 0 .708-.708L12.707 7l1.147-1.146a.5.5 0 0 0-.708-.708L12 6.293 10.854 5.146z"/>
                            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM2 13s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H2z"/>
                        </svg>
                        </div>                      
                        <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            Chi Tiết <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>

                <!--end::Col-->

            </div>
            <!--end::Row-->
            <!--table-->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Danh sách yêu cầu gần đây</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Khách hàng</th>
                                    <th>Thiết bị</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Nhân viên</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày cập nhật</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $row->ho_ten }}</td>
                                        <td>{{ $row->ten_thiet_bi }}</td>
                                        <td>{{ $row->mo_ta }}</td>
                                        <td>
                                            @switch($row->trang_thai)
                                                @case('Chờ xử lý')
                                                    <span class="badge text-bg-warning">Chờ xử lý</span>
                                                    @break

                                                @case('Đang xử lý')
                                                    <span class="badge text-bg-info">Đang xử lý</span>
                                                    @break

                                                @case('Hoàn thành')
                                                    <span class="badge text-bg-success">Hoàn thành</span>
                                                    @break

                                                @default
                                                    <span class="badge text-bg-secondary">{{ $yeucau->trang_thai }}</span>
                                            @endswitch
                                        </td>

                                        <td>{{ $row->ten_nhan_vien ?? 'Chưa phân công' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->create_at)->format('d/m/Y H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->update_at)->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                                @if ($data->isEmpty())
                                    <tr><td colspan="7" class="text-center text-muted">Không có dữ liệu</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end table-->
            <div class="my-4"></div>
            <!--begin::Row-->
            {{-- Hiển thị bản đồ --}}
            <div class="col-12 mt-1">
                <div id="map" class="min-vh-100 rounded-3"></div>
            </div>

            {{-- Hiển thị thống kê người dùng/nhân viên trên map --}}
            <div class="row mt-4">
                <!-- Nhân viên Trực tuyến -->
                <div class="col-12 col-sm-6 col-md-3" title="Trực tuyến">
                    <div class="info-box">
                        <span class="info-box-icon text-bg-success shadow-sm">
                            <i class="bi bi-person-check-fill"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Trực tuyến</span>
                            <span class="info-box-number" id="online-count">{{ $statusEmployeeCounts['truc_tuyen'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Nhân viên Đang bận -->
                <div class="col-12 col-sm-6 col-md-3" title="Đang bận">
                    <div class="info-box">
                        <span class="info-box-icon text-bg-danger shadow-sm">
                            <i class="bi bi-person-dash-fill"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Đang bận</span>
                            <span class="info-box-number" id="busy-count">{{ $statusEmployeeCounts['dang_ban'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Nhân viên Không trực tuyến -->
                <div class="col-12 col-sm-6 col-md-3" title="Không trực tuyến">
                    <div class="info-box">
                        <span class="info-box-icon text-bg-secondary shadow-sm">
                            <i class="bi bi-person-x-fill"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Không trực tuyến</span>
                            <span class="info-box-number" id="offline-count">{{ $statusEmployeeCounts['khong_truc_tuyen'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Yêu cầu chờ xử lý -->
                <div class="col-12 col-sm-6 col-md-3" title="Yêu cầu chờ xử lý">
                    <div class="info-box">
                        <span class="info-box-icon text-bg-warning shadow-sm">
                            <i class="bi bi-clock-fill"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Yêu cầu chờ xử lý</span>
                            <span class="info-box-number" id="pending-count">{{ $requestCounts }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->

    <!--begin::Script-->
    <!-- OPTIONAL SCRIPTS -->
    <!-- ECharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.5.0/dist/echarts.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/dashboard.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- MarkerCluster CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css">

    <!-- MarkerCluster JS -->
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

    <!-- Data JS -->
    <script>
        const allData = @json($allData);
    </script>

    {{-- CUSTOM SCRIPT --}}
    <script src="./js/dashboard.js"></script>
    <!--end::Script-->

@endsection
