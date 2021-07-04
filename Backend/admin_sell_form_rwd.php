<?php 

include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
$ID = $_GET['ID'];
$sql = "SELECT * FROM user WHERE ID=$ID";
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
$row = mysqli_fetch_array($result);
extract($row);

?>

<script>
$(document).ready(function() {
    $('#submit').click(function() {
        var pass1 = document.getElementById('a_pass1').value;
        var pass2 = document.getElementById('a_pass2').value;

        if (pass1 !== pass2) {
          alert('รหัสไม่ตรงกัน');
        } else {
        $.ajax({
            method: 'POST',
            url: 'admin_sell_form_rwd_db.php',
            data: {
              a_id: <?=$ID?>,
              a_pass1: pass1,
              a_pass2: pass2
            },
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });
      }
    });
});
</script>

<h4> Form Reset Password </h4>
<div class="form-group">
    <div class="col-sm-2 control-label">
        Username :
    </div>
    <div class="col-sm-10">
        <input type="text" name="a_user" required class="form-control" autocomplete="off"
            value="<?php echo $row['username'];?>" disabled>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-3 control-label">
        New Password :
    </div>
    <div class="col-sm-10">
        <input type="password" id="a_pass1" name="a_pass1" required class="form-control">
    </div>
</div>
<div class="form-group">
    <div class="col-sm-3 control-label">
        Confirm Password :
    </div>
    <div class="col-sm-10">
        <input type="password" id="a_pass2" name="a_pass2" required class="form-control">
    </div>
</div>
<div class="form-group">
    <div class="col-sm-3">
    </div>
    <div class="col-sm-4">
        <input type="hidden" name="a_id" value="<?php echo $row['ID'];?>">
        <button type="submit" id="submit" class="btn btn-success">บันทึก</button>
    </div>
</div>