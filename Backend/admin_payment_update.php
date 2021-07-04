<?php
session_start();
//1. เชื่อมต่อ database: 
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//Set ว/ด/ป เวลา ให้เป็นของประเทศไทย
date_default_timezone_set('Asia/Bangkok');

$orderid = $_POST['order_id'];

$sql = "UPDATE orders SET PayStatus_W = 2 , accept_FK = 2 WHERE OrderID = $orderid ;";
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));

if($result){
echo "<script type='text/javascript'>";
echo "alert('อัพเดทการชำระเงินเรียบร้อย');";
echo "$.ajax({
        url: 'order.php',
        data:{order_id: $orderid},
        cache: true,
        success: function(response) {
            $('#data').html(response);
        }
    });";
echo "</script>";
}
else{
echo "<script type='text/javascript'>";
echo "alert('เกิดข้อผิดพลาดผิดพลาด ทำรายการไม่สำเร็จ');";
echo "$.ajax({
        url: 'order.php',
        data:{order_id: $orderid},
        cache: true,
        success: function(response) {
            $('#data').html(response);
        }
    });";
echo "</script>";
}                        