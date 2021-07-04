<?php
//1. เชื่อมต่อ database: 
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//Set ว/ด/ป เวลา ให้เป็นของประเทศไทย
date_default_timezone_set('Asia/Bangkok');
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
$p_id = $_POST["id"];
$pro_name = $_POST["name"];
$Pro_Des = $_POST["pro_des"];
$Discount = $_POST["discount"];
$pro_start = $_POST["pro_start"];
$pro_end = $_POST["pro_end"];	

//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
	
$sql = "UPDATE tbl_promotion SET Pro_Name='$pro_name',Pro_Des='$Pro_Des', Discount='$Discount',StartDate='$pro_start',EndDate='$pro_end'
			WHERE Pro_ID='$p_id' ";

$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));

mysqli_close($con); //ปิดการเชื่อมต่อ database 

//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('แก้ไขอัพเดทสำเร็จ');";
	echo "$.ajax({
			url: 'promotion_list.php',
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