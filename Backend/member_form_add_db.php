<?php
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
  //สร้างตัวแปรเก็บค่าที่รับมาจากฟอร์ม
  $m_user = $_REQUEST["username"];
  $m_pass = $_REQUEST["password"];
  $m_name = $_REQUEST["name"];
  $m_lastname = $_REQUEST["lastname"];
  $m_email = $_REQUEST["email"];
  $m_tel = $_REQUEST["tel"];
  $m_address = $_REQUEST["addr"];
  $trn_date = date("Y-m-d H:i:s");
  $status = "2";

  $check = "SELECT ID FROM user WHERE username = '$m_user' AND status = '2' ";
  $result1 = mysqli_query($con, $check) or die(mysqli_error($con));
  $num = mysqli_num_rows($result1);

  if($num == 0)  {
    //เพิ่มเข้าไปในฐานข้อมูล
    $sql = "INSERT INTO user(name, lastname, tel, username, password, email, addr, status, trn_date)
         VALUES('$m_name', '$m_lastname', '$m_tel', '$m_user', '$m_pass', '$m_email', '$m_address', '$status', '$trn_date')";
  
    $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
    
    //ปิดการเชื่อมต่อ database
    mysqli_close($con);
    //จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
  } else {
  echo "<script>";
  echo "alert(' ข้อมูลซ้ำ กรุณาเพิ่มใหม่อีกครั้ง !');";
  echo "</script>";
  }
  
?>