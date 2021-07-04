<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test Chat box</title>

    <!-- CSS -->
    <link rel="stylesheet" href="chat_style.css">

    <!-- Chat Jqeury -->
    <!-- <script src="chat_main.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <!-- fontawsome -->
    <script src="https://kit.fontawesome.com/e01de64041.js" crossorigin="anonymous"></script>

    <!-- SCRIPT -->
    <script>
    var from = null,
        start = 0,
        url = 'chat.php';

    $(document).ready(function() {
        $(".chat_header").click(function() {
            $(".chat_content").slideToggle("slow");
        });

        $(".message_header").click(function() {
            $(".message_content").slideToggle("slow");
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
                $(".new_messages").append("<p>" + msg + "</p>");
                $(".message_input").val("");

                $.post(url, {
                    message: msg,
                    from: 3
                });
            }
        });

        $('.message_input').keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                var msg = $(".message_input").val();
                if (msg != "") {
                    $(".new_messages").append("<p>" + msg + "</p>");
                    $(".message_input").val("");

                    $.post(url, {
                        message: msg,
                        from: 3
                    });
                }
            }
        });
        load();
    });

    function load() {
        $.get(url + '?start=' + start, function(result) {
            if (result.items) {
                result.items.forEach(item => {
                    start = item.id;
                    $('#messages').append(renderMessage(item));
                })
            };
        });
    }

    function renderMessage(item) {
        console.log(item);
        return `
                <div class="p1">
                    <img src="IMG/profile/140025020_461274638205659_8725058576104662482_n.jpg"
                        class="user_icon_small" />
                    <p>${item.message}</p>
                </div>
                `;
    }
    </script>
</head>

<body>
    <!-- MAIN CHATBOX -->
    <div class="chat_box">
        <div class="chat_header">
            <h1 class="chat_heading">Contacts</h1>
        </div>
        <hr>
        <div class="chat_content" id="user-list">
            <div class="user">
                <img src="IMG/profile/140025020_461274638205659_8725058576104662482_n.jpg" alt="" class="user_icon">
                <h3 class="username"> OIL </h3>
                <i class="fas fa-circle"></i>
            </div>
            <div class="user">
                <img src="IMG/profile/140025020_461274638205659_8725058576104662482_n.jpg" alt="" class="user_icon">
                <h3 class="username"> OIL </h3>
                <i class="fas fa-circle"></i>
            </div>
        </div>
    </div>
    <!-- MESSAGER BOX -->
    <div class="message_box">
        <div class="message_header">
            <img src="" alt="" class="user_icon">
            <h3 class="username"> OIL </h3>
            <i class="fas fa-times"></i>
        </div>
        <hr>
        <div class="message_content">
            <div class="messages">
                <div class="p1">
                    <img src="IMG/profile/140025020_461274638205659_8725058576104662482_n.jpg"
                        class="user_icon_small" />
                    <p>This message is from him</p>
                </div>

                <div class="p1">
                    <img src="IMG/profile/140025020_461274638205659_8725058576104662482_n.jpg"
                        class="user_icon_small" />
                    <p>This message is from him</p>
                </div>

                <div class="p2">
                    <p>This is from ME</p>
                </div>
                <div class="new_messages p2"></div>
            </div>
            <div id="sent-centainer" class="input_box">
                <input type="text" id="message" class="message_input" autocomplete="off" autofocus
                    placeholder="Type a message...">
                <i class="fas fa-location-arrow enter"></i>
            </div>
        </div>
    </div>
</body>

</html>