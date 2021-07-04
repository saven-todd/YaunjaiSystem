<?php
session_start(); 
include_once "db.php";
include_once "Backend/function.inc.php";
// include_once "include/headerauth.php" ;
if(isset($_SESSION['ID'])){    
    $ID = $_SESSION['ID'] ? : $_SESSION['fbid'];
    $name = $_SESSION['name'];
    $level = $_SESSION['status'];
    $fbid = $_SESSION['fbid'];  
}

if ( $_SESSION['ID'] == '' && $_SESSION['fbid'] == '' ){
	unset($_SESSION['formid']);

	echo "<script>";
		echo "alert(\" กรุณาลงชื่อเช้าใช้เพื่อสั่งซื้อสินค้า หรือ สมัครสมาชิกก่อน. \");"; 
		echo "window.location = 'login.php'; ";
	echo "</script>"; 
} 

$formid = isset($_SESSION['formid']) ? $_SESSION['formid'] : "";
if ($formid != $_POST['formid']) {
	echo "E00001!! SESSION ERROR RETRY AGAINT.";
	header('location:shopping.php?a=orderfail');
} else {
	unset($_SESSION['formid']);
	if ($_POST) {
//กำหนดตัวแปร เพื่อเก็บค่า $_POST โดยวนลูปให้ครบทุกค่าจากฟอร์ม และตั้งชื่อตัวแปรตามชื่อในฟอร์ม
     foreach ($_POST  as  $formkey => $formval) {
           ${$formkey} = $formval;
         }
//=========================Send Email==================================
    // $MailTo = 'oil_2356@hotmail.com';
    // $MailFrom = 'YJ_Webmaster@000webhostapp.com';
    // $MailSubject = "รับคำสั่งซื้อจากร้าน ญวนใจขนมปัง แล้ว ";
    // $MailMessage = "คุณได้สั่งซื้อสินค้าเรียบร้อยแล้ว <br> กรุณาชำระเงินและแจ้งชำระเงิน";

    // $Headers = "MIME-Version: 1.0\r\n" ;
    // $Headers .= "Content-type: text/html; charset=utf-8\r\n" ;
    // // ส่งข้อความเป็นภาษาไทย ใช้ "windows-874"
    // $Headers .= "From: $MailFrom <$MailFrom>\r\n" ;
    // $Headers .= "Reply-to: $MailFrom <$MailFrom>\r\n" ;
    // $Headers .= "X-Priority: 3\r\n" ;
    // $Headers .= "X-Mailer: PHP mailer\r\n" ;

    // if(mail($MailTo, $MailSubject , $MailMessage, $Headers, $MailFrom))
    // {
    // echo "Send Mail True 555+" ; //ส่งเรียบร้อย
    // }else{
    // echo "Send Mail False" ; //ไม่สามารถส่งเมล์ได้
    // }

//=====================End send Email===============================
   //Insert order
	$now = date("Y-m-d H:i:s");
	$_addr = mysqli_real_escape_string($con,$order_address);
	$_order_fullname = mysqli_real_escape_string($con,$order_fullname);
	$PointsNumber = $old_remainingPoints ? : $old_remainingPoints = '0' ;
    $meSql = "INSERT INTO orders (MemberID,OrderDate,MapLocation,PayStatus_W,notification_FK,notification_type,read_status,accept_FK,lat,lng,cus_name,phone_order,PointsNumber)
	VALUES ('{$ID}','{$now}','{$_addr}',0,1,1,1,2,'{$lat}','{$lng}','{$_order_fullname}','{$order_phone}',$PointsNumber) ;";
	$meQeury = mysqli_query($con,$meSql);
	$num = 0;
	$e = 0;
		if ($meQeury) {
			$order_id = mysqli_insert_id($con);	
			sendMailOrder($order_email,$_order_fullname,$order_id,$_addr,$order_phone,$totalPrice,$now);			

			for ($i = 0; $i < count($qty); $i++) {
				$order_detail_quantity =$qty[$i];
				$order_detail_price = $p_price[$i];
				$product_id = $p_id[$i];

   //Insert order detail
				$lineSql = "INSERT INTO orderdetails ";
				$lineSql .= "(OrderID,Number,Price,ProductID,total)";
				$lineSql .= " VALUES (";
				// $lineSql .= "'',"; //ID Run Auto ใน DB
				$lineSql .= "{$order_id},";				
				$lineSql .= "{$order_detail_quantity},";
				$lineSql .= "{$order_detail_price},";
				$lineSql .= "{$product_id},";		
				$total = $order_detail_quantity * $order_detail_price;		
				$lineSql .= "{$totalPrice}";
				$lineSql .= ") ;";
				$_lineSql = mysqli_query($con,mysqli_real_escape_string($con,$lineSql));
				if($_lineSql === true){
					$num++;
				} else {
					$e++;
					echo "Error full $lineSql";
				}
			}

			$sql_noti = "INSERT INTO noti_bar (order_id,type,n) VALUE ($order_id,1,1);";
			mysqli_query($con,$sql_noti);

			if($totalPrice >= 100){
				$remainingPoints = floor($totalPrice/100);
				$fix_remainingPoints = floor($remainingPoints) + $PointsNumber ;
				$total_remain = floatval($my_remainingPoints) + floatval($fix_remainingPoints);
				$sql_points = "UPDATE user SET RemainingPoints = $total_remain WHERE ID = $ID ;";
				mysqli_query($con,$sql_points);
			}

			if(isset($_POST['discount'])){
				//ส่วนลด
				// echo "true your discount is ".($old_remainingPoints*10);
				$dis_sql = "SELECT Price,Number FROM orderdetails WHERE OrderID = $order_id ORDER BY OrderID DESC LIMIT 1;";
				$dis_result = mysqli_fetch_array(mysqli_query($con,$dis_sql));
				mysqli_query($con,"UPDATE orderdetails SET total = $totalPrice WHERE OrderID = $order_id ;");
				mysqli_query($con,"UPDATE user SET RemainingPoints = $new_remainingPoints WHERE ID = $ID ;");
			}

			mysqli_close($con);
			unset($_SESSION['cart']);
			unset($_SESSION['qty']);
			
			echo "<script type='text/javascript'>";
			echo "alert('สั่งซื้อสินค้าสำเร็จ');";
			echo "window.location = 'payment_notification.php?OrderID=".$order_id."&a=succsess';";     
			echo "</script>";
		} else {
			echo "Error full : $e row <br> $meSql";
			mysqli_close($con);
			header('location:shopping.php?a=orderfail');
		}
	}
}
?>