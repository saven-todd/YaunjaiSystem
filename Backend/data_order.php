<?php
require_once '../db.php';

$sql = "SELECT notification_FK FROM v_noti_bar WHERE notification_FK = 1 ;";
$result = $con->query($sql);

echo $result->num_rows;

$con->close();