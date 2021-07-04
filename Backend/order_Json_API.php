<?php
include_once '../db.php';

$sql1 = "SELECT * FROM noti_ul ;";
$sql2 = "SELECT DISTINCT * FROM v_receipt ;";

$sql_stmt = $con->query($sql1);
$sql_stmt2 = $con->query($sql2);


// $result = $sql_stmt->fetch_assoc();
// $result2 = $sql_stmt2->fetch_assoc();

$data = mysqli_fetch_all($sql_stmt, MYSQLI_ASSOC);
$data_order = mysqli_fetch_all($sql_stmt2, MYSQLI_ASSOC);
$jsonData = json_encode(array('order'=>$data , 'receipt' => $data_order));
 
echo $jsonData;