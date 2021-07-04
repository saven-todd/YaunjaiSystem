<?php
      include('h.php');
  
      $ID = $_SESSION['ID'];
       error_reporting( error_reporting() & ~E_NOTICE );
                //1. เชื่อมต่อ database:
                include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
                //2. query ข้อมูลจากตาราง tb_admin:
                $query = "SELECT * FROM user where STATUS = 3 ORDER BY ID ASC" or die("Error:" . mysqli_error($con));
                //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
                $result = mysqli_query($con, $query);
                //4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
                $row_am = mysqli_fetch_assoc($result);
                ?>

<script>
$(document).ready(function() {
    $('#example1').DataTable({
        "aaSorting": [
            [0, 'ASC']
        ],
        //"lengthMenu":[[20,50, 100, -1], [20,50, 100,"All"]]
    });
});
</script>

<table border="2" class="display table table-bordered" id="example1" align="center">
    <thead>
        <tr class="info">
            <th width="5%">รหัส</th>
            <th>ชื่อผู้ใช้งาน</th>
            <th>รหัสผ่าน</th>
            <th>ชื่อ</th>
            <th>นามสกุล</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
    </thead>
    <?php do { ?>

    <tr>
        <td><?php echo $row_am['ID']; ?></td>
        <td><?php echo $row_am['username']; ?></td>
        <td><a href="sell_admin.php?act=rwd&ID=<?php echo $row_am['ID']; ?>" class="btn btn-info btn-sm"> รหัสผ่าน </a>
        </td>
        <td><?php echo $row_am['name']; ?></td>
        <td><?php echo $row_am['lastname']; ?></td>
        <td><a href="sell_admin.php?act=edit&ID=<?php echo $row_am['ID']; ?>" class="btn btn-warning btn-sm"> แก้ไข </a>
        </td>
        <td><a href="sell_form_del.php?ID=<?php echo $row_am['ID']; ?>" class='btn btn-danger btn-sm'
                onclick="return confirm('ยันยันการลบ')">ลบ</a> </td>
    </tr>

    <?php } while ($row_am =  mysqli_fetch_assoc($result)); ?>

</table>