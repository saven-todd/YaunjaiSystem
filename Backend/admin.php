<?php session_start(); 
    $ID = $_SESSION['ID'];
    $name = $_SESSION['name'];
    $profile_pic = $_SESSION['pic'];
    $level = $_SESSION['status'];
    $fbid = $_SESSION['fbid'];
  
  if($level!=='1'){
   Header("Location: ../logout.php");  
  }  
  
date_default_timezone_set("Asia/Bangkok");
?>

<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha256-t9UJPrESBeG2ojKTIcFLPGF7nHi2vEc7f5A2KpH/UBU=" crossorigin="anonymous"></script>

    <!-- JS Script -->
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/fontawesome.js"></script>
    <script src="js/script.js"></script>

    <!-- AJAX -->

    <!-- Chat Css -->
    <link rel="stylesheet" href="../chat_style.css">
    <!-- fontawsome -->
    <script src="https://kit.fontawesome.com/e01de64041.js" crossorigin="anonymous"></script>

    <?php include_once 'h.php';?>
</head>

<body class="admin-body">

    <div class="container">
        <?php include_once 'navbar.php'; ?>
        <p></p>
        <div class="row">
            <div class="col-md-3">
                <!-- Left side column. contains the logo and sidebar -->
                <div class="list-group">
                    <a id="home-btn" href="#" class="list-group-item list-group-item-action">Home</a>
                    <a id="admin-btn" href="#" class="list-group-item list-group-item-action">จัดการผู้ดูแลระบบ</a>
                    <a id="emp-btn" href="#" class="list-group-item list-group-item-action">จัดการพนักงานขาย</a>
                    <a id="customer-btn" href="#" class="list-group-item list-group-item-action">จัดการสมาชิก</a>
                    <a id="p-type-btn" href="#" class="list-group-item list-group-item-action">จัดการประเภทสินค้า</a>
                    <a id="product-btn" href="#" class="list-group-item list-group-item-action">จัดการสินค้า</a>
                    <a id="promotion-btn" href="#" class="list-group-item list-group-item-action">จัดการโปรโมชั่น</a>
                    <a id="loguot-btn" onclick="Logout();" href="#"
                        class="list-group-item list-group-item-action">ออกจากระบบ</a>
                </div>
                <!-- Content Wrapper. Contains page content -->
            </div>
            <div id="data" class="col-9 data-container">
            </div>
        </div>
        <footer class="admin-footer"></footer>
    </div>

    <!-- MAIN CHATBOX -->
    <div class="chat_box">
        <div class="chat_header">
            <h1 class="chat_heading">Contacts</h1>
        </div>
        <div class="chat_content" id="user-list" style="display: none;">
        </div>
    </div>
    <!-- MESSAGER BOX -->
    <div class="message_box" id="message-box-3">
        <div class="message_header">
            <img src="../IMG/profile/Screenshot 2021-03-11 155950.png" onerror="myFunction()" alt="" class="user_icon">
            <h1 class="chat_heading">OIL</h1>
            <i class="fas fa-times"></i>
        </div>
        <div class="message_content" style="display: none;">
            <div class="messages" id="messages">
                <!-- <div class="p1">
                    <img src="../IMG/profile/Screenshot 2021-03-11 155950.png"
                        class="user_icon_small" />
                    <p>This message is from him</p>
                </div>

                <div class="p2">
                    <p>This is from ME</p>
                </div> -->
                <div class="new_messages p2" id="new_messages"></div>
            </div>
            <div id="sent-centainer" class="input_box">
                <input type="text" id="message" class="message_input" autocomplete="off" autofocus
                    placeholder="Type a message...">
                <i class="fas fa-location-arrow enter"></i>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        var id = <?=$ID?>;
        $.ajax({
            method: 'POST',
            url: 'admin_home.php',
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });
        NavBar(id)
        order_update();
        NavStatusLive();
    });


    $(document).click(function(event) {
        if (!$(event.target).closest('.profile').length) {
            $(".profile").removeClass("active");
        }
        if (!$(event.target).closest('.notifications').length) {
            $(".item-list-data").remove();
            $(".notifications").removeClass("active");
        }

    });

    function Logout() {
        var conf = confirm('คุณต้องการออกจากระบบใช่หรือไม่ ?');
        if (conf) {
            $.ajax({
                url: '../logout.php',
                cache: true,
                success: function(response) {
                    window.location = "../index.php";
                }
            });
        } else {
            return false;
        }
    }
    </script>

    <!-- Chat Script -->

    <!-- SCRIPT -->
    <script>
    var from = null,
        start = 0,
        url = '../chat.php';

    $(document).ready(function() {
        $(".chat_header").click(function() {
            $(".chat_content").slideToggle("slow");
        });

        $(".message_header").click(function() {
            $(".message_content").slideToggle("slow");
            $("#messages").animate({
                scrollTop: $('#messages')[0].scrollHeight
            }, 100);
        });

        $(".close").click(function() {
            $(".message_box").hide();
        });

        $(".user").click(function() {
            $(".message_box").show();
            $(".message_content").show();
            $(".input_box").show();
        });

        $(".enter").click(function(e) {
            var msg = $(".message_input").val();
            if (msg != "") {
                $("#messages").append(`<div class="p2">
                                            <p>${msg}</p>
                                        </div>`);
                $(".message_input").val("");

                $.post(url, {
                    message: msg,
                    from: 3,
                    to: 4
                });
            }
        });

        $('.message_input').keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                var msg = $(".message_input").val();
                if (msg != "") {
                    $("#messages").append(`<div class="p2">
                                                <p>${msg}</p>
                                            </div>`);
                    $(".message_input").val("");
                    $("#messages").animate({
                        scrollTop: $('#messages')[0].scrollHeight
                    }, 100);

                    $.post(url, {
                        message: msg,
                        from: 3,
                        to: 4
                    });
                }
            }
        });
        load();
        loadUserOnline();
        loadChatData();
    });

    function loadUserOnline() {
        $.get('../useronline.php', function(data) {
            if (data.user) {
                data.user.forEach(getuser => {
                    $('#user-list').append(ShowUser(getuser));
                })
            };
        });
    }

    function load() {
        $.get(url + '?start=' + start + '&userid=' + 4, function(result) {
            if (result.items) {
                result.items.forEach(item => {
                    start = item.id;
                    if (item.from_id == 4 && item.to_id == 3) {
                        $('#messages').append(renderMessage(item));
                    } else if (item.from_id == 3 && item.to_id == 4) {
                        $('#messages').append(renderMyMessage(item));
                    }
                });

                $("#messages").animate({
                    scrollTop: $('#messages')[0].scrollHeight
                });
            };
        });
    }

    function loadChatData() {
        $.ajax({
            method: 'GET',
            dataType: 'JSON',
            url: url,
            data: {
                userid: 4
            },
            cache: true,
            success: function(data) {
                for (i = 0; i < data.items.length; i++) {
                    let msg_i = $('#p1-' + data.items[i].chat_id);
                    if (msg_i.length == 0 && data.items[i].from_id == 4 &&
                        data.items[i].to_id == 3) {
                        $('#messages').append(
                            `<div class="p1" id="p1-${data.items[i].chat_id}">
                                    <img src="../IMG/profile/Screenshot 2021-03-11 155950.png"
                                        class="user_icon_small" />
                                    <p class="msg">${data.items[i].message}</p>
                                </div>`
                        );
                        $("#messages").animate({
                            scrollTop: $('#messages')[0].scrollHeight
                        });
                    }
                }
            },
            complete: function() {
                setTimeout(function() {
                    loadChatData();
                }, 3000);
            }
        });
    }

    function ShowUser(user) {
        user_list = `
            <div class="user" id="user-list-${user.id}">
                <img src="../IMG/profile/${user.Picture}" alt="" class="user_icon" 
                onerror="this.onerror=null;this.src='../IMG/profile/default_user.jpg';">
                <h3 class="username"> ${user.name} </h3>
                <i class="fas fa-circle"></i>
            </div>`;
        let user_list_id = $('#user-list-' + user.id);

        return user_list;
    }

    function renderMessage(item) {
        let message = '';
        let p1_chatid = $('#p1-' + item.chat_id);

        if (item.message.length > 0) {
            message = `<div class="p1" id="p1-${item.chat_id}">
                        <img src="../IMG/profile/Screenshot 2021-03-11 155950.png"
                            class="user_icon_small" />
                        <p class="msg">${item.message}</p>
                    </div>
                    `;
        }

        return message;
    }

    function renderMyMessage(item) {
        let message = '';
        let p1_chatid = $('#p1-' + item.chat_id);

        if (item.message.length > 0 && item.from_id == 3) {
            message = ` <div class="p2">
                            <p>${item.message}</p>
                        </div>
                    `;
        }

        return message;
    }
    </script>
    <!-- END Chat Script -->

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html>