<?php
session_start();
$ID = $_SESSION['ID'];
//1. เชื่อมต่อ database:
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//2. query ข้อมูลจากตาราง 
error_reporting( error_reporting() & ~E_NOTICE );
//2. query ข้อมูลจากตาราง tb_admin:
$query = "SELECT * FROM tbl_product as p 
INNER JOIN tbl_type  as t ON p.type_id=t.type_id 
ORDER BY p.p_id DESC" or die("Error:" . mysqli_error($con));
//3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result = mysqli_query($con, $query);
//4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
$row_am = mysqli_fetch_assoc($result);

if(isset($ID)){$ID = $ID ;} else { header("location : ../login.php");}

?>

<script>
function getEdit(x) {
    $.ajax({
        method: 'GET',
        url: 'product_form_edit.php',
        data: {
            ID: x
        },
        cache: true,
        success: function(response) {
            $('#data').html(response);
        }
    });
}

function getDelete(x) {
    var conf = confirm('ยันยันการลบ ?');
    if (conf) {
        $.ajax({
            method: 'POST',
            url: 'product_del.php',
            data: {
                ID: x
            },
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });
    } else {
        return false;
    }
}

$(document).ready(function() {
    $('#dataTable').DataTable();
});

$('#btn-add').click(function(){
    $.ajax({
        method: 'GET',
        url: 'product_form_add.php',
        cache: true,
        success: function(response) {
            $('#data').html(response);
        }
    });
});

</script>

<div class="add">
    <a class="btn-info btn-sm btn-add" id="btn-add">เพิ่มสินค้าใหม่</a>
</div>
<table border="2" class="display table table-bordered" id="dataTable" align="center">
    <thead>
        <tr class="info">
            <td width=5%>รหัส</td>
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
        <td><?php echo $row_am['p_price']; ?></td>
        <td align=center><img src="p_img/<?php echo $row_am['p_img']; ?>" width='100'></td>
        <td>
            <a id="product-edit-<?=$row_am['p_id'];?>" onclick="getEdit(<?=$row_am['p_id'];?>);"
                class="btn btn-warning btn-sm">
                แก้ไข </a>
        </td>
        <td>
            <a id="delete-product-<?=$row_am['p_id'];?>" onclick="getDelete(<?=$row_am['p_id'];?>);"
                class='btn btn-danger btn-sm'>ลบ</a>
        </td>
    </tr>
    <?php } while ($row_am =  mysqli_fetch_assoc($result)); ?>
</table>