<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี

//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
  $m_id = $_REQUEST["id"];
  $m_user = $_REQUEST["username"];
  $m_pass = $_REQUEST["password"];
  $m_name = $_REQUEST["name"];
  $m_lastname = $_REQUEST["lastname"];
  $m_email = $_REQUEST["email"];
  $m_tel = $_REQUEST["tel"];
  $m_addr = $_REQUEST["addr"];
//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
  
  $sql = "UPDATE user SET  
      name='$m_name',
      lastname='$m_lastname',
      tel='$m_tel', 
      username='$m_user', 
      password='$m_pass', 
      email='$m_email',
      addr='$m_addr' 
      WHERE id='$m_id' ";


$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
mysqli_close($con); //ปิดการเชื่อมต่อ database 

//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
  
  if($result){
  echo "<script type='text/javascript'>";
  echo "alert('แก้ไขอัพเดทสำเร็จ');";
  echo "$.ajax({
          url: 'member_list.php',
          cache: true,
          success: function(response) {
            $('#data').html(response);
          }
        });";
  echo "</script>";
  }
  else{
  echo "<script type='text/javascript'>";
  echo "alert('ผิดพลาด');";
  echo "</script>";
}
?>