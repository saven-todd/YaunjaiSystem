<?php
session_start();
$ID = $_SESSION['ID'];
//1. เชื่อมต่อ database:
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//2. query ข้อมูลจากตาราง 
if(isset($ID)){$ID = $ID ;} else { header("location : ../login.php");}

error_reporting( error_reporting() & ~E_NOTICE );
//1. เชื่อมต่อ database:
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//2. query ข้อมูลจากตาราง tb_admin:
$query = "SELECT * FROM tbl_type ORDER BY type_id ASC" or die("Error:" . mysqli_error($con));
//3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result = mysqli_query($con, $query);
//4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
$row_am = mysqli_fetch_assoc($result);
?>

<script>
function getEdit(x) {
    $.ajax({
        method: 'GET',
        url: 'admin_type_form_edit.php',
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
            url: 'type_form_delete_db.php',
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

$('#btn-add').click(function() {
    $.ajax({
        method: 'GET',
        url: 'admin_type_form_add.php',
        cache: true,
        success: function(response) {
            $('#data').html(response);
        }
    });
});
</script>

<div class="add">
    <a class="btn-info btn-sm btn-add" id="btn-add">เพิ่มประเภทสินค้าใหม่</a>
</div>
<table border="2" class="display table table-bordered" id="dataTable" align="center">
    <thead>
        <tr class="info">
            <td style="width:10%">รหัส</td>
            <td style="width:55%">ชนิด</td>
            <td>แก้ไข</td>
            <td>ลบ</td>
        </tr>
    </thead>
    <?php do { ?>

    <tr>
        <td><?php echo $row_am['type_id']; ?></td>
        <td><?php echo $row_am['type_name']; ?></td>
        <td>
            <a id="type-edit-<?=$row_am['type_id'];?>" onclick="getEdit(<?=$row_am['type_id'];?>);"
                class="btn btn-warning btn-sm">
                แก้ไข </a>
        <td>
            <a id="delete-type-<?=$row_am['type_id'];?>" onclick="getDelete(<?=$row_am['type_id'];?>);"
                class='btn btn-danger btn-sm'>ลบ</a>

    </tr>

    <?php } while ($row_am =  mysqli_fetch_assoc($result)); ?>

</table>