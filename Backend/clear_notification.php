<?php
require_once '../db.php';

$sql = "UPDATE orders SET notification_FK = 0 ;";
$con->query($sql);
$sql_noti = "UPDATE noti_bar SET n = 0 ;";
$con->query($sql_noti);

echo 0;

$con->close();