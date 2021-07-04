<?php
session_start();
$ID = $_SESSION['ID'];
//1. เชื่อมต่อ database:
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
error_reporting( error_reporting() & ~E_NOTICE );
//2. query ข้อมูลจากตาราง 
$query = "SELECT * FROM tbl_promotion ORDER BY Pro_ID DESC" or die("Error:" . mysqli_error($con));
//3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result = mysqli_query($con, $query);
//4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
$row = mysqli_fetch_assoc($result);

if(isset($ID)){$ID = $ID ;} else { header("location : ../login.php");}

?>

<script>
function getEdit(x) {
    $.ajax({
        method: 'GET',
        url: 'promotion_form_edit.php',
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
            url: 'promotion_del.php',
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
        url: 'promotion_form_add.php',
        cache: true,
        success: function(response) {
            $('#data').html(response);
        }
    });
});
</script>

<div class="add">
    <a class="btn-info btn-sm btn-add" id="btn-add">เพิ่มโปรโมชั่นใหม่</a>
</div>
<table style="font-size:12px; border:2px solid;" class="display table table-bordered" id="dataTable" align="center">
    <thead style="font-size:12px;">
        <tr class="info">
            <th width='5%'>รหัส</th>
            <th width=25%>ชื่อโปรโมชั่น</th>
            <th width=30%>รายละเอียด</th>
            <th width=5%>ส่วนลด</th>
            <th width=20%>วันที่เริ่มต้น</th>
            <th width=20%>วันที่สิ้นสุด</th>
            <th width=5%>แก้ไข</th>
            <th width=5%>ลบ</th>
        </tr>
    </thead>
    <?php do { ?>
    <tr>
        <td><?=$row["Pro_ID"]?></td>
        <td><?=$row["Pro_Name"]?></td>
        <td class="pro-detail"><?=$row["Pro_Des"]?></td>
        <td><?=$row["Discount"]?></td>
        <td><?=date('d/m/Y ',strtotime($row['StartDate']))?></td>
        <td><?=date('d/m/Y ',strtotime($row['EndDate']))?></td>
        <td><a id="promo-edit-<?=$row[0]?>" onclick="getEdit(<?=$row['Pro_ID']?>);"
                class="btn btn-warning btn-sm">แก้ไข</a>
        </td>
        <td><a id="promo-delete-<?=$row[0]?>" onclick="getDelete(<?=$row['Pro_ID']?>);"
                class='btn btn-danger btn-sm'>ลบ</a>
        </td>
    </tr>
    <?php } while ($row =  mysqli_fetch_assoc($result)); ?>
</table>