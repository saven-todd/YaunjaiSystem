<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
  //Set ว/ด/ป เวลา ให้เป็นของประเทศไทย
    date_default_timezone_set('Asia/Bangkok');
	//สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลด
	$date1 = date("Ymd_His");
	//สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
	$numrand = (mt_rand());
	
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
	$p_id = $_POST["id"];
	$p_name = mysqli_escape_string($con, $_POST["name"]);
	$p_price = $_POST["p_price"];
	$type_id = $_POST["type_id"];
	$p_detail = mysqli_escape_string($con, $_POST["p_detail"]);
	$img2 = $_POST['p_img2'];
		$newname = $img2;	
	

//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
	
	$sql = "UPDATE tbl_product SET  
			p_name = '$p_name',
			type_id = $type_id, 
			p_price = $p_price,
			p_detail = '$p_detail',
			p_img = '$newname'
			WHERE p_id = $p_id ;";

mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));

// mysqli_close($con); //ปิดการเชื่อมต่อ database 

// echo $sql;

//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	// if($result){
	// echo "<script type='text/javascript'>";
	// echo "alert('อัพเดทรายการสินค้าสำเร็จ');";
	// echo "$.ajax({
	// 		url: 'product_list.php',
	// 		cache: true,
	// 		success: function(response) {
	// 			$('#data').html(response);
	// 		}
	// 	});";
	// echo "</script>";
	// }
	// else{
	// echo "<script type='text/javascript'>";
	// echo "alert('ผิดพลาด');";
	// echo "</script>";
// }
?>