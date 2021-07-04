<?php  session_start();
//1. เชื่อมต่อ database: 
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
  //Set ว/ด/ป เวลา ให้เป็นของประเทศไทย
    date_default_timezone_set('Asia/Bangkok');
	//สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลด
	$date1 = date("Ymd_His");
	//สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
	$numrand = (mt_rand());
	
	if(isset($_GET['username'])){
	$a_username = $_GET['username'];
	$check = "SELECT ID FROM user WHERE username = '$a_username' AND status = 1 ;";
	$result1 = mysqli_query($con, $check) or die(mysqli_error($con));
	$num = mysqli_num_rows($result1);

	$p_img = (isset($_FILES['p_img']['name']) ? $_FILES['p_img']['name'] : '');
	$upload = $_FILES['p_img']['name'];

	if($num == 1 && $upload !='')
	{			
		$data = mysqli_fetch_assoc($result1);
		//โฟลเดอร์ที่เก็บไฟล์
		$path="../IMG/profile/";
		//ตัวขื่อกับนามสกุลภาพออกจากกัน
		$type = strrchr($_FILES['p_img']['name'],".");
		//ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
		$newname =$numrand.$date1.$type;
	 
		$path_copy=$path.$newname;
		$path_link="p_img/".$newname;
		//คัดลอกไฟล์ไปยังโฟลเดอร์
		move_uploaded_file($_FILES['p_img']['tmp_name'],$path_copy);  
			
		$p_id = $data['ID'];
		$sql = "UPDATE user SET  
		Picture='$newname'
		WHERE ID='$p_id' ";

		$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));

		mysqli_close($con); //ปิดการเชื่อมต่อ database 
	}
}

if(isset($_GET['id'])){ //สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
	
	$id = $_GET["id"];

	$check = "SELECT ID FROM user WHERE ID = '$id' AND status = 1 ;";
	$result1 = mysqli_query($con, $check) or die(mysqli_error($con));
	$num = mysqli_num_rows($result1);
	$p_img = (isset($_FILES['p_img']['name']) ? $_FILES['p_img']['name'] : '');
	$img2 = $_GET['p_img2'];
	$upload = $_FILES['p_img']['name'];

	

	if($upload !='') {  
	//โฟลเดอร์ที่เก็บไฟล์
	$path="../IMG/profile/";
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

//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
	
	$sql = "UPDATE user SET  
			Picture='$newname'
			WHERE ID='$id' ";
}

$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));

mysqli_close($con); //ปิดการเชื่อมต่อ database 

//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม	
	if($result){
			$profile_pic = $newname;
			$_SESSION['pic'] = $newname;
		echo "<script type='text/javascript'>";
		echo "alert('เพิ่มข้อมูลเสร็จเรียบร้อยแล้ว');";
		echo "$.ajax({
				url: 'admin_list.php',
				cache: true,
				success: function(response) {
					$('.nav-priflie-pic').attr('src', '../IMG/profile/$newname');
				}
			});";
		echo "</script>";
		}
		else{
		echo "<script type='text/javascript'>";
		echo "alert('ผิดพลาด');";
		echo "$.ajax({
				url: 'member_list.php',
				cache: true,
				success: function(response) {
					$('#data').html(response);
				}
			});";
		echo "</script>";
	}                        
?>