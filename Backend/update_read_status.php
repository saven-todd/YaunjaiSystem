<?php
include_once '../db.php';

if(isset($_POST['order_id'])){
$order_id = $_POST['order_id'];    
$sql = "UPDATE orders SET read_status = 0 WHERE OrderID = $order_id;";

$con->query($sql);

}
