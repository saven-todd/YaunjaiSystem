<script>
$(document).ready(function() {
    $('#submit').click(function() {
        var name = document.getElementById('pro_name').value;
        var pro_detail = document.getElementById('pro_detail').value;
        var pro_discount = document.getElementById('pro_discount').value;
        var pro_start = document.getElementById('pro_start').value;
        var pro_end = document.getElementById('pro_end').value;

        $.ajax({
            method: 'POST',
            url: 'promotion_form_add_db.php',
            data: {
                pro_name: name,
                pro_detail: pro_detail,
                pro_discount: pro_discount,
                pro_start: pro_start,
                pro_end: pro_end
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
    <div class="col-sm-10">
        <label for="" class="obj-text col-sm-4">ชื่อโปรโมชั่น :</label>
        <input type="text" name="pro_name" id="pro_name" class="form-control col-sm-8" required
            placeholder="ชื่อโปรโมชั่น" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10">
        <label for="" class="obj-text col-sm-4">รายละเอียดโปรโมชั่น :</label>
        <textarea name="pro_detail" id="pro_detail" class="form-control col-sm-8" rows="5" cols="60"></textarea>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10">
        <label for="" class="obj-text col-sm-4">ส่วนลด :</label>
        <input type="text" name="pro_discount" id="pro_discount" class="form-control col-sm-8" required
            placeholder="ส่วนลด" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10">
        <label for="" class="obj-text col-sm-4">วันที่เริ่มต้น :</label>
        <input type="date" name="pro_start" id="pro_start" class="form-control col-sm-8" required
            placeholder="วันที่เริ่มต้น" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10">
        <label for="" class="obj-text col-sm-4">วันที่สิ้นสุด :</label>
        <input type="date" name="pro_end" id="pro_end" class="form-control col-sm-8" required
            placeholder="วันที่สิ้นสุด" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <button type="submit" class="btn btn-success" id="submit" name="btnadd"> บันทึก </button>
    </div>
</div>