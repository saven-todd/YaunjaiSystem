<?php
//1. เชื่อมต่อ database:
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
$p_id = $_GET["ID"];
//2. query ข้อมูลจากตาราง:
$sql = "SELECT * FROM tbl_promotion WHere Pro_ID = $p_id ORDER BY Pro_ID asc";
$result2 = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
$row = mysqli_fetch_array($result2);
extract($row);

?>
<script>
$(document).ready(function() {
    $('#submit').click(function() {
        var id = document.getElementById('id').value;
        var name = document.getElementById('pro_name').value;
        var pro_des = document.getElementById('pro_des').value;
        var discount = document.getElementById('discount').value;
        var pro_start = document.getElementById('pro_start').value;
        var pro_end = document.getElementById('pro_end').value;

        $.ajax({
            method: 'POST',
            url: 'promotion_form_edit_db.php',
            data: {
                id: id,
                name: name,
                pro_des: pro_des,
                discount: discount,
                pro_start: pro_start,
                pro_end: pro_end,
            },
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });
    });
});
</script>
<div class="form-group">
    <div class="col-sm-12">
        <label for="" class="obj-text col-sm-4">ชื่อโปรโมชั่น :</label>
        <input type="text" id="pro_name" name="pro_name" class="form-control col-sm-8" required
            placeholder="ชื่อโปรโมชั่น" value="<?php echo $Pro_Name; ?>">
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <label for="" class="obj-text col-sm-4">รายละเอียดโปรโมชั่น :</label>
        <textarea id="pro_des" name="Pro_Des" rows="5" cols="60" class="form-control col-sm-8"><?php echo $Pro_Des; ?>
             </textarea>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-12">
        <label for="" class="obj-text col-sm-4">ส่วนลด :</label>
        <input type="text" id="discount" name="Discount" class="form-control col-sm-8" required placeholder="ส่วนลด"
            value="<?php echo $Discount; ?>">
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <label for="" class="obj-text col-sm-4">วันที่เริ่มต้น :</label>
        <input type="date" id="pro_start" name="pro_start" class="form-control col-sm-8" required
            placeholder="วันที่เริ่มต้น" value="<?php echo $StartDate; ?>" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <label for="" class="obj-text col-sm-4">วันที่สิ้นสุด :</label>
        <input type="date" id="pro_end" name="pro_end" class="form-control col-sm-8" required
            placeholder="วันที่สิ้นสุด" value="<?php echo $EndDate; ?>" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <input type="hidden" name="id" id="id" value="<?php echo $Pro_ID; ?>" />
        <button type="submit" class="btn btn-success" id="submit" name="submit"> บันทึก </button>
    </div>
</div>