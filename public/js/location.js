    document.addEventListener('DOMContentLoaded', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.querySelector('input[name="kinh_do"]').value = position.coords.longitude;
                document.querySelector('input[name="vi_do"]').value = position.coords.latitude;
               // alert('Lấy vị trí thành công!');
            }, function(error) {
               // alert('Không lấy được vị trí: ' + error.message);
            });
        } else {
           // alert('Trình duyệt không hỗ trợ Geolocation.');
        }
    });