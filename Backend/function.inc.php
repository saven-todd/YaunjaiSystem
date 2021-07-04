<?php
header('Access-Control-Allow-Origin: *');
date_default_timezone_set("Asia/Bangkok");

function Switchnotification_type($x) {
    switch ($x) {
        case 1: $x = "รายการสั่งซื้อ"; break;
        default:
        $x = "ตรวจสอบ";
    }
    return $x;
}

function Switchaccept_FK($x) {
      switch ($x) {
          case 0: $x = "<span style='color: red;'>ยกเลิก</span>"; break;
          case 1: $x = "<span style='color: purple;'>ยังไม่ตรวจสอบ</span>"; break;
          case 2: $x = "<span style='color: blue;'>รอดำเนินการ</span>"; break;
          case 3: $x = "<span style='color: green;'>สำเร็จ</span>"; break;
          case 5: $x = "<span style='color: red;'>ยกเลิกโดยระบบอัตโนมัติ</span>"; break;
          default: $x = "ตรวจสอบ";
    }
    return $x;
}

function SwitchUlColor($x) {
    switch ($x) {
        case 0: $x = "read"; break;
        case 1: $x = "n_read"; break;
  }
  return $x;
}

USE PHPMailer\PHPMailer\PHPMailer;

function sendMailOrder($address,$name,$orderid,$order_addr,$order_phone,$totalPrice,$date){
    
    require_once "PHPMailer/PHPMailer.php";
    require_once "PHPMailer/SMTP.php";
    require_once "PHPMailer/Exception.php";

    $mail = new PHPMailer();    

    //SMTP Settings
    $mail->isSMTP();
    $mail->CharSet = "utf-8"; 
    $mail->Host = "smtp.gmail.com";
    // $mail->Host = "ssl://smtp.gmail.com"; 
    $mail->SMTPAuth = true;
    $mail->Username = 'alphonse.mustang.wilson@gmail.com';
    $mail->Password = 'vizer20202120';
    $mail->Port = 465; //587
    $mail->SMTPSecure = "ssl"; //tls
    //Email Settings
    $mail->isHTML(true);
    $mail->setFrom('admin-yuaunjaiBakery-no-reply@webmaster.com', 'Admin-YuaunJai');
    $mail->addAddress($address);
    $mail->Subject = "แจ้งการสั่งซื้อสินค้าจากร้าน \"ญวนใจขนมปัง\" ขอบคุณที่ใช้บริการ";
    $mail->Body = " ท่านได้ทำการสั่งซื้อสินค้าจากทางร้าน \"ญวนใจขนมปัง\"<br>
                    โปรดแจ้งการชำระเงินค่าสินค้าภายใน 24 ชม.
                    <a href=\"https://adminweboil.000webhostapp.com/payment_notification.php?OrderID=$orderid\"> คลิกเพื่อแจ้งชำระค่าบริการ </a>
                    <br>
                    <table 
                        style=\"
                            width: 50%;
                            border: 1px solid #000;
                            border-collapse: collapse;
                        \"
                    >
                        <thead 
                            style=\"
                                background-color: antiquewhite;
                            \"
                        >
                            <th style='width: 16%; border: 1px solid #000;'>หัวข้อ</th>
                            <th style='border: 1px solid #000;'>รายละเอียด</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style='border: 1px solid #000;'>เลขที่คำสั่งซื้อ</td>
                                <td style='border: 1px solid #000; padding-left:10px'>  $orderid</td>
                            </tr>
                            <tr>
                                <td style='border: 1px solid #000;'>ชื่อผู้ทำรายการ</td>
                                <td style='border: 1px solid #000; padding-left:10px'>  $name</td>
                            </tr>
                            <tr>
                                <td style='border: 1px solid #000;'>เวลาทำรายการ</td>
                                <td style='border: 1px solid #000; padding-left:10px'>  $date</td>
                            </tr>
                            <tr>
                                <td style='border: 1px solid #000;'>ที่อยู่ : </td>
                                <td style='border: 1px solid #000; padding-left:10px'>  $order_addr</td>
                            </tr>
                            <tr>
                                <td style='border: 1px solid #000;'>เบอร์โทรศัพท์ : </td>
                                <td style='border: 1px solid #000; padding-left:10px'>  $order_phone</td>
                            </tr>
                            <tr>
                                <td style='border: 1px solid #000;'>ค่าบริการทั้งสิ้น : </td>
                                <td style='border: 1px solid #000; padding-left:10px'>  $totalPrice บาท</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    ขอบคุณที่ใช้บริการค่ะ ♥
                    <br>
                    <a href='https://adminweboil.000webhostapp.com'>ญวนใจขนมปัง</a>
                    ";
    $mail->send();
}

function sendMailCancelOrder($orderid,$date,$name,$address,$phone,$orderTotal){
    require_once "PHPMailer/PHPMailer.php";
    require_once "PHPMailer/SMTP.php";
    require_once "PHPMailer/Exception.php";
    
    $mail = new PHPMailer();    

    //SMTP Settings
    $mail->isSMTP();
    $mail->CharSet = "utf-8"; 
    $mail->Host = "smtp.gmail.com";
    // $mail->Host = "ssl://smtp.gmail.com"; 
    $mail->SMTPAuth = true;
    $mail->Username = 'alphonse.mustang.wilson@gmail.com';
    $mail->Password = 'vizer20202120';
    $mail->Port = 465; //587
    $mail->SMTPSecure = "ssl"; //tls
    //Email Settings
    $mail->isHTML(true);
    $mail->setFrom('admin-yuaunjaiBakery-no-reply@webmaster.com', 'Admin-YuaunJai');
    $mail->addAddress($address);
    $mail->Subject = "แจ้งการขอยกเลิกคำสั่งซื้อสินค้าจากร้าน \"ญวนใจขนมปัง\" ขอบคุณที่ใช้บริการ";
    $mail->Body = " เนื่องจากการสั่งซื้อสินค้าของท่านได้ <span style=\"color:red\">เลยกำหนดระยะเวลาชำระค่าสินค้า</span>จากจากทางร้านแล้ว<br>
                    ทางร้าน \"ญวนใจขนมปัง\" จึงขอทำการยกเลิกคำสั่งซื้อสินค้าของท่าน <br>
                    หากท่านพบปัญหาในระหว่างการชำระเงินค่าสินค้าหรือมีปัญหาในการดำเนินงานขั้นตอนใดสามารถติดต่อทางร้านได้ <a href=\"https://adminweboil.000webhostapp.com/\">ที่นี่</a>
                    <a href=\"https://adminweboil.000webhostapp.com/payment_notification.php?OrderID=$orderid\"> คลิกเพื่อแจ้งชำระค่าบริการ </a>
                    <br>
                    <h1 style=\"color:red\"> แจ้งยกเลิกคำสั่งซื้อสินค้าและบริการ </h1>
                    <table 
                        style=\"
                            width: 50%;
                            border: 1px solid #000;
                            border-collapse: collapse;
                        \"
                    >
                        <thead 
                            style=\"
                                background-color: antiquewhite;
                            \"
                        >
                            <th style='width: 16%; border: 1px solid #000;'>หัวข้อ</th>
                            <th style='border: 1px solid #000;'>รายละเอียด</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style='border: 1px solid #000;'>เลขที่คำสั่งซื้อ</td>
                                <td style='border: 1px solid #000; padding-left:10px'>  $orderid</td>
                            </tr>
                            <tr>
                                <td style='border: 1px solid #000;'>ชื่อผู้ทำรายการ</td>
                                <td style='border: 1px solid #000; padding-left:10px'>  $name</td>
                            </tr>
                            <tr>
                                <td style='border: 1px solid #000;'>เวลาทำรายการ</td>
                                <td style='border: 1px solid #000; padding-left:10px'>  $date</td>
                            </tr>
                            <tr>
                                <td style='border: 1px solid #000;'>เบอร์โทรศัพท์ : </td>
                                <td style='border: 1px solid #000; padding-left:10px'>  $phone</td>
                            </tr>
                            <tr>
                                <td style='border: 1px solid #000;'>ค่าบริการทั้งสิ้น : </td>
                                <td style='border: 1px solid #000; padding-left:10px'>  $orderTotal บาท</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    ขอบคุณที่ใช้บริการค่ะ ♥
                    <br>
                    <a href='https://adminweboil.000webhostapp.com'>ญวนใจขนมปัง</a>
                    ";
    $mail->send();
}

function DateThai($strDate)
{
$strYear = date("Y",strtotime($strDate))+543;
$strMonth= date("n",strtotime($strDate));
$strDay= date("j",strtotime($strDate));
$strHour= date("H",strtotime($strDate));
$strMinute= date("i",strtotime($strDate));
$strSeconds= date("s",strtotime($strDate));
$strMonthCut = Array("","มกราคม" , "กุมภาพันธ์" , "มีนาคม" , "เมษายน" , "พฤษภาคม" , "มิถุนายน" , "กรกฏาคม" , "สิงหาคม" , "กันยายน" , "ตุลาคม" ,"พฤศจิกายน" , "ธันวาคม" );


$strMonthThai=$strMonthCut[$strMonth];
return "$strMonthThai $strYear "; //$strDay << วันที่ || $strHour:$strMinute << หน่วยเวลา
//return "$strMonthThai $strYear";
}
