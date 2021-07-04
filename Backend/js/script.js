function ProfileImage() {
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.profile-pic-upload').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }


    $(".file-upload").on('change', function() {
        readURL(this);
    });

    $(".upload-button").on('click', function() {
        $(".file-upload").click();
    });

    $(".circle").on('click', function() {
        $(".file-upload").click();
    });
}

function Profileupload() {

    var readUpload = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.nav-priflie-pic').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    return readUpload();

}

function order_update() {
    $.ajax({
        method: 'POST',
        url: 'data_order.php',
        cache: true,
        success: function(response) {
            if (response > 0) {
                $('#noti-ring').addClass(' ring-active');
                $('#noti-num').css("background-color", "red");
                $('#noti-num').css("color", "whitesmoke");
                $('#noti-num').text(response);
            }
        },
        complete: function() {
            setTimeout(function() {
                order_update()
            }, 3000);
        }
    });
}

function NavStatusLive() {
    $(".profile .icon_wrap").click(function() {
        $(this).parent().toggleClass("active");
        $(".notifications").removeClass("active");
    });

    $(".notifications .icon_wrap").click(function() {
        $(this).parent().toggleClass("active");
        $(".item-list-data").remove();
        $(".profile").removeClass("active");

        $.ajax({
            method: 'POST',
            url: 'notification_ul.php',
            cache: true,
            success: function(response) {
                $('#notification_ul').prepend(response);
            }
        });

        setTimeout(function() {
            $.ajax({
                method: 'POST',
                url: 'clear_notification.php',
                cache: true,
                success: function(response) {
                    $('#noti-ring').removeClass(' ring-active');
                    $('#noti-num').text(response);
                }
            });
        }, 1000);

        $('#noti-num').css("background-color", "transparent");
        $('#noti-num').css("color", "transparent");

    });

    $(".show_all .link").click(function() {
        $(".notifications").removeClass("active");
        // $(".popup").show();

        $.ajax({
            method: 'POST',
            url: 'order_list.php',
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });

    });

    $(".close").click(function() {
        $(".popup").hide();
    });

}

function NavBar(x) {
    var id = x;

    $('#profile-edit').click(function() {
        $.ajax({
            method: 'GET',
            url: 'admin_form_edite.php',
            data: {
                ID: x
            },
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });
    });

    $('#home-btn').click(function() {
        $(this).addClass("active");
        $(".list-group-item").not(this).removeClass("active");
        $.ajax({
            method: 'POST',
            url: 'admin_home.php',
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });
    });

    $('#admin-btn').click(function() {
        $(this).addClass("active");
        $(".list-group-item").not(this).removeClass("active");
        $.ajax({
            method: 'POST',
            url: 'admin_list.php',
            data: {
                id: id
            },
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });
    });

    $('#emp-btn').click(function() {
        $(this).addClass("active");
        $(".list-group-item").not(this).removeClass("active");
        $.ajax({
            method: 'POST',
            url: 'admin_sell_list.php',
            data: {
                id: id
            },
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });
    });

    $('#customer-btn').click(function() {
        $(this).addClass("active");
        $(".list-group-item").not(this).removeClass("active");
        $.ajax({
            method: 'POST',
            url: 'member_list.php',
            data: {
                id: id
            },
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });
    });

    $('#p-type-btn').click(function() {
        $(this).addClass("active");
        $(".list-group-item").not(this).removeClass("active");
        $.ajax({
            method: 'POST',
            url: 'type_list.php',
            data: {
                id: id
            },
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });
    });

    $('#product-btn').click(function() {
        $(this).addClass("active");
        $(".list-group-item").not(this).removeClass("active");
        $.ajax({
            method: 'POST',
            url: 'product_list.php',
            data: {
                id: id
            },
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });
    });

    $('#promotion-btn').click(function() {
        $(this).addClass("active");
        $(".list-group-item").not(this).removeClass("active");
        $.ajax({
            method: 'POST',
            url: 'promotion_list.php',
            data: {
                id: id
            },
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });
    });
}

function orderReceipt(x) {
    // update 
    var li = "#notification_ul-" + x;
    $(li).removeClass('n_read');
    $(li).addClass('read');

    $.ajax({
        method: 'POST',
        url: 'update_read_status.php',
        data: { order_id: x },
        cache: true,
        success: function() {
            $.ajax({
                method: 'GET',
                url: 'order.php',
                data: { order_id: x },
                cache: true,
                cache: true,
                success: function(response) {
                    $('#data').html(response);
                }
            });
        }
    });
}

function paymentCheck(id) {
    $.ajax({
        method: 'GET',
        url: 'admin_payment.php',
        data: {
            order_id: id
        },
        cache: true,
        cache: true,
        success: function(response) {
            $('#data').html(response);
        }
    });
}


function switchStatus(status) {
    switch (status) {
        case '0':
            status = "<span style='color: red;'>ยกเลิก</span>";
            break;
        case '1':
            status = "<span style='color: purple;'>ยังไม่ตรวจสอบ</span>";
            break;
        case '2':
            status = "<span style='color: blue;'>รอดำเนินการ</span>";
            break;
        case '3':
            status = "<span style='color: green;'>สำเร็จ</span>";
            break;
        case '5':
            status = "<span style='color: red;'>ยกเลิกโดยระบบอัตโนมัติ</span>";
            break;
    }
    return status;
}

function noProfilePic() {
    $(".user_icon").on("error", function() {
        $(this).attr('src', '../IMG/profile/default_user.jpg');
    });
}


function number_format(number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}