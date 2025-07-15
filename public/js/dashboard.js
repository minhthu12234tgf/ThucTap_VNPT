// HIỂN THỊ BẢN ĐỒ VỚI CÁC NHÂN VIÊN TRÊN DASHBOARD

// Dữ liệu mẫu (có thể thay thế bằng dữ liệu từ server)
// let employees = [
//     { ho_ten: "Nguyễn Văn Anh Khang", trang_thai: "Đang bận", vi_do: 10.762622, kinh_do: 106.660172, anh_dai_dien: "./assets/img/vnpt.jpg", loai: "employee" },
//     { ho_ten: "Trần Thị A", trang_thai: "Trực tuyến", vi_do: 10.762622, kinh_do: 106.660172, anh_dai_dien: "./assets/img/vnpt.jpg", loai: "employee" },
//     { ho_ten: "Trần Thị B", trang_thai: "Trực tuyến", vi_do: 10.762622, kinh_do: 106.660172, anh_dai_dien: "./assets/img/vnpt.jpg", loai: "employee" },
//     { ho_ten: "Phạm Thị D", trang_thai: "Đang bận", vi_do: 10.750000, kinh_do: 106.635000, anh_dai_dien: "./assets/img/vnpt.jpg", loai: "employee" },
//     { ho_ten: "Ngô Văn E", trang_thai: "Trực tuyến", vi_do: 10.790000, kinh_do: 106.660000, anh_dai_dien: "./assets/img/vnpt.jpg", loai: "employee" }
// ];

// const customers = [
//     { ho_ten: "Khách hàng 1", trang_thai: "Chờ xử lý", vi_do: 10.762622, kinh_do: 106.660172, anh_dai_dien: "./assets/img/user.png", loai: "customer" },
//     { ho_ten: "Khách hàng 2", trang_thai: "Chờ xử lý", vi_do: 10.765500, kinh_do: 106.661500, anh_dai_dien: "./assets/img/user.png", loai: "customer" }
// ]

document.addEventListener('DOMContentLoaded', async function () {
    const DISTANCE_THRESHOLD = 100; // mét
    let allMarkers = allData;

    // 1. Fetch dữ liệu từ server
    
    // try {
    //     const res = await fetch('/getEmployeeAndRequests', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //         }
    //     });

    //     const data = await res.json();
    //     allMarkers = data.data || [];
    //     console.log('✅ Dữ liệu từ server:', allMarkers);
    // } catch (error) {
    //     console.error('❌ Lỗi khi lấy dữ liệu từ server:', error);
    //     return;
    // }

    // 2. Hàm tính khoảng cách Haversine
    function haversineDistance(lat1, lng1, lat2, lng2) {
        const toRad = deg => deg * Math.PI / 180;
        const R = 6371e3; // Bán kính Trái Đất (m)

        const dLat = toRad(lat2 - lat1);
        const dLng = toRad(lng2 - lng1);
        const a = Math.sin(dLat / 2) ** 2 +
            Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
            Math.sin(dLng / 2) ** 2;
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    // 3. Gán cờ "isCrowded" trước để tối ưu hiệu năng
    allMarkers.forEach((item, i) => {
        item.isCrowded = false;
        for (let j = 0; j < allMarkers.length; j++) {
            if (i === j) continue;
            const d = haversineDistance(item.vi_do, item.kinh_do, allMarkers[j].vi_do, allMarkers[j].kinh_do);
            if (d < DISTANCE_THRESHOLD) {
                item.isCrowded = true;
                break;
            }
        }
    });

    // 4. Hàm hiển thị tooltip
    function buildTooltip(item) {
        const color = item.loai === 'employee'
            ? getStatusColor(item.trang_thai)
            : getRequestColor(item.trang_thai);

        const label = item.loai === 'employee' ? 'Kỹ thuật viên' : 'Khách hàng';
        const icon = item.loai === 'employee' ? '👨‍🔧' : '📌';

        return `
            <div class="tooltip-custom d-flex align-items-center gap-2">
                <img src="${item.anh_dai_dien}" alt="${item.ho_ten}" class="avatar-img" style="width: 40px; height: 40px; border-radius: 50%;">
                <div>
                    <div class="fw-semibold text-dark">${item.ho_ten}</div>
                    <div class="status-text" style="color:${color}">
                        ${icon} ${item.trang_thai}
                    </div>
                    <div class="badge ${item.loai === 'employee' ? 'bg-primary text-white' : 'bg-warning text-dark'} mt-1 px-2 py-1 rounded">
                        ${label}
                    </div>
                </div>
            </div>
        `;
    }

    function getStatusColor(status) {
        return status === "Trực tuyến" ? "green" : "#E65100";
    }

    function getRequestColor(status) {
        return status === "Chờ xử lý" ? "red" : "blue";
    }

    // 5. Hiển thị bản đồ Leaflet
    const map = L.map('map').setView([10.762622, 106.660172], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const markerCluster = L.markerClusterGroup();

    // 6. Tạo và xử lý từng marker
    allMarkers.forEach(item => {
        const tooltipHtml = buildTooltip(item);

        const marker = L.marker([item.vi_do, item.kinh_do], {
            icon: L.divIcon({
                html: `
                    <div style="
                        width: 40px;
                        height: 40px;
                        border-radius: 50%;
                        overflow: hidden;
                        border: 3px solid ${item.loai === 'employee' ? '#007bff' : '#ffc107'};
                        box-shadow: 0 0 6px rgba(0,0,0,0.3);
                        background-color: #fff;
                    ">
                        <img src="${item.anh_dai_dien}" 
                            alt="${item.ho_ten}" 
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                `,
                className: '',
                iconSize: [40, 40],
                iconAnchor: [20, 20]
            })
        });

        // Tooltip mặc định nếu không gần ai
        if (!item.isCrowded) {
            marker.bindTooltip(tooltipHtml, {
                permanent: true,
                direction: 'top',
                className: 'leaflet-tooltip-own',
                interactive: true
            });
            marker._tooltipVisible = true;
        } else {
            marker._tooltipVisible = false;
        }

        // Toggle tooltip khi click
        marker.on('click', function () {
            if (marker._tooltipVisible) {
                marker.unbindTooltip();
                marker._tooltipVisible = false;
            } else {
                marker.bindTooltip(tooltipHtml, {
                    permanent: true,
                    direction: 'top',
                    className: 'leaflet-tooltip-own',
                    interactive: true
                }).openTooltip();
                marker._tooltipVisible = true;
            }
        });

        markerCluster.addLayer(marker);
    });

    map.addLayer(markerCluster);
});