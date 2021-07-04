<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once 'db.php';

$sql = "SELECT * FROM user WHERE ID <> 3 ; ";
$result = mysqli_query($con, $sql);


while ($row = mysqli_fetch_assoc($result)){
    $data['user'][] = $row ;
}

mysqli_close($con);

echo json_encode($data);