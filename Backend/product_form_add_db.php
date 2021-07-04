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
	$p_name = $_POST['p_name'];
	$type_id = $_POST['type_id'];
	$p_price = $_POST['p_price'];
	$p_detail = $_POST['p_detail'];
	$Pro_ID = $_POST['Pro_ID'];
	
	// เพิ่มไฟล์เข้าไปในตาราง uploadfile
	$sql = "INSERT INTO tbl_product
	(p_name, type_id, p_detail, p_price,p_img, PromotionID) 
	VALUES 
	('$p_name','$type_id','$p_detail','$p_price','$newname','$Pro_ID')";

	$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
	mysqli_close($con);
	// javascript แสดงการ upload file


	if($result){
		echo "<script type='text/javascript'>";
		echo "alert('อัพเดทรายการสินค้าสำเร็จ');";
		echo "$.ajax({
				url: 'product_list.php',
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
				url: 'product_list.php',
				cache: true,
				success: function(response) {
					$('#data').html(response);
				}
			});";
		echo "</script>";
	}
?>