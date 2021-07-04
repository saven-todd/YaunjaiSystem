<?php
require_once '../db.php';

$id = $_GET['id'];
$type = $_GET['type'];

if($type == 'cancel'){
    $sql = "UPDATE orders SET accept_FK = 0 WHERE OrderID = $id;";
    $result = $con->query($sql);
} elseif($type == 'pending'){
    $sql = "UPDATE orders SET accept_FK = 3 WHERE OrderID = $id;";
    $result = $con->query($sql);
}

if($result === true){
    echo 1;
} else {
    echo 2;
}

$con->close();