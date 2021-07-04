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
	if (isset($_GET["p_id"])){
	$p_id = $_GET["p_id"];
	$p_img = (isset($_FILES['p_img']['name']) ? $_FILES['p_img']['name'] : '');
	$img2 = $_GET['p_img2'];
	$upload = $_FILES['p_img']['name'];

	if($upload !='') {  
	//โฟลเดอร์ที่เก็บไฟล์
	$path="p_img/";
	//ตัวขื่อกับนามสกุลภาพออกจากกัน
	$type = strrchr($_FILES['p_img']['name'],".");
	//ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
	$newname =$numrand.$date1.$type;
 
	$path_copy=$path.$newname;
	$path_link="p_img/".$newname;
	//คัดลอกไฟล์ไปยังโฟลเดอร์
	move_uploaded_file($_FILES['p_img']['tmp_name'],$path_copy);  
		
	}else {
		$newname = $img2;	
	}
	
	} else {
			$query = "SELECT p_id FROM tbl_product ORDER BY p_id DESC LIMIT 1 ;" or die("Error:" . mysqli_error($con));
			$result = mysqli_query($con, $query);
			$data = mysqli_fetch_array($result);
			$p_id = $data["p_id"];
			$p_img = (isset($_FILES['p_img']['name']) ? $_FILES['p_img']['name'] : '');
			$upload = $_FILES['p_img']['name'];
		
			if($upload !='') {  
			//โฟลเดอร์ที่เก็บไฟล์
			$path="p_img/";
			//ตัวขื่อกับนามสกุลภาพออกจากกัน
			$type = strrchr($_FILES['p_img']['name'],".");
			//ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
			$newname =$numrand.$date1.$type;
		
			$path_copy=$path.$newname;
			$path_link="p_img/".$newname;
			//คัดลอกไฟล์ไปยังโฟลเดอร์
			move_uploaded_file($_FILES['p_img']['tmp_name'],$path_copy);
		}
	}
//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 	
	$sql = "UPDATE tbl_product SET  
			p_img='$newname'
			WHERE p_id='$p_id' ";

	$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));

	mysqli_close($con); //ปิดการเชื่อมต่อ database 
// echo $sql;

//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม	
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
		}
		else{
		echo "<script type='text/javascript'>";
		echo "alert('ผิดพลาด');";
		echo "</script>";
	}
?>