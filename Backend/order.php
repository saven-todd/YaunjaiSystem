<?php session_start();
include_once '../db.php';

$orderID = $_GET['order_id'];
$sql = "SELECT * FROM v_receipt WHERE OrderID = $orderID ;";
$sql_stmt = mysqli_query($con,$sql);
$result = mysqli_fetch_assoc($sql_stmt);

switch ($result['PayStatus_W']) {
    case 0:
        $PayStatus_W = "<span style='color: red;'>ยังไม่แจ้งการชำระเงิน</span>";
        break;
    case 1:
        $PayStatus_W = "<span style='color: blue;'>รอตรวจสอบการชำระเงิน</span>
        <button type='button' onclick='paymentCheck($orderID)' class='btn btn-info'>Info</button> ";
        break;
    case 2:
        $PayStatus_W = "<span style='color: green;'>ชำระเงินเสร็จสิ้น</span>";
        break;
    default:
    echo "ขัดข้องโปรดแจ้งผู้ดูแลระบบ!";
}               

$_lat = $result['lat'];
$_lng = $result['lng'];

?>

<script>
function initMap() {
    var pointA = new google.maps.LatLng(17.3992447, 102.79184),
        pointB = new google.maps.LatLng(<?php echo $_lat;?>, <?php echo $_lng;?>),
        myOptions = {
            zoom: 16,
            center: pointA
        },
        map = new google.maps.Map(document.getElementById('map-directions'), myOptions),
        // Instantiate a directions service.
        directionsService = new google.maps.DirectionsService(),
        directionsDisplay = new google.maps.DirectionsRenderer({
            map: map
        }),
        markerA = new google.maps.Marker({
            position: pointA,
            title: "point A",
            label: "A",
            map: map
        }),
        markerB = new google.maps.Marker({
            position: pointB,
            title: "point B",
            label: "B",
            map: map
        });

    // get route from A to B
    calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB);
}

function calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB) {
    directionsService.route({
        origin: pointA,
        destination: pointB,
        avoidTolls: true,
        avoidHighways: false,
        travelMode: google.maps.TravelMode.DRIVING
    }, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        } else {
            window.alert('Directions request failed due to ' + status);
        }
    });
}

initMap();
</script>

<body>
    <?php
        if ($result['accept_FK'] == 2){
    ?>
    <div class="container">
        <h3 class="head">รายการสั่งซื้อ</h3>
        <!-- Main component for a primary marketing message or call to action -->
        <div class="form-group">
            <label class="col-3 ">รหัสลูกค้า : </label>
            <label class="order-detail"><?=$result['MemberID']?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">ชื่อ-นามสกุล :</label>
            <label><?php 
                if($result['name']==''){
                    echo $result['cus_name'];
                }else {
                    echo $result['name'];
                }
            ?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">วัน / เวลา สั่งซื้อ :</label>
            <label><?=$result['OrderDate']?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">ที่อยู่ :</label>
            <label><?=$result['MapLocation']?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">เบอร์โทรศัพท์ :</label>
            <label><?=$result['phone_order']?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">อีเมล :</label>
            <label><?=$result['email']?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">การชำระเงิน :</label>
            <label><?=$PayStatus_W?></label>
        </div>
        <div class="form-group">
            <label class="col-10">แผนที่ :</label>
            <div id="map-directions"></div>
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
                    foreach($sql_stmt AS $key => $value){
                        $total_price = $total_price + ($value['Price'] * $value['Number']);                        
                ?>
                <tr>
                    <td><?php echo $value['ProductID']; ?></td>
                    <td><?php echo $value['p_name']; ?></td>
                    <td><?php echo $value['p_detail']; ?></td>
                    <td><?php echo $value['Number']; ?></td>
                    <td><?php echo number_format($value['Price'], 2); ?></td>
                    <td><?php echo number_format(($value['Price'] * $value['Number']), 2);?></td>
                </tr>
                <?php  
                    }
                    mysqli_free_result($sql_stmt);
                ?>
                <tr>
                    <td colspan="8" style="text-align: right;">
                        <h5 class="total">จำนวนเงินรวมทั้งหมด <?=number_format($total_price, 2)?> บาท</h5>
                    </td>
                </tr>
                <tr>
                    <td colspan="8" style="text-align: right;">
                        <a id="btn-back-home" type="button" class="btn btn-danger btn-lg">ย้อนกลับ</a>
                        <a id="submit" type="submit" class="btn btn-primary btn-lg">ดำเนินการเสร็จสิ้น</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php } else if($result['accept_FK'] == 3) {
?>
    <div class="container">
        <h3 class="head">รายการสั่งซื้อ</h3>
        <!-- Main component for a primary marketing message or call to action -->
        <div class="form-group">
            <label class="col-3 ">รหัสลูกค้า : </label>
            <label class="order-detail"><?=$result['MemberID']?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">ชื่อ-นามสกุล :</label>
            <label><?php 
            if($result['name']==''){
                echo $result['cus_name'];
            }else {
                echo $result['name'];
            }
        ?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">วัน / เวลา สั่งซื้อ :</label>
            <label><?=$result['OrderDate']?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">ที่อยู่ :</label>
            <label><?=$result['MapLocation']?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">เบอร์โทรศัพท์ :</label>
            <label><?=$result['phone_order']?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">อีเมล :</label>
            <label><?=$result['email']?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">การชำระเงิน :</label>
            <label><?=$PayStatus_W?></label>
        </div>
        <div class="form-group">
            <label class="col-10">แผนที่ :</label>
            <div id="map-directions"></div>
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
                foreach($sql_stmt AS $key => $value){
                    $total_price = $total_price + ($value['Price'] * $value['Number']);                        
            ?>
                <tr>
                    <td><?php echo $value['ProductID']; ?></td>
                    <td><?php echo $value['p_name']; ?></td>
                    <td><?php echo $value['p_detail']; ?></td>
                    <td><?php echo $value['Number']; ?></td>
                    <td><?php echo number_format($value['Price'], 2); ?></td>
                    <td><?php echo number_format(($value['Price'] * $value['Number']), 2);?></td>
                </tr>
                <?php  
                }
                mysqli_free_result($sql_stmt);
                    
                if($value['PointsNumber'] > 0 ){
                    ?>
    
                    <tr style="align-items: center;">
                        <td colspan="4"> ใช้แต้มส่วนลด </td>
                        <td><?= $value['PointsNumber'] ?></td>
                        <td><?php echo number_format($value['PointsNumber'] * 10, 2);?></td>
                    </tr>
    
                    <?php
                    
                    }
            ?>
                <tr>
                    <td colspan="8" style="text-align: right;">
                        <h5 class="total">จำนวนเงินรวมทั้งหมด <?=number_format($total_price - ($value['PointsNumber'] * 10), 2)?> บาท</h5>
                    </td>
                </tr>
                <tr>
                    <td colspan="8" style="text-align: right;">
                        <a id="btn-back-home" type="button" class="btn btn-danger btn-lg">ย้อนกลับ</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php } else {
?>
    <div class="container">
        <h3 class="head">รายการสั่งซื้อ</h3>
        <!-- Main component for a primary marketing message or call to action -->
        <div class="form-group">
            <label class="col-3 ">รหัสลูกค้า : </label>
            <label class="order-detail"><?=$result['MemberID']?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">ชื่อ-นามสกุล :</label>
            <label><?php 
            if($result['name']==''){
                echo $result['cus_name'];
            }else {
                echo $result['name'];
            }
        ?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">วัน / เวลา สั่งซื้อ :</label>
            <label><?=$result['OrderDate']?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">ที่อยู่ :</label>
            <label><?=$result['MapLocation']?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">เบอร์โทรศัพท์ :</label>
            <label><?=$result['phone_order']?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">อีเมล :</label>
            <label><?=$result['email']?></label>
        </div>
        <div class="form-group">
            <label class="col-3 ">การชำระเงิน :</label>
            <label><?=$PayStatus_W?></label>
        </div>
        <div class="form-group">
            <label class="col-10">แผนที่ :</label>
            <div id="map-directions"></div>
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
                foreach($sql_stmt AS $key => $value){
                    $total_price = $total_price + ($value['Price'] * $value['Number']);                        
            ?>
                <tr>
                    <td><?php echo $value['ProductID']; ?></td>
                    <td><?php echo $value['p_name']; ?></td>
                    <td><?php echo $value['p_detail']; ?></td>
                    <td><?php echo $value['Number']; ?></td>
                    <td><?php echo number_format($value['Price'], 2); ?></td>
                    <td><?php echo number_format(($value['Price'] * $value['Number']), 2);?></td>
                </tr>
                <?php  
                }
                mysqli_free_result($sql_stmt);

                if($value['PointsNumber'] > 0 ){
                    ?>
    
                    <tr style="align-items: center;">
                        <td colspan="4"> ใช้แต้มส่วนลด </td>
                        <td><?= $value['PointsNumber'] ?></td>
                        <td><?php echo number_format($value['PointsNumber'] * 10, 2);?></td>
                    </tr>
    
                    <?php
                    
                    }
            ?>
                <tr>
                    <td colspan="8" style="text-align: right;">
                        <h5 class="total">จำนวนเงินรวมทั้งหมด <?=number_format($total_price - ($value['PointsNumber'] * 10), 2)?> บาท</h5>
                    </td>
                </tr>
                <tr>
                    <td colspan="8" style="text-align: right;">
                        <a id="btn-back-home" type="button" class="btn btn-danger btn-lg">ย้อนกลับ</a>
                        <a id="cancel" type="submit" class="btn btn-warning btn-lg">ยกเลิกคำสั่งซื้อ</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php } ?>

    <!--End Top Product-->
    <script>
    $('#submit').click(function() {

    });
    $('#cancel').click(function() {

    });
    $('#btn-back-home').click(function() {

    });

    var id = <?=$orderID?>;

    $('#cancel').click(function() {
        $.ajax({
            method: 'GET',
            url: 'order_update_data.php',
            data: {
                id: id,
                type: 'cancel'
            },
            cache: true,
            success: function(response) {
                if (response == 1) {
                    alert('ยกเลิกรายการสั่งซื้อนี้เรียบร้อย');
                    $('#data').load('order_list.php');
                } else {
                    alert('Just Error !');
                }
            }
        });
    });

    $('#submit').click(function() {
        $.ajax({
            method: 'GET',
            url: 'order_update_data.php',
            data: {
                id: id,
                type: 'pending'
            },
            cache: true,
            success: function(response) {
                if (response == 1) {
                    alert('ดำเนินการเรียบร้อยรอส่งมอบสินค้า');
                    $('#data').load('order_list.php');
                } else {
                    alert('Just Error !');
                }
            }
        });
    });

    $('#btn-back-home').click(function() {
        $.ajax({
            method: 'POST',
            url: 'admin_home.php',
            cache: true,
            success: function(response) {
                $('#home-btn').addClass("active");
                $(".list-group-item").not(this).removeClass("active");
                $('#data').html(response);
            }
        });
    });
    </script>
</body>