<?php
//1. เชื่อมต่อ database:
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//2. query ข้อมูลจากตาราง 
$query = "
SELECT * FROM tbl_promotion ORDER BY Pro_ID DESC" or die("Error:" . mysqli_error($con));
//3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result = mysqli_query($con, $query);
//4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:

echo  ' <table class="table table-hover">';
  //หัวข้อตาราง
    echo "<tr>
      <td width='5%'>รหัส</td>
      <td width=25%>ชื่อโปรโมชั่น</td>
      <td width=30%>รายละเอียด</td>
      <td width=5%>ส่วนลด</td>
      <td width=20%>วันที่เริ่มต้น</td>
      <td width=20%>วันที่สิ้นสุด</td>
      <td width=5%>แก้ไข</td>
      <td width=5%>ลบ</td>
    </tr>";
  while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
    echo "<td>" .$row["Pro_ID"] .  "</td> ";
    echo "<td>" .$row["Pro_Name"] .  "</td> ";
    echo "<td class='pro-detail'>" .$row["Pro_Des"] .  "</td> ";
    echo "<td>" .$row["Discount"] .  "</td> ";
    echo "<td>" . date('d/m/Y ',strtotime($row['StartDate'])).  "</td> ";
    echo "<td>" . date('d/m/Y ',strtotime($row['EndDate'])).  "</td> ";
    //แก้ไขข้อมูล
    echo "<td><a href='sell_promotion.php?act=edit&ID=$row[0]' class='btn btn-warning btn-sm'>แก้ไข</a></td> ";
    
    //ลบข้อมูล
    echo "<td><a href='sell_promotion_del.php?ID=$row[0]' onclick=\"return confirm('คุณต้องการลบข้อมูลแถวนี้หรือไม่? !!!')\" class='btn btn-danger btn-sm'>ลบ</a></td> ";
  echo "</tr>";
  }
echo "</table>";
//5. close connection
mysqli_close($con);
?>