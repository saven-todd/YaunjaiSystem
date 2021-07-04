<?php
//1. เชื่อมต่อ database:
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
$type_id = $_REQUEST["ID"];
//2. query ข้อมูลจากตาราง:
$sql = "SELECT * FROM tbl_type WHERE type_id='$type_id' ";
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
$row = mysqli_fetch_array($result);
extract($row);
?>
<script>
$(document).ready(function() {
    $('#submit').click(function() {
        var type_id = document.getElementById('type_id').value;
        var type_name = document.getElementById('type_name').value;

        $.ajax({
            method: 'POST',
            url: 'admin_type_form_edit_db.php',
            data: {
                type_id: type_id,
                type_name: type_name
            },
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });
    });
});
</script>
<div class="container">
    <p> </p>
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" id="type_id" name="type_id" value="<?php echo $type_id; ?>" />
            <div class="form-group">
                <div class="col-sm-6" align="left">
                    <input name="type_name" id="type_name" type="text" required class="form-control" id="type_name"
                        value="<?=$type_name;?>" placeholder="ประเถทสินค้า" minlength="2" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6" align="right">
                    <button type="submit" class="btn btn-success btn-sm" id="submit"> บันทึก </button>
                </div>
            </div>
        </div>
    </div>
</div>