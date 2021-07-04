<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี

//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
  $a_id = $_REQUEST["id"];
  $a_user = $_REQUEST["username"];
  $a_pass = $_REQUEST["password"];
  $a_name = $_REQUEST["name"];
  $a_lastname = $_REQUEST["lastname"];
  $a_tel = $_REQUEST["tel"];
  $a_email = $_REQUEST["email"];

//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
  
$id = $_POST["id"];

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
  echo "alert('แก้ไขอัพเดทสำเร็จ');";
  echo "$.ajax({
		url: 'admin_sell_list.php',
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