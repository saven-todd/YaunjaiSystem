<?php
include('../db.php');

$a_username = $_POST['a_username'];
$a_password = $_POST['a_password'];
$a_name = $_POST['a_name'];
$a_lastname = $_POST['a_lastname'];
$a_tel = $_POST['a_tel'];
$a_email = $_POST['a_email'];
$a_status = "1";
$trn_date = date("Y-m-d H:i:s");

$check = "SELECT username FROM user WHERE username = '$a_username' ;";
  $result1 = mysqli_query($con, $check) or die(mysqli_error($con));
  $num = mysqli_num_rows($result1);

  if($num > 0)
  {
  echo "<script>";
  echo "alert(' ข้อมูลซ้ำ กรุณาเพิ่มใหม่อีกครั้ง !');";
  echo "window.history.back();";
  echo "</script>";
  }else{

$sql ="INSERT INTO user
    (name, lastname, tel, username, password, email, status,trn_date) 
    VALUES 
    ('$a_name', '$a_lastname', '$a_tel', '$a_username', '$a_password', '$a_email', '$a_status', '$trn_date' )";
    
    $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
    mysqli_close($con);
  }
    // if($result){
    //   echo "<script>";
    //   echo "alert('เพิ่มข้อมูลเสร็จเรียบร้อยแล้ว !');";
    //   echo "$.ajax({
    //       url: 'admin_list.php',
    //       cache: true,
    //       success: function(response) {
    //         $('#data').html(response);
    //       }
    //       });";
    //   echo "</script>";
    // } else {
      
    //   echo "<script>";
    //   echo "alert('ผิดพลาด !');";
    //   echo "window.location ='edite_admin.php?act'; ";
    //   echo "</script>";
    // }
?>