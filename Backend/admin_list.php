<?php
session_start();
$ID = $_SESSION['ID'];

error_reporting( error_reporting() & ~E_NOTICE );
//1. เชื่อมต่อ database:
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//2. query ข้อมูลจากตาราง tb_admin:
$query = "SELECT * FROM user where STATUS = 1 ORDER BY ID ASC" or die("Error:" . mysqli_error($con));
//3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result = mysqli_query($con, $query);
//4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
$row_am = mysqli_fetch_assoc($result);

if(isset($ID)){$id = $ID;} else { header("location : ../login.php");}

?>


<script>
function rwdAdmin(x) {
    $.ajax({
        method: 'GET',
        url: 'admin_form_rwd.php',
        data: {
            ID: x
        },
        cache: true,
        success: function(response) {
            $('#data').html(response);
        }
    });
}

function EditAdmin(x) {
    $.ajax({
        method: 'GET',
        url: 'admin_form_edite.php',
        data: {
            ID: x
        },
        cache: true,
        success: function(response) {
            $('#data').html(response);
        }
    });
}

function DeleteAdmin(x) {
    var conf = confirm('ยันยันการลบ ?');
    if (conf) {
        $.ajax({
            method: 'GET',
            url: 'admin_form_del.php',
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

$('#btn-add').click(function(){
    $.ajax({
        method: 'GET',
        url: 'admin_form_add.php',
        cache: true,
        success: function(response) {
            $('#data').html(response);
        }
    });
});

$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script>
<div class="add">
    <a class="btn-info btn-sm btn-add" id="btn-add">เพิ่มผู้ดูแลระบบใหม่</a>
</div>

<table border="2" class="display table table-bordered" id="dataTable" align="center">
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
        <td><a class="btn btn-info btn-sm" onclick="rwdAdmin(<?=$row_am['ID']?>)"> รหัสผ่าน </a></td>
        <td><?php echo $row_am['name']; ?></td>
        <td><?php echo $row_am['lastname']; ?></td>
        <td><a class="btn btn-warning btn-sm" onclick="EditAdmin(<?=$row_am['ID']?>)"> แก้ไข </a></td>
        <td><a class='btn btn-danger btn-sm' onclick="DeleteAdmin(<?=$row_am['ID']?>)">ลบ</a> </td>
    </tr>

    <?php } while ($row_am =  mysqli_fetch_assoc($result)); ?>

</table>