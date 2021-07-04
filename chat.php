<?php

require_once 'db.php';

$result = array();
$message = mysqli_escape_string($con, isset($_POST['message']) ? $_POST['message'] : null );
$from = isset($_POST['from']) ? $_POST['from'] :null ;
$to = isset($_POST['to']) ? $_POST['to'] :null ;
$userid = isset($_GET['userid']) ? $_GET['userid'] :null ;

if(!empty($message) && !empty($from)){
    $sql = "INSERT INTO chat (message,from_id,to_id,status) VALUE ('$message','$from','$to',1 ) ;";
    $result['send_status'] = mysqli_query($con,$sql);
}

// print Message
$start = isset($_GET['start']) ? intval($_GET['start']) : 0 ;
$chat_sql = "SELECT * FROM (SELECT * FROM chat WHERE chat_id > $start AND (from_id = '$userid' AND to_id = '3') OR (from_id = '3' AND to_id = '$userid') ORDER BY data_time DESC LIMIT 15 )sub ORDER BY data_time ASC ";
$items = mysqli_query($con, $chat_sql);

while ($row = mysqli_fetch_assoc($items)){
    $result['items'][] = $row ;
}

mysqli_close($con);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

echo json_encode($result);