// HIỂN THỊ BẢN ĐỒ VỚI CÁC NHÂN VIÊN TRÊN DASHBOARD
document.addEventListener('DOMContentLoaded', function () {
    const employees = [
        { name: "Nguyễn Văn Anh Khang", status: "Đang bận", lat: 10.762622, lng: 106.660172, avatar: "./assets/img/vnpt.jpg", type: "employee" },
        { name: "Trần Thị A", status: "Trực tuyến", lat: 10.762622, lng: 106.660172, avatar: "./assets/img/vnpt.jpg", type: "employee" },
        { name: "Trần Thị B", status: "Trực tuyến", lat: 10.762622, lng: 106.660172, avatar: "./assets/img/vnpt.jpg", type: "employee" },
        { name: "Phạm Thị D", status: "Đang bận", lat: 10.750000, lng: 106.635000, avatar: "./assets/img/vnpt.jpg", type: "employee" },
        { name: "Ngô Văn E", status: "Trực tuyến", lat: 10.790000, lng: 106.660000, avatar: "./assets/img/vnpt.jpg", type: "employee" }
    ];

    const customers = [
        { name: "Khách hàng 1", status: "Chờ xử lý", lat: 10.762622, lng: 106.660172, avatar: "./assets/img/user.png", type: "customer" },
        { name: "Khách hàng 2", status: "Chờ xử lý", lat: 10.765500, lng: 106.661500, avatar: "./assets/img/user.png", type: "customer" }
    ];

    const map = L.map('map').setView([10.762622, 106.660172], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const markerCluster = L.markerClusterGroup();

    function getStatusColor(status) {
        return status === "Trực tuyến" ? "green" : "#E65100";
    }

    function getRequestColor(status) {
        return status === "Chờ xử lý" ? "red" : "blue";
    }

    function haversineDistance(lat1, lng1, lat2, lng2) {
        function toRad(x) {
            return x * Math.PI / 180;
        }

        const R = 6371e3; // Bán kính Trái Đất (m)
        const φ1 = toRad(lat1);
        const φ2 = toRad(lat2);
        const Δφ = toRad(lat2 - lat1);
        const Δλ = toRad(lng2 - lng1);

        const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
            Math.cos(φ1) * Math.cos(φ2) *
            Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

        return R * c; // khoảng cách mét
    }

    const allMarkers = [...employees, ...customers];
    const DISTANCE_THRESHOLD = 100; // mét

    allMarkers.forEach((item, index) => {
        const tooltipHtml = `
            <div class="tooltip-custom d-flex align-items-center gap-2">
                <img src="${item.avatar}" alt="${item.name}" class="avatar-img" style="width: 40px; height: 40px; border-radius: 50%;">
                <div>
                    <div class="fw-semibold text-dark">${item.name}</div>
                    <div class="status-text" style="color:${item.type === 'employee' ? getStatusColor(item.status) : getRequestColor(item.status)}">
                        ${item.type === 'employee' ? '👨‍🔧' : '📌'} ${item.status}
                    </div>
                    <div class="badge ${item.type === 'employee' ? 'bg-primary text-white' : 'bg-warning text-dark'} mt-1 px-2 py-1 rounded">
                        ${item.type === 'employee' ? 'Kỹ thuật viên' : 'Khách hàng'}
                    </div>
                </div>
            </div>
        `;

        const marker = L.marker([item.lat, item.lng]);

        // Kiểm tra marker này có gần marker nào khác không
        const isCloseToOthers = allMarkers.some((other, idx) => {
            if (index === idx) return false;
            const d = haversineDistance(item.lat, item.lng, other.lat, other.lng);
            return d < DISTANCE_THRESHOLD;
        });

        if (!isCloseToOthers) {
            // Không gần ai → hiển thị tooltip mặc định
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

        // Bắt sự kiện click để toggle tooltip
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