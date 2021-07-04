<?php
include('../db.php');

$type_name = $_POST['type_name'];

$sql ="INSERT INTO tbl_type (type_name) VALUES ('$type_name');";
    
    $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
    mysqli_close($con);
    
    if($result){
      echo "<script type='text/javascript'>";
      echo "alert('เพิ่มข้อมูลเสร็จเรียบร้อยแล้ว');";
      echo "$.ajax({
          url: 'type_list.php',
          cache: true,
          success: function(response) {
            $('#data').html(response);
          }
        });";
      echo "</script>";
    } else {
      echo "<script type='text/javascript'>";
      echo "alert('เพิ่มข้อมูลเสร็จเรียบร้อยแล้ว');";
      echo "$.ajax({
          url: 'type_list.php',
          cache: true,
          success: function(response) {
            $('#data').html(window.history.back(););
          }
        });";
      echo "</script>";
    }
?>