<?php
include('../db.php');

$type_name = $_POST['type_name'];

$sql ="INSERT INTO tbl_type
    
    (type_name) 

    VALUES 

    ('$type_name')";
    
    $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
    mysqli_close($con);
    
    if($result){
      echo "<script>";
      echo "alert('สำเร็จ');";
      echo "window.location ='type.php?act'; ";
      echo "</script>";
    } else {
      
      echo "<script>";
      echo "alert('ผิดพลาด!');";
      echo "window.location ='type.php?act'; ";
      echo "</script>";
    }
?>