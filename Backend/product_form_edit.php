<?php
//1. เชื่อมต่อ database:
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
$p_id = $_GET["ID"];
//2. query ข้อมูลจากตาราง:
$sql = "SELECT * FROM v_product
WHERE p_id = '$p_id'
ORDER BY type_id asc";
$result2 = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
$row = mysqli_fetch_array($result2);
extract($row);

//2. query ข้อมูลจากตาราง 
$query = "SELECT * FROM tbl_type ORDER BY type_id asc" or die("Error:" . mysqli_error($con));
//3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result = mysqli_query($con, $query);
//4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
?>

<script>
$(document).ready(function() {
    $('#submit').click(function() {
        var id = document.getElementById('id').value;
        var name = document.getElementById('name').value;
        var type_id = document.getElementById('type_id').value;
        var p_detail = document.getElementById('p_detail').value;
        var p_price = document.getElementById('p_price').value;
        var p_img = $('#fileUploadForm')[0];
        var p_img2 = document.getElementById('p_img2').value;

        var p_id = document.getElementById('p_id').value;
        var p_img2_2 = document.getElementById('p_img2-2').value;
        var form_data = new FormData(p_img);

        function upload() {
            $.ajax({
                method: 'POST',
                url: 'product_form_edit_db_img.php?p_id='+id+'&p_img2='+p_img2,
                enctype: 'multipart/form-data',
                data: p_img = form_data ,
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
            url: 'product_form_edit_db.php',
            data: {
                id: id,
                name: name,
                type_id: type_id,
                p_detail: p_detail,
                p_price: p_price,
                p_img2: p_img2,
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
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">ชื่อสินค้า :</label>
        <input type="text" id="name" name="p_name" class="form-control col-sm-8" required placeholder="ชื่อสินค้า"
            value="<?php echo $p_name; ?>">
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">ประเภทสินค้า :</label>
        <select name="type_id" id="type_id" class="form-control col-sm-8" required>
            <option value="<?php echo $row["type_id"];?>">
                <?php echo $row["type_name"]; ?>
            </option>
            <option value="type_id" disabled>ประเภทสินค้า</option>
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
        <textarea name="p_detail" id="p_detail" class="form-control col-sm-8" rows="5" cols="60"><?php echo $p_detail; ?>
             </textarea>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-10">
        <label for="" class="obj-text col-sm-4">ราคา :</label>
        <input type="text" id="p_price" name="p_price" class="form-control col-sm-8" required placeholder="ราคา"
            value="<?php echo $p_price; ?>">
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10">
        <label for="" class="obj-text col-sm-4">ภาพสินค้า :</label>
        <div class="col-sm-10">
            <img src="p_img/<?php echo $row['p_img'];?>" width="100px">
        </div>
    </div>
</div>
<form method="POST" enctype="multipart/form-data" id="fileUploadForm">
    <div class="form-group">
        <div class="col-sm-10">
            <label for="" class="obj-text col-sm-4"> </label>
            <input type="hidden" id="p_id" value="<?php echo $p_id; ?>" />
            <input type="hidden" id="p_img2-2" value="<?php echo $p_img; ?>" />
            <input type="file" name="p_img" id="p_img" />
        </div>
    </div>
</form>
<div class="form-group">
    <div class="col-sm-12">
        <input type="hidden" id="id" name="p_id" value="<?php echo $p_id; ?>" />
        <input type="hidden" id="p_img2" name="p_img2" value="<?php echo $p_img; ?>" />
        <button type="submit" id="submit" class="btn btn-success" name="btnadd"> บันทึก </button>
    </div>
</div>