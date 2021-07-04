<?php
//1. เชื่อมต่อ database:
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//2. query ข้อมูลจากตาราง 
      include('h.php');
      $ID = $_SESSION['ID'];
       error_reporting( error_reporting() & ~E_NOTICE );
                //1. เชื่อมต่อ database:
                include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
                //2. query ข้อมูลจากตาราง tb_admin:
                $query = "SELECT * FROM tbl_product as p 
                INNER JOIN tbl_type  as t ON p.type_id=t.type_id 
                ORDER BY p.p_id DESC" or die("Error:" . mysqli_error());
                //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
                $result = mysqli_query($con, $query);
                //4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
                $row_am = mysqli_fetch_assoc($result);
                ?>

<script>    
$(document).ready(function() {
    $('#example1').DataTable( {
      "aaSorting" :[[0,'ASC']],
    //"lengthMenu":[[20,50, 100, -1], [20,50, 100,"All"]]
  });
} );
 
  </script>

  <table border="2" class="display table table-bordered" id="example1" align="center"  >
  <thead>
    <tr class="info">    
    <td width='5%'>รหัส</td>
      <td width=25%>ชนิด</td>
      <td width=30%>ชื่อ</td>
      <td width=30%>ราคา</td>
      <td width=25%>รูปภาพ</td>
      <td width=5%>แก้ไข</td>
      <td width=5%>ลบ</td>
  </tr>
</thead>
  <?php do { ?>
  
    <tr>
      <td><?php echo $row_am['p_id']; ?></td>
      <td><?php echo $row_am['type_name']; ?></td>
      <td><?php echo $row_am['p_name']; ?></td>
      <td ><?php echo $row_am['p_price']; ?></td>
      <td align=center><img src="p_img/<?php echo $row_am['p_img']; ?>" width='100'></td>
<td><a href="sell_product.php?act=edit&ID=<?php echo $row_am['p_id']; ?>" class="btn btn-warning btn-sm"> แก้ไข </a> </td>
       <td><a href="sell_product_del.php?ID=<?php echo $row_am['p_id']; ?>" class='btn btn-danger btn-sm'  onclick="return confirm('ยันยันการลบ')">ลบ</a> </td>

    </tr>

    <?php } while ($row_am =  mysqli_fetch_assoc($result)); ?>
  
    </table> 