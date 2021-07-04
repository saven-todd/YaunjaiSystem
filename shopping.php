<?php session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php 
    include_once "include/headerauth.php" ;
        
    if($action == 'exists'){
        echo "<div class=\"alert alert-warning\">เพิ่มจำนวนสินค้าแล้ว</div>";
    }
    if($action == 'add'){
        echo "<div class=\"alert alert-success\">เพิ่มสินค้าลงในตะกร้าเรียบร้อยแล้ว</div>";
    }
    if($action == 'order'){
        echo "<div class=\"alert alert-success\">สั่งซื้อสินค้าเรียบร้อยแล้ว</div>";
    }
    if($action == 'orderfail'){
        echo "<div class=\"alert alert-warning\">สั่งซื้อสินค้าไม่สำเร็จ มีข้อผิดพลาดเกิดขึ้นกรุณาลองใหม่อีกครั้ง</div>";
    }   

    ?>

</head>

<body>

<!-- SCRIPT -->
<script>
var from = <?=$ID?>,
    start = 0,
    url = 'user_chat.php';

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
                from: from
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
                    from: from
                });
            }
        }
    });
    load();
    loadChatData();
});

function load() {
    $.get(url + '?start=' + start + '&userid=' + from, function(result) {
        if (result.items) {
            result.items.forEach(item => {
                start = item.id;
                if (item.from_id == 3 && item.to_id == from) {
                    $('#messages').append(renderMessage(item));
                } else if (item.from_id == from && item.to_id == 3) {
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
            userid: from
        },
        cache: true,
        success: function(data) {
            console.log(data.length);
            if (data.length) {
                for (i = 0; i < data.items.length; i++) {
                    let msg_i = $('#p1-' + data.items[i].chat_id);

                    if (msg_i.length == 0 && data.items[i].from_id == 3 && data.items[i].to_id ==
                        from) {
                        $('#messages').append(
                            `<div class="p1" id="p1-${data.items[i].chat_id}">
                                <img src="IMG/profile/img_avatar.png"
                                    class="user_icon_small" />
                                <p class="msg">${data.items[i].message}</p>
                            </div>`
                        );
                        $("#messages").animate({
                            scrollTop: $('#messages')[0].scrollHeight
                        });
                    }
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


function renderMessage(item) {
    let message = '';
    let p1_chatid = $('#p1-' + item.chat_id);

    if (item.message.length > 0) {
        message = `<div class="p1" id="p1-${item.chat_id}">
                    <img src="IMG/profile/img_avatar.png"
                        class="user_icon_small" />
                    <p class="msg">${item.message}</p>
                </div>
                `;
    }
    return message;
}

function renderMyMessage(item) {
    // console.log(item)
    let message = '';
    let p1_chatid = $('#p1-' + item.chat_id);

    if (item.message.length > 0 && item.from_id == from) {
        message = ` <div class="p2">
                      <p>${item.message}</p>
                    </div>
                `;
    }
    return message;
}
</script>
    <br>

    <!--slider-->
    <div class="container">
        <div class="row">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="IMG/slider/001.png" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="IMG/slider/002.png" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="IMG/slider/003.png" alt="Third slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="IMG/slider/004.png" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
    <!--End Slider-->
    <br>
    <!--Start Top Product-->
    <div class="container">
        <div class="card-deck">
            <?php 
                if(isset($_GET['search']) && $_GET['search'] != ''){
                    $item = $_GET['search'] ;
                    // echo $item;
                    include_once "show_productauth.php";
                } else {
                    include_once 'show_productauth.php';
                }
            ?>
        </div>
    </div>
<?php 
if ($ID != 9999) {
    
?>
    <!-- MAIN CHATBOX -->
    <div class="chat_box">
        <div class="chat_header">
            <h1 class="chat_heading">Contacts</h1>
        </div>
        <div class="chat_content" id="user-list" style="display: none;">
            <div class="user" id="user-list-${user.id}">
                <img src="IMG/profile/img_avatar.png" alt="" class="user_icon"
                    onerror="this.onerror=null;this.src='../IMG/profile/default_user.jpg';">
                <h3 class="username"> Admin </h3>
                <i class="fas fa-circle"></i>
            </div>
        </div>
    </div>
    <!-- MESSAGER BOX -->
    <div class="message_box">
        <div class="message_header">
            <img src="IMG/profile/img_avatar.png" onerror="myFunction()" alt="" class="user_icon">
            <h1 class="chat_heading">OIL</h1>
            <i class="fas fa-times"></i>
        </div>
        <div class="message_content" style="display: none;">
            <div class="messages" id="messages">
                <!-- <div class="p1">
                    <img src="../IMG/profile/140025020_461274638205659_8725058576104662482_n.jpg"
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

<?php

} // End If.

?>

    <!--End Top Product-->
    <!-- END Chat Script -->
</body>
<?php include "include/footer.php" ?>

</html>