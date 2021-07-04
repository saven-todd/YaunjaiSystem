<?php
//1. เชื่อมต่อ database: 
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี

//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
  $a_id = $_REQUEST["id"];
  $a_user = $_REQUEST["a_username"];
  $a_pass = $_REQUEST["a_password"];
  $a_name = $_REQUEST["a_name"];
  $a_lastname = $_REQUEST["a_lastname"];
  $a_tel = $_REQUEST["a_tel"];
  $a_email = $_REQUEST["a_email"];

//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
  
  $sql = "UPDATE user SET  
      name='$a_name',
      lastname='$a_lastname' ,
      tel='$a_tel', 
      username='$a_user' , 
      password='$a_pass' , 
      email='$a_email' 
      WHERE ID='$a_id' ";

$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
mysqli_close($con); //ปิดการเชื่อมต่อ database 

//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
  
  if($result){
    echo "<script type='text/javascript'>";
    echo "alert('อัพเดท');";
    echo "window.location = 'sell_admin.php?act'; ";
    echo "</script>";
  }
  else{
    echo "<script type='text/javascript'>";
    echo "alert('ผิดพลาด');";
    echo "</script>";
  }