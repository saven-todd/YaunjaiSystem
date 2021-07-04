<script>
$(document).ready(function() {
    ProfileImage();


    $('#submit').click(function() {
        // var id = document.getElementById('id').value;
        var type_name = document.getElementById('type_name').value;
        $.ajax({
            method: 'POST',
            url: 'admin_type_form_add_db.php',
            data:{ type_name : type_name},
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
            <div class="form-group">
                <div class="col-sm-10" align="left">
                    <label for="" class="obj-text col-sm-4">ประเภทสินค้า :</label>
                    <input name="type_name" type="text" required class="form-control col-sm-8" id="type_name"
                        placeholder="ประเภทสินค้า" minlength="2" />
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