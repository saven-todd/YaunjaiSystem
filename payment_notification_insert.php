<?php 
    session_start(); 
    require_once 'db.php';    
    date_default_timezone_set('Asia/Bangkok');
	$date1 = date("Ymd_His");
	$numrand = (mt_rand());
        
    $orderid = $_POST['orderid'];
    $pay_date = $_POST['pay_date'];
    $pay_time = $_POST['pay_time'];
    $payfrom = $_POST['payfrom'];
    $payto = $_POST['payto'];
    $last_payment_id = $_POST['last_payment_id'];

    $img = $_FILES['slip_img']['name'] ? $_FILES['slip_img']['name'] : '';
    $upload = $_FILES['slip_img']['name'] ? $_FILES['slip_img']['name'] : '';
    if($upload !='')
    {			
        //โฟลเดอร์ที่เก็บไฟล์
        $path="IMG/Slip/";
        //ตัวขื่อกับนามสกุลภาพออกจากกัน
        $type = strrchr($_FILES['slip_img']['name'],".");
        //ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
        $newname =$numrand.$date1.$type;
    
        $path_copy=$path.$newname;
        //คัดลอกไฟล์ไปยังโฟลเดอร์
        move_uploaded_file($_FILES['slip_img']['tmp_name'],$path_copy);
        
        
        $sql = "UPDATE payment SET  
        img = '$newname'
        WHERE order_id = $orderid ;";

$update_status ="UPDATE orders SET  
                PayStatus_W = 1
                WHERE OrderID = $orderid ;";

        mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
        mysqli_query($con, $update_status) or die ("Error in query: $sql " . mysqli_error($con));
    } else {


$update_status ="UPDATE orders SET  
                PayStatus_W = 2
                WHERE OrderID = $orderid ;";
                }

                $sql =" INSERT INTO payment (order_id,pay_date,pay_time,payfrom,payto,last_payment_id,img)
                VALUES ($orderid,'$pay_date','$pay_time',$payfrom,$payto,'$last_payment_id','$newname');";
                
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
        mysqli_query($con, $update_status);

        $sql_noti = "INSERT INTO noti_bar (order_id,type,n) VALUE ($orderid,2,1);";
        mysqli_query($con,$sql_noti);
        mysqli_close($con);
        
        if($result){
        echo "<script type='text/javascript'>";
        echo "alert('เพิ่มข้อมูลเสร็จเรียบร้อยแล้ว');";
        echo "window.location = 'past_list.php?a=act'; ";     
        echo "</script>";
        } else {
        echo "<script type='text/javascript'>";
        echo "alert('ผิดพลาดด !!');";        
        echo "window.location = 'past_list.php?a=arg'; ";  
        echo "</script>";
        }