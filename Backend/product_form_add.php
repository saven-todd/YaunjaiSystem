<?php
//1. เชื่อมต่อ database:
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//2. query ข้อมูลจากตาราง tb_member:
$query = "SELECT * FROM tbl_type ORDER BY type_id asc" or die("Error:" . mysqli_error($con));
//3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result = mysqli_query($con, $query);

$query1 = "SELECT * FROM tbl_promotion ORDER BY Pro_ID asc" or die("Error:" . mysqli_error($con));
//3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result1 = mysqli_query($con, $query1);
//4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
?>

<script>
$(document).ready(function() {
    $('#submit').click(function() {
        var name = document.getElementById('name').value;
        var type_id = document.getElementById('type_id').value;
        var p_detail = document.getElementById('p_detail').value;
        var p_price = document.getElementById('p_price').value;
        var p_img = $('#fileUploadForm')[0];
        var Pro_ID = document.getElementById('pro_id').value;

        var form_data = new FormData(p_img);

        function upload() {
            $.ajax({
                method: 'POST',
                url: 'product_form_edit_db_img.php' ,
                enctype: 'multipart/form-data',
                data: p_img = form_data,
                processData: false,
                contentType: false,
                cache: true,
                success: function(response) {
                    // console.log("SUCCESS : ", response);
                    $('#data').html(response);
                }
            });
        }

        $.ajax({
            method: 'POST',
            url: 'product_form_add_db.php',
            data: {
                p_name: name,
                type_id: type_id,
                p_detail: p_detail,
                p_price: p_price,
                Pro_ID:Pro_ID
            },
            cache: true,
            success: function(response) {
                upload();
            }
        });
    });
});
</script>
<div class="form-group">
    <div class="col-sm-10">
        <label for="" class="obj-text col-sm-4">ชื่อสินค้า :</label>
        <input type="text" name="p_name" id="name" class="form-control col-sm-8" required placeholder="ชื่อสินค้า" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10">
        <label for="" class="obj-text col-sm-4">ประเภทสินค้า :</label>
        <select name="type_id"  id="type_id" class="form-control col-sm-8" required>
            <option value="type_id">ประเภทสินค้า</option>
            <?php foreach($result as $results){?>
            <option value="<?php echo $results["type_id"];?>">
                <?php echo $results["type_name"]; ?>
            </option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10">
        <label for="" class="obj-text col-sm-4">รายละเอียดสินค้า :</label>
        <textarea name="p_detail"  id="p_detail" class="form-control col-sm-8" rows="5" cols="60"></textarea>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10">
        <label for="" class="obj-text col-sm-4">ราคาสินค้า :</label>
        <input type="text" name="p_price" id="p_price" class="form-control col-sm-8" required placeholder="ราคาสินค้า" />
    </div>
</div>
<form method="POST" enctype="multipart/form-data" id="fileUploadForm">
    <div class="form-group">
        <div class="col-sm-10">
            <label for="" class="obj-text col-sm-4">รูปภาพ :</label>
            <input type="file" name="p_img" id="p_img" class="form-control col-sm-8" style="border: 0;" />
        </div>
    </div>
</form>
<div class="form-group">
    <div class="col-sm-10">
        <label for="" class="obj-text col-sm-4">ประเภทโปรโมชั่น :</label>
        <select name="Pro_ID"  id="pro_id" class="form-control col-sm-8" required>
            <option value="Pro_ID">ประเภทโปรโมชั่น</option>
            <?php foreach($result1 as $results2){?>
            <option value="<?php echo $results2["Pro_ID"];?>">
                <?php echo $results2["Pro_Name"]; ?>
            </option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <button type="submit" class="btn btn-success" id="submit" name="submit"> บันทึก </button>
    </div>
</div>