<?php
require_once '../db.php';

$min_date = date("Y-m-d 00:00:00");
$min_date_2 = date("Y-m-d 00:00:00",strtotime('-7 days'));
$max_date = date("Y-m-d h:i:s");

$_sql_order = "SELECT OrderID FROM orders WHERE OrderDate > '$min_date';";
$_order_result = mysqli_query($con,$_sql_order);
$_num_order = mysqli_num_rows($_order_result);

$_sql_queues = "SELECT OrderID FROM orders WHERE OrderDate > '$min_date' AND (accept_FK = 1 OR accept_FK = 2) ;";
$_queues_result = mysqli_query($con,$_sql_queues);
$_num_queues = mysqli_num_rows($_queues_result);

$_sql_income = "SELECT SUM(sum) AS SUM FROM noti_ul WHERE OrderDate > '$min_date' ;";
$_income_result = mysqli_query($con,$_sql_income);
$_income = mysqli_fetch_assoc($_income_result);

$_sql_cancel = "SELECT OrderID FROM orders WHERE (accept_FK = 0 OR accept_FK = 5) AND OrderDate > '$min_date_2' ;";
$_cancel_result = mysqli_query($con,$_sql_cancel);
$_num_cancel = mysqli_num_rows($_cancel_result);

$data = ['order'=>$_num_order ,'queues'=>$_num_queues,'income'=>number_format($_income['SUM'],2) ,'cancel'=>$_num_cancel];

echo json_encode($data, true);
