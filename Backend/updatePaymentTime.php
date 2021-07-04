<?php

require_once '../db.php';
require_once "function.inc.php";

$date = date('Y-m-d H:i:s',strtotime('-1 day'));
$sql = "SELECT OrderID,OrderDate,MemberID,cus_name,email,phone_order,order_total FROM v_receipt WHERE OrderDate <= '$date' AND (accept_FK = 1 OR accept_FK = 2) AND PayStatus_W < 1 ;";
$result = mysqli_query($con, $sql);

while($data = mysqli_fetch_array($result,MYSQLI_NUM)) {
    $orderID = $data[0];
    $orderDate = $data[1];
    $orderMemberid = $data[2];
    $orderCus_name = $data[3];
    $orderEmail = $data[4];
    $orderPhone = $data[5];
    $orderTotal = $data[6];

    $update_sql = "UPDATE orders SET accept_FK = 5 WHERE OrderID = $orderID ;";


    echo $orderID."<br>";
    // echo $date."<br>";
    // echo $orderDate."<br>";

    // Check statement
    try {
        mysqli_query($con, $update_sql);
        sendMailCancelOrder($orderID,$orderDate,$orderCus_name,$orderEmail,$orderPhone,$orderTotal);
    }
    catch(mysqli_query $e) {
      echo 'Message: ' .$e->getMessage();
    }
}

mysqli_close($con);

