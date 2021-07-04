<?php
session_start();
include_once '../db.php';

$order_id = $_GET['order_id'];

$sql = "UPDATE orders SET accept_FK = 3 WHERE order_id = $order_id ;";
$result = mysqli_query($con,$sql);

if($order_id == 0){
    $sql = "UPDATE orders SET accept_FK = 0 WHERE order_id = $order_id ;";
    $result = mysqli_query($con,$sql);

    if($result){
        echo "<script type='text/javascript'>";
        echo "alert(ยกเลิกรายการเรียบร้อยแล้ว');";
        echo "window.location = 'past_list.php?a=act'; ";        
        echo "</script>";
        } else {
        echo "<script type='text/javascript'>";
        echo "alert('ผิดพลาดด !!');";        
        echo "window.location = 'past_list.php?a=arg'; ";  
        echo "</script>";
        }
}


if($result){
    echo "<script type='text/javascript'>";
    echo "alert('ดำเนินการเสร็จเรียบร้อย ♥''');";
    echo "window.location = 'past_list.php?a=act'; ";        
    echo "</script>";
    } else {
    echo "<script type='text/javascript'>";
    echo "alert('ผิดพลาดด !!');";        
    echo "window.location = 'past_list.php?a=arg'; ";  
    echo "</script>";
    }