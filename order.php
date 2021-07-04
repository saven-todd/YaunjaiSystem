<?php session_start(); ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <?php 
        require_once "db.php";
        include_once "include/headerauth.php";

    ?>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="Backend/js/script.js"></script>
    <!-- jsFiddle will insert css and js -->
    <style>
    /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
    </style>
</head>

<body>
    <script type="text/javascript">
    $(document).ready(function() {
        LatLngValue();

        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });

    function LatLngValue() {
        navigator.geolocation.getCurrentPosition(function(position) {
            var customer_lat, customer_lng;
            customer_lat = document.getElementById('lat');
            customer_lng = document.getElementById('lng');

            customer_lat.value = position.coords.latitude;
            customer_lng.value = position.coords.longitude;
            // customer_lat.value = 17.4335917 ;
            // customer_lng.value = 102.7480011 ;
        });
    }


    function updateSubmit() {

        if (document.formupdate.cus_id.value == 9999) {
            alert('กรุณาลงชื่อเช้าใช้เพื่อสั่งซื้อสินค้า หรือ สมัครสมาชิกก่อน.!');
            return false;
        }
        if (document.formupdate.order_fullname.value == "") {
            alert('โปรดใส่ชื่อนามสกุลด้วย!');
            document.formupdate.order_fullname.focus();
            return false;
        }
        if (document.formupdate.order_address.value == "") {
            alert('โปรดใส่ที่อยู่ด้วย!');
            document.formupdate.order_address.focus();
            return false;
        }
        if (document.formupdate.order_phone.value == "") {
            alert('โปรดใส่เบอร์โทรด้วย!');
            document.formupdate.order_phone.focus();
            return false;
        }
        if (document.formupdate.lat.value == "" && document.formupdate.lng.value == "") {
            alert('ผิดพลาด โปรดลองใหม่อีกครั้งหรือรีเฟรชหน้านี้!');
            return false;
        }
        if (document.formupdate.total.value <= 0) {
            alert('ผิดพลาด โปรดลองใหม่อีกครั้งหรือรีเฟรชหน้านี้!');
            return false;
        }

    }
    </script>

    <div class="container">
        <!-- Static navbar -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">หน้าแรกสินค้า</a></li>
                        <li><a href="cart.php">ตะกร้าสินค้าของฉัน <span class="badge"><?php echo $meQty; ?></span></a>
                        </li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
            <!--/.container-fluid -->
        </div>
        <h3>รายการสั่งซื้อ</h3>
        <!-- Main component for a primary marketing message or call to action -->
        <?php
            if($ID !== ''){    
                $check_stmt = "SELECT name,lastname,tel,addr,RemainingPoints FROM user WHERE ID = $ID OR fb_id = '$ID';";
            }
            $_stmt = $con->query($check_stmt);
            $_result = $_stmt->fetch_assoc();

            if ($action == 'removed')
            {
            echo "<div class=\"alert alert-warning\">ลบสินค้าเรียบร้อยแล้ว</div>";
            }
            
            if ($meCount == 0)
            {
            echo "<div class=\"alert alert-warning\">ไม่มีสินค้าอยู่ในตะกร้า</div>";
            } else
            {
        ?>

        <form action="order_insert.php" method="post" name="formupdate" role="form" id="formupdate"
            onsubmit="JavaScript:return updateSubmit();">
            <input type="text" name="cus_id" id="" value="<?=$ID?>" hidden>
            <div class="form-group">
                <label for="exampleInputEmail1">ชื่อ-นามสกุล : </label>
                <input type="text" class="form-control" id="order_fullname" placeholder="ใส่ชื่อนามสกุล"
                    name="order_fullname"
                    value="<?=$_result['name'] ?? $_result['name']=$name ?> <?=$_result['lastname'] ?? $_result['lastname']='' ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="exampleInputAddress">ที่อยู่ : </label>
                <textarea class="form-control" rows="3" name="order_address" id="order_address"
                    required><?=$_result['addr'] ?? $_result['addr']='' ?></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputPhone">เบอร์โทรศัพท์ : </label>
                <input type="text" class="form-control" id="order_phone"
                    placeholder="ใส่เบอร์โทรศัพท์ที่สามารถติดต่อได้" name="order_phone"
                    value="<?=$_result['tel'] ?? $_result['tel']='' ?>" pattern="\d*" maxlength="10" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPhone">Email : </label>
                <input type="email" class="form-control" id="order_email" placeholder="example@example.com"
                    name="order_email" value="<?=$email?>" required>
            </div>

            <div class="form-group">
                <div id="map"></div>
            </div>

            <div class="form-group">
                <input type="text" name="lat" id="lat" hidden>
                <input type="text" name="lng" id="lng" hidden>
            </div>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>รหัสสินค้า</th>
                        <th>ชื่อสินค้า</th>
                        <th>รายละเอียด</th>
                        <th>จำนวน</th>
                        <th>ราคาต่อหน่วย</th>
                        <th>จำนวนเงิน</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $total_price = 0;
                        $num = 0;
                        while ($meResult = mysqli_fetch_assoc($meQuery))
                        {
                        $key = array_search($meResult['p_id'], $_SESSION['cart']);
                        $total_price = $total_price + ($meResult['p_price'] * $_SESSION['qty'][$key]);
                    ?>
                    <tr>
                        <td><?php echo $meResult['p_id']; ?></td>
                        <td><?php echo $meResult['p_name']; ?></td>
                        <td><?php echo $meResult['p_detail']; ?></td>
                        <td>
                            <?php echo $_SESSION['qty'][$key]; ?>
                            <input type="hidden" name="qty[]" value="<?php echo $_SESSION['qty'][$key]; ?>" />
                            <input type="hidden" name="p_id[]" value="<?php echo $meResult['p_id']; ?>" />
                            <input type="hidden" name="p_price[]" value="<?php echo $meResult['p_price']; ?>" />
                        </td>
                        <td><?php echo number_format($meResult['p_price'], 2); ?></td>
                        <td><?php echo number_format(($meResult['p_price'] * $_SESSION['qty'][$key]), 2); ?></td>
                    </tr>
                    <?php
                        $num++;

                        if ($_SESSION['qty'][$key] >= 10 ) {
                            
                            ?>

                    <tr>
                        <td><?php echo $meResult['p_id']; ?></td>
                        <td><?php echo $meResult['p_name']; ?> โปรโมชั่นแถมฟรี 1 ชิ้น</td>
                        <td><?php echo $meResult['p_detail']; ?></td>
                        <td>
                            1
                            <input type="hidden" name="qty[]" value="1" />
                            <input type="hidden" name="p_id[]" value="<?php echo $meResult['p_id']; ?>" />
                            <input type="hidden" name="p_price[]" value="0" />
                        </td>
                        <td><?php echo number_format($meResult['p_price'], 2); ?></td>
                        <td>0</td>
                    </tr>

                        <?php
                        }

                        }
                    ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="discount" id="checkbox_check">
                            ใช้ส่วนลด
                        </td>
                        <td colspan="3">
                            แต้มส่วนลดที่ใช้ได้ <?=$_result['RemainingPoints'] ? $_result['RemainingPoints'] : 0 ?> 
                            <input type="hidden" name="my_remainingPoints" id="my_remainingPoints"
                                value="<?=$_result['RemainingPoints']?>">

                            <input type="hidden" name="old_remainingPoints_2" id="old_remainingPoints_2">
                            <input type="hidden" name="new_remainingPoints" id="new_remainingPoints"
                                value="<?=$_result['RemainingPoints']?>">
                                แต้ม
                        </td>
                        <td style="padding: 9px 0px 0px 0;">
                            <input type="number" id="old_remainingPoints" name="old_remainingPoints" min="0"
                                max="<?=$_result['RemainingPoints']?>" value="0" disabled="disabled">
                        </td>
                        <td style="color:red;">
                            <span id="discount">0</span> ฿
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: right;">
                            <h4>จำนวนเงินรวมทั้งหมด <span
                                    id="totalText"><?php echo number_format($total_price, 2); ?></span> บาท</h4>
                            <input type="hidden" name="totalPrice" id="total" value="<?=$total_price?>" />
                            <input type="hidden" name="totalPrice2" id="total2"
                                value="<?=number_format($total_price, 2)?>" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: right;">
                            <input type="hidden" id="formid" name="formid" value="<?php echo $_SESSION['formid']; ?>" />
                            <a href="shopping.php" type="button"
                                class="btn btn-primary btn-lg">กลับไปเลือกสินค้าเพิ่ม</a>
                            <a href="auth_show_product_detail.php" type="button"
                                class="btn btn-danger btn-lg">ย้อนกลับ</a>
                            <button type="submit" class="btn btn-primary btn-lg"
                                onclick="return confirm('ยืนยันการสั่งซื้อสินค้า')">ชำระสินค้า</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
        <?php } ?>


    </div>
    <script>
    $(document).ready(function() {
        let discount, total, totalText;
        check = $('#checkbox_check');

        check.change(function() {
            let rmp = $('#old_remainingPoints');
            let rmp2 = $('#old_remainingPoints_2');
            let total2 = $('#total2').val();
            let new_rmp = $('#new_remainingPoints');
            let my_rmp = $('#my_remainingPoints');

            total = parseInt($('#total').val());
            totalText = $('#totalText');

            if ($('#checkbox_check').is(':checked')) {
                rmp.prop("disabled", false);
                rmp.change(function() {
                    rmpPoint = rmp.val();
                    discount = $('#discount').text(rmpPoint * 10);
                    discountPoint = rmpPoint * 10;

                    if (rmpPoint > rmp2.val()) {
                        let nouse = parseInt(total) - (rmpPoint * 10);
                        if (nouse <= 0) {
                            alert('ไม่สามารถใช้ส่วนลดได้มากกว่านี้ !! กรุณาลองใหม่');
                            totalText.text(total2);
                            $('#total').val(total2);
                            rmp.val(0);
                            discount.text(0);
                            rmp2.val(0);
                            new_rmp.val(0);
                        } else {
                            totalText.text(nouse.toLocaleString() + '.00');
                            $('#total').val(nouse);
                            new_rmp.val(my_rmp.val() - rmp.val());
                            rmp2.val(rmpPoint);
                        }
                    } else if (rmpPoint < rmp2.val()) {
                        let nouse = parseInt(total) - (rmpPoint * 10);
                        totalText.text(nouse.toLocaleString() + '.00');
                        new_rmp.val(parseInt(new_rmp.val()) + 1);
                        rmp2.val(rmpPoint);
                    }
                });

            } else {
                totalText.text(total2);
                $('#total').val(total2);
                rmp.val(0);
                $('#discount').text('0');
                rmp2.val(0);
                rmp.prop("disabled", true);
            }
        });
    });

    // Note: This example requires that you consent to location sharing when
    // prompted by your browser. If you see the error "The Geolocation service
    // failed.", it means you probably did not give permission for the browser to
    // locate you.
    let map, marker, infoWindow;

    function initMap() {

        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: 17.3986732,
                lng: 102.7937337,
            },
            zoom: 18
        });

        marker = new google.maps.Marker({
            position: {
                lat: 17.3986732,
                lng: 102.7937337
            },
            map,
            title: "Hello World เธอ.ฉัน.โลก.เรา เดอะมูฟวี่ พากย์ไทย และ ซับไทย",
        });

        navigator.geolocation.getCurrentPosition(function(position) {
            initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            map.setCenter(initialLocation);
            marker.setPosition(initialLocation);
        });

        infoWindow = new google.maps.InfoWindow();
        const locationButton = document.createElement("button");
        locationButton.textContent = "Pan to Current Location";
        locationButton.classList.add("custom-map-control-button");
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
        locationButton.addEventListener("click", () => {
            // Try HTML5 geolocation.
            if (navigator.geolocation) {

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        infoWindow.setPosition(pos);
                        infoWindow.setContent("Location found.");
                        infoWindow.open(map);
                        map.setCenter(pos);
                    },
                    () => {
                        handleLocationError(true, infoWindow, map.getCenter());
                    }
                );


            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
        });
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(
            browserHasGeolocation ?
            "Error: The Geolocation service failed." :
            "Error: Your browser doesn't support geolocation."
        );
        infoWindow.open(map);
    }
    </script>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbvy9FRDIpuVpWYzYkJyVb42DCbbIKwd8&callback=initMap&sensor=true"
        type="text/javascript"></script>
</body>
<?php include "include/footer.php" ?>

</html>