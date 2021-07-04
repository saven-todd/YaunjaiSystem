<?php
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้า

$_order_id = $_GET['order_id'];

$sql = "DELETE FROM orders WHERE OrderID = $_order_id ;";
$sql_detail = "DELETE FROM orderdetails WHERE OrderID = $_order_id ;";

$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
if($result === true){
    mysqli_query($con, $sql_detail) or die ("Error in query: $sql " . mysqli_error($con));
}
mysqli_close($con); //ปิดการเชื่อมต่อ database 