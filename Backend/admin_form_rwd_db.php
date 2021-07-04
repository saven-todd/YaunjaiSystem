<meta charset="utf-8">
<?php
include('../db.php');
	$a_id  = $_POST["a_id"];
	$a_pass1  = $_POST["a_pass1"];
	$a_pass2  = $_POST["a_pass2"];

	if($a_pass1 != $a_pass2){
		echo "<script type='text/javascript'>";
		echo "alert('รหัสผ่าน ไม่ตรงกัน กรุณาใส่่ใหม่อีกครั้ง ');";
		echo "window.location = 'edite_admin.php'; ";
		echo "</script>";
	}else{
	$sql = "UPDATE user SET 
	password ='$a_pass1'
	WHERE ID=$a_id
	 ";
	$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
	}
	mysqli_close($con);
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('แก้ไข รหัสผ่าน สำเร็จ');";
	echo "window.location = 'edite_admin.php?act'; ";
	echo "</script>";
	}else{
	echo "<script type='text/javascript'>";
	echo "window.location = 'edite_admin.php?act'; ";
	echo "</script>";
}
?>