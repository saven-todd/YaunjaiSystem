<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "include/headerauth.php" 
    
    ?>
    
  
</head>
<body>
<br>


<?php 
include('db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี

?>
<br>

<div class="row">
    <div class="col-md-3">
    </div>
<div class="col-md-6">
<div align="center"><h1>โปรโมชั่น&ประกาศ </h1></div>
<br>
<br>
<?php
//2. query ข้อมูลจากตาราง 
$query = "SELECT * FROM tbl_promotion ORDER BY Pro_ID DESC" or die("Error:" . mysqli_error($con));
//3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result = mysqli_query($con, $query);
//4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:

echo  ' <table class="table table-hover">';
  //หัวข้อตาราง
    echo "<tr>
      <td width=15%>ชื่อโปรโมชั่น</td>
      <td width=50%>รายละเอียด</td>
      <td width=5%>คะแนน</td>
      <td width=12%>วันที่เริ่มต้น</td>
      <td width=12%>วันที่สิ้นสุด</td>
    </tr>";
  while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
    echo "<td>" .$row["Pro_Name"] .  "</td> ";
    echo "<td>" .$row["Pro_Des"] .  "</td> ";
    echo "<td>" .$row["Discount"] .  "</td> ";
    echo "<td>" .date('d/m/Y ',strtotime($row['StartDate'])). "</td>";
    echo "<td>" .date('d/m/Y ',strtotime($row['EndDate'])). "</td>";
    //แก้ไขข้อมูล
    
  echo "</tr>";
  }
echo "</table>";
//5. close connection
mysqli_close($con);
?>
   
    </div>
</div>
</div>

</div>
<div class="col-md-3">
    </div>



</body>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php include "include/footer.php" ?>
</html>

