<?php session_start(); 
    require_once 'db.php';
    $order_id = $_GET['OrderID'];

    $sql = "SELECT * FROM v_receipt WHERE OrderID = $order_id ;";
    $result = mysqli_query($con,$sql);
    $data = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งชำระเงิน</title>
    <?php include "include/headerauth.php"; ?>
</head>

<body>
    <?php
    if($action == 'succsess'){
        echo "<div class=\"alert alert-success\">สั่งซื้อสินค้าเรียบร้อยแล้ว</div>";
    }elseif($action == 'orderfail'){
        echo "<div class=\"alert alert-warning\">สั่งซื้อสินค้าไม่สำเร็จ มีข้อผิดพลาดเกิดขึ้นกรุณาลองใหม่อีกครั้ง</div>";
    }
    ?>

    <div id="main-dock" class="container">
        <div class="row">
            <div class="col-3">
                <div class="list-group">
                    <a href="info.php" class="list-group-item list-group-item-action">ข้อมูลส่วนตัว</a>
                    <a href="past_list.php" class="list-group-item list-group-item-action">รายการสั่งซื้อที่ผ่านมา</a>
                    <a href="#" class="list-group-item list-group-item-action">ดูเมนูโปรด</a>
                    <hr>
                    <a href="logout.php" class="list-group-item list-group-item-action "
                        onclick="return confirm('คุณต้องการออกจากระบบหรือไม่ ?')">ออกจากระบบ</a>
                </div>
            </div>

            <div class="col-6">
                <h3 align="center">แจ้งการชำระเงิน</h3>
                <hr>
                <script
                    src="https://www.paypal.com/sdk/js?client-id=AYB5ZrS0HaZ3pPAsMOjiWO_zrZ1tyZIg0pU9T_snAdS0nuE732-XqIUDYh1pYglygkmBPN9uVlMyeb2b&currency=THB&locale=th_TH">
                </script>

                <div id="paypal-button-container"></div>
                <script>
                paypal.Buttons({
                    createOrder: function(data, actions) {
                        // This function sets up the details of the transaction, including the amount and line item details.
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: '<?=$data['order_total']?>'
                                }
                            }]
                        });
                    },
                    onApprove: function(data, actions) {
                        // This function captures the funds from the transaction.
                        return actions.order.capture().then(function(details) {
                            // This function shows a transaction success message to your buyer.
                            if (details.status == "COMPLETED") {
                                alert('Transaction completed by ' + details.payer.name.given_name);
                                console.log(details);
                                document.getElementById("payfrom-7").selected = "true";
                                document.getElementById("payto-3").selected = "true";

                                var date = new Date();
                                
                                function addZero(v) {
                                    if (v < 10) {
                                        v = '0'+v;
                                    }
                                    return v;
                                }

                                let sysDate = new Date(),
                                    userDate = sysDate.getFullYear()+'-'+addZero(sysDate.getMonth())+'-'+sysDate.getDate();
                                let sysTime = new Date(),
                                    userTime = sysTime.getHours()+':'+sysTime.getMinutes()+':00';

                                let PayPalID = details.id;
                                let last4number = PayPalID.slice(-4);

                                // document.getElementById("pay_date").valueAsDate = userDate;
                                // document.getElementById("pay_time").valueAsDate = userTime;
                                // document.getElementById("last_payment_id").value = last4number;

                                // $.ajax({
                                //     method: "POST",
                                //     url: "payment_notification_insert.php",
                                //     data: {
                                //         orderid: <?=$order_id;?>,
                                //         pay_date: userDate,
                                //         pay_time: userTime,
                                //         payfrom: 7,
                                //         payto: 7,
                                //         last_payment_id: last4number
                                //     },
                                //     success: function(response) {
                                //         // console.log(response)
                                //     }
                                // });

                                $.post("payment_notification_insert.php", {
                                    orderid: <?=$order_id;?>,
                                    pay_date: userDate,
                                    pay_time: userTime,
                                    payfrom: 7,
                                    payto: 7,
                                    last_payment_id: last4number
                                }, function(result) {
                                    // $(document).html(result);
                                    console.log(result);
                                    // window.location = 'past_list.php?a=act';
                                    $('#main-dock').html(result);
                                });
                            } else {
                                alert('พบข้อผิดพลาดในการทำรายการกรุณาลองใหม่อีกครั้ง');
                            }
                        });
                    }
                }).render('#paypal-button-container');
                //This function displays Smart Payment Buttons on your web page.
                </script>

                <hr>
                <form name="register" action="payment_notification_insert.php" method="POST" class="form-horizontal"
                    enctype="multipart/form-data">
                    <input type="hidden" name="orderid" value="<?=$order_id;?>">

                    <div class="form-group">
                        <div class="col-sm-10" align="left">
                            <label for="" class="obj-text col-sm-6">หลักฐานการโอน</label>
                            <input type="file" name="slip_img" id="slip_img" class="form-control col-sm-6">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10" align="left">
                            <label for="" class="obj-text col-sm-6">วันที่โอน</label>
                            <input type="date" name="pay_date" id="pay_date" class="form-control col-sm-6">
                            <!-- <input name="m_username" type="text" required class="form-control" id="m_username"
                                        value="<?=$username;?>" placeholder="ชื่อผู้ใช้งาน" pattern="^[a-zA-Z0-9]+$"
                                        title="ภาษาอังกฤษหรือตัวเลขเท่านั้น" minlength="2" /> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10" align="left">
                            <label for="" class="obj-text col-sm-6">เวลาโอน</label>
                            <input type="time" name="pay_time" id="pay_time" class="form-control col-sm-6">

                            <!-- <input name="m_password" type="m_password" required class="form-control"
                                        id="m_password" value="<?=$password;?>" placeholder="รหัสผ่าน"
                                        pattern="^[a-zA-Z0-9]+$" minlength="2" /> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10" align="left">
                            <label for="" class="obj-text col-sm-6">โอนจากธนาคาร</label>
                            <select name="payfrom" id="" class="form-control col-sm-6">
                                <option value="" selected='selected' disabled> - เลือก - </option>
                                <option id="payfrom-1" value="1"> ธนาคารกสิกร </option>
                                <option id="payfrom-2" value="2"> ธนาคารไทยพานิชย์ </option>
                                <option id="payfrom-3" value="3"> ธนาคารกรุงไทย </option>
                                <option id="payfrom-4" value="4"> ธนาคารกรุงเทพ </option>
                                <option id="payfrom-5" value="5"> ธนาคารทหารไทย </option>
                                <option id="payfrom-6" value="6"> ธนาคารกรุงศรี </option>
                                <option id="payfrom-7" value="7"> PayPal </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10" align="left">
                            <label for="" class="obj-text col-sm-6">โอนมาที่บัญชี</label>
                            <select name="payto" id="" class="form-control col-sm-6">
                                <option value="" selected='selected' disabled> - เลือก - </option>
                                <option id="payto-1" value="1"> ธนาคารกสิกร </option>
                                <option id="payto-2" value="2"> ธนาคารไทยพานิชย์ </option>
                                <option id="payto-3" value="7"> PayPal </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10" align="left">
                            <label for="" class="obj-text col-sm-6">เลขที่บัญชี 4 ตัวสุดท้าย</label>
                            <input name="last_payment_id" type="text" required class="form-control col-sm-6"
                                id="last_payment_id" placeholder="เลขที่บัญชี 4 ตัวสุดท้าย" maxlength="4">
                        </div>
                    </div>
                    <div class="f-10 ">
                        <button type="submit" class="btn btn-outline-success" id="btn">อัพโหลดข้อมูลการโอนเงิน</button>
                    </div>
                </form>
                <div class="f-10 ">
                    <a href="past_list.php" class="btn btn-outline-danger"> ยกเลิกการแจ้งชำระเงิน </a>
                </div>
            </div>
        </div>
    </div>
    <?php include "include/footer.php" ?>
</body>

</html>