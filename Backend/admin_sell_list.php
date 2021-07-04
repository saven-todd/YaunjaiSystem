<?php  
session_start();
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
         
if(isset($ID)){$ID = $ID ;} else { header("location : ../login.php");}

?>

<script>
function getEdit(x) {
    $.ajax({
        method: 'GET',
        url: 'admin_sell_form_edite.php',
        data: {
            ID: x
        },
        cache: true,
        success: function(response) {
            $('#data').html(response);
        }
    });
}

function getPWD(x) {
    $.ajax({
        method: 'GET',
        url: 'admin_sell_form_rwd.php',
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
            url: 'admin_sell_form_del.php',
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
        url: 'admin_sell_form_add.php',
        cache: true,
        success: function(response) {
            $('#data').html(response);
        }
    });
});
</script>


<div class="add">
    <a class="btn-info btn-sm btn-add" id="btn-add">เพิ่มพนักงานใหม่</a>
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

    <tr id="<?=$row_am['ID'];?>">
        <td id="emp-id"><?php echo $row_am['ID']; ?></td>
        <td><?php echo $row_am['username']; ?></td>
        <td><a id="rwd-password-<?=$row_am['ID'];?>" onclick="getPWD(<?=$row_am['ID'];?>);" class="btn btn-info btn-sm">
                รหัสผ่าน </a></td>
        <td><?php echo $row_am['name']; ?></td>
        <td><?php echo $row_am['lastname']; ?></td>
        <td><a id="emp-edit-<?=$row_am['ID'];?>" onclick="getEdit(<?=$row_am['ID'];?>);" class="btn btn-warning btn-sm">
                แก้ไข </a></td>
        <td><a id="delete-emp-<?=$row_am['ID'];?>" onclick="getDelete(<?=$row_am['ID'];?>);"
                class='btn btn-danger btn-sm'>ลบ</a> </td>
    </tr>

    <?php } while ($row_am =  mysqli_fetch_assoc($result)); ?>

</table>