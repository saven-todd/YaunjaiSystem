<meta charset="UTF-8">
<?php
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//Set ว/ด/ป เวลา ให้เป็นของประเทศไทย
date_default_timezone_set('Asia/Bangkok');
	//สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลด
	$date1 = date("Ymd_His");
	//สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
	$numrand = (mt_rand());
	//รับค่าไฟล์จากฟอร์ม
$pro_name = $_POST['pro_name'];
$pro_detail = $_POST['pro_detail'];
$pro_discount = $_POST['pro_discount'];
$pro_start = $_POST['pro_start'];
$pro_end = $_POST['pro_end'];
	// เพิ่มไฟล์เข้าไปในตาราง uploadfile
$sql = "INSERT INTO tbl_promotion
	(Pro_Name, Pro_Des, Discount, StartDate,EndDate) 
	VALUES 
	('$pro_name','$pro_detail','$pro_discount','$pro_start','$pro_end')";

	$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
	mysqli_close($con);
	// javascript แสดงการ upload file

	if($result){
		echo "<script type='text/javascript'>";
		echo "alert('อัพเดทรายการสินค้าสำเร็จ');";
		echo "$.ajax({
				url: 'promotion_list.php',
				cache: true,
				success: function(response) {
					$('#data').html(response);
				}
			});";
		echo "</script>";
	}else{
		echo "<script type='text/javascript'>";
		echo "alert('ผิดพลาด');";
		echo "$.ajax({
				url: 'promotion_list.php',
				cache: true,
				success: function(response) {
					$('#data').html(response);
				}
			});";
		echo "</script>";
	}
?>