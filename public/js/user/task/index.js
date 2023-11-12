$(document).ready(function () {
    $('.cancopy').css('cursor', 'pointer');
    $("#space").click(function (event) {
        let idClicked = event.target.id;
        let value = $('#' + idClicked).attr('data-value');
        if (value !== undefined) {
            navigator.clipboard.writeText(value);
            toastr.success('Đã sao chép', 'Thông báo');
        }
    });
    getQuantity();

    $("#code_freeship").on('change', function (event) {
        getQuantity();
    });

    $(".btn-OTP").on('click', function (event) {
        let rs = confirm('Bạn có muốn lấy mã OTP?');
        if (rs) {
            let id = $(this).attr('data-value');
            $.ajax({
                url: '/api/getOTP',
                data: { id },
                type: 'POST',
                success: function (response) {
                    if (response.status == 0) {
                        toastr.success('Đã lấy OTP thành công', 'Thông báo');
                        location.reload();
                    }
                    if (response.status == 1) {
                        toastr.error(response.message, 'Thông báo');
                    }
                }
            })
        }
    });

    function getQuantity() {
        let type = $("#code_freeship").find('option:selected').val();
        $.ajax({
            url: '/api/task?type=' + type,
            data: '',
            type: 'GET',
            success: function (response) {
                console.log(response.quantity);
                let html = 'Số lượng nhiệm vụ có thể làm: ' + (response.quantity);
                $('#quantity').html(html);
            }
        })
    }


});
