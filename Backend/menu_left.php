<div class="list-group">

    <!-- <a href="edite_admin.php?act" class="list-group-item list-group-item-action">จัดการผู้ดูแลระบบ</a>
	<a href="admin_sell_page.php?act" class="list-group-item list-group-item-action">จัดการพนักงานขาย</a>
	<a href="member.php?act" class="list-group-item list-group-item-action">จัดการสมาชิก</a>
	<a href="type.php?act" class="list-group-item list-group-item-action">จัดการประเภทสินค้า</a>
	<a href="product.php?act" class="list-group-item list-group-item-action ">จัดการสินค้า</a>
	<a href="promotion.php?act" class="list-group-item list-group-item-action ">จัดการโปรโมชั่น</a>
	<a href="../logout.php" class="list-group-item list-group-item-action " onclick="return confirm('คุณต้องการออกจากระบบหรือไม่ ?')">ออกจากระบบ</a> -->

    <a id="admin-btn" href="#" class="list-group-item list-group-item-action">จัดการผู้ดูแลระบบ</a>
    <a href="#" class="list-group-item list-group-item-action">จัดการพนักงานขาย</a>
    <a href="#" class="list-group-item list-group-item-action">จัดการสมาชิก</a>
    <a href="#" class="list-group-item list-group-item-action">จัดการประเภทสินค้า</a>
    <a href="#" class="list-group-item list-group-item-action">จัดการสินค้า</a>
    <a href="#" class="list-group-item list-group-item-action">จัดการโปรโมชั่น</a>
    <a href="#" class="list-group-item list-group-item-action"
        onclick="return confirm('คุณต้องการออกจากระบบหรือไม่ ?')">ออกจากระบบ</a>
</div>

<script>
$(document).ready(function() {
    $('#admin-btn').click(function() {
        $.ajax({
            url: 'admin_list.php',
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });
    });
});
</script>