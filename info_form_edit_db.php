<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="include/style.css">
    <?php include "include/headerauth.php" ;
  //  $ID = $_SESSION['ID'];
  include_once 'db.php';

  $m_id = $_REQUEST["id"];
  $m_user = $_REQUEST["m_username"];
  $m_pass = $_REQUEST["m_password"];
  $m_name = $_REQUEST["m_name"];
  $m_lastname = $_REQUEST["m_lastname"];
  $m_email = $_REQUEST["m_email"];
  $m_tel = $_REQUEST["m_tel"];
  $m_addr = $_REQUEST["m_addr"];
  $m_birthdate = $_REQUEST["m_birthdate"];
  $fbid = $_REQUEST["fbid"];

  if($m_id !== ''){    
    $check_stmt = "SELECT id FROM user WHERE ID = $m_id;";
  } else {
    $check_stmt = "SELECT id FROM user WHERE fb_id = '$fbid';";
  }
  $result = mysqli_query($con,$check_stmt);
  $data_result = mysqli_fetch_array($result);
  $num_row = mysqli_num_rows($result);
  $__ID = $data_result[0];
  if($num_row == 1){
    //ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
    $sql = "UPDATE user SET  
            name='$m_name',
            lastname='$m_lastname',
            tel='$m_tel', 
            birthdate='$m_birthdate', 
            username='$m_user', 
            password='$m_pass', 
            email='$m_email',
            addr='$m_addr'
            WHERE id = $__ID ;";    
    $update_result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
  } else {  
    //ถ้าไม่เพิ่มใหม่ 
    $sql = "INSERT INTO user (id,name,lastname,tel,birthdate,username,password,email,addr,fb_id)
            VALUE (
            '',
            '$m_name',
            '$m_lastname',
            '$m_tel', 
            '$m_birthdate', 
            '$m_user', 
            '$m_pass', 
            '$m_email',
            '$m_addr' ,
            '$fbid'
            );";
      $update_result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
  }
mysqli_close($con); //ปิดการเชื่อมต่อ database 

//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
  
  if($update_result === true){
  echo "<script type='text/javascript'>";
  echo "alert('อัพเดทสำเร็จ');";
  echo "window.location = 'info.php?act'; ";
  echo "</script>";
  }
  else{
  echo "<script type='text/javascript'>";
  echo "alert('ผิดพลาด');";
  echo "</script>";
}
?>