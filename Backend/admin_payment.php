<?php session_start();
    include_once '../db.php';
    $_order_id = $_GET['order_id'];

    $sql = "SELECT * FROM v_payment WHERE order_id = $_order_id ;";
    $result = mysqli_query($con,$sql);
    $data = mysqli_fetch_assoc($result);
?>

<script>
var orderid = <?=$order_id?>;
$('#btn-success').click(function() {
    $.ajax({
        method: 'POST',
        url: 'admin_payment_update.php',
        data: {
            order_id: orderid
        },
        cache: true,
        success: function(response) {
            $('#data').html(response);
            console.log(response);
        }
    });
});
</script>

<div class="container">
    <h3 align="center">แจ้งการชำระเงิน</h3>
    <input type="hidden" name="orderid" value="<?=$order_id;?>">

    <div class="form-group">
        <label class="col-3 ">เลขที่การชำระเงิน : </label>
        <label class="order-detail"><?=$data['id']?></label>
    </div>
    <div class="form-group">
        <label class="col-3 ">คำสั่งซื้อ : </label>
        <label class="order-detail"><?=$data['order_id']?></label>
    </div>
    <div class="form-group">
        <label class="col-3 ">วันที่ชำระ : </label>
        <label class="order-detail"><?=$data['pay_date']?></label>
    </div>
    <div class="form-group">
        <label class="col-3 ">เวลาที่ชำระ : </label>
        <label class="order-detail"><?=$data['pay_time']?></label>
    </div>
    <div class="form-group">
        <label class="col-3 ">โอนจาก : </label>
        <label class="order-detail"><?=$data['p_from_name']?> (<?=$data['p_from_s']?>)</label>
    </div>
    <div class="form-group">
        <label class="col-3 ">ไปยัง บช. : </label>
        <label class="order-detail"><?=$data['p_from_name']?> (<?=$data['p_from_s']?>)</label>
    </div>
    <div class="form-group">
        <label class="col-3 ">เลขท้าย บช. : </label>
        <label class="order-detail"><?=$data['last_payment_id']?></label>
    </div>
    <div class="form-group">
        <label class="col-3 ">หลักฐานการโอน : </label>
        <img src="../IMG/Slip/<?=$data['img']?>" alt="">
    </div>

    <div class="f-10 ">
        <button type="button" class="btn btn-outline-success" id="btn-success">ยืนยันการชำระเงิน</button>
    </div>
    <div class="f-10 ">
        <a href="admin.php" class="btn btn-outline-danger"> ย้อนกลับ </a>
    </div>

</div>