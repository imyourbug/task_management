$(document).ready(function () {
    var otp_value = '';
    var autoCall = null;
    var id_task = '';
    $(".cancopy").css("cursor", "pointer");
    $("#space").click(function (event) {
        let idClicked = event.target.id;
        let value = $("#" + idClicked).attr("data-value");
        if (value !== undefined) {
            navigator.clipboard.writeText(value);
            toastr.success("Đã sao chép", "Thông báo");
        }
    });
    getQuantity();

    $("#code_freeship").on("change", function (event) {
        getQuantity();
    });

    function getQuantity() {
        let type = $("#code_freeship").find("option:selected").val();
        $.ajax({
            url: "/api/task?type=" + type,
            type: "GET",
            success: function (response) {
                let html = "Số lượng nhiệm vụ có thể làm: " + response.quantity;
                $("#quantity").html(html);
            },
        });
    }

    $(".btn-getOTP").on("click", function (event) {
        let rs = confirm("Bạn có muốn lấy OTP?");
        if (rs) {
            id_task = $(this).attr("data-value");
            if (autoCall != null) {
                clearInterval(autoCall);
            }
            // display phone get otp
            $.ajax({
                url: "/user/task/display/" + id_task,
                type: "GET",
                success: function (response) {
                    if (response.status == 0) {
                        autoCall = setInterval(function () {
                            getOTP(id_task);
                        }, 5000);
                    }
                    if (response.status == 1) {
                        toastr.error(response.message, "Thông báo");
                    }
                },
            });
        }
    });

    function getOTP(id) {
        if (otp_value != '') {
            clearInterval(autoCall);
            console.log('call update OTP');
            updateOTP(id, otp_value);
            return;
        }
        $.ajax({
            url: "/api/getOTP",
            data: { id },
            type: "POST",
            success: function (response) {
                if (response.status == 0) {
                    otp_value = response.otp;
                    console.log(otp_value);
                }
            },
        });
    }

    function updateOTP(id, otp) {
        $.ajax({
            url: "/api/updateOTP",
            data: { id, otp },
            type: "POST",
            success: function (response) {
                if (response.status == 0) {
                    toastr.success("Đã lấy OTP thành công", "Thông báo");
                    location.reload();
                }
                if (response.status == 1) {
                    toastr.error(response.message, "Thông báo");
                }
            },
        });
    }
});
