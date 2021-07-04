<script>
$(document).ready(function() {
    homeData();
});

function homeData() {
    $.ajax({
        method: 'POST',
        dataType: 'JSON',
        url: 'admin_home_API.php',
        cache: true,
        success: function(response) {
            $('#order').text(response.order);
            $('#queues').text(response.queues);
            $('#income').text(response.income);
            $('#orderCancel').text(response.cancel);
        },
        complete: function() {
            setTimeout(function() {
                homeData();
            }, 5000);
        }
    });
}
</script>

<div class="row">
    <div class="col-3 col-m-6 col-sm-6">
        <div class="counter bg-primary" id="order-mng">
            <p>
                <i class="fas fa-tasks"></i>
            </p>
            <h3 id="order"></h3>
            <p>รายการสั่งซื้อ / วันนี้</p>
        </div>
    </div>
    <div class="col-3 col-m-6 col-sm-6">
        <div class="counter bg-warning" id="queues-mgn">
            <p>
                <i class="fas fa-spinner"></i>
            </p>
            <h3 id="queues"></h3>
            <p>รายการที่ค้าง</p>
        </div>
    </div>
    <div class="col-3 col-m-6 col-sm-6">
        <div class="counter bg-success" id="sale-mgn">
            <p>
                <i class="fas fa-check-circle"></i>
            </p>
            <h3 id="income"></h3>
            <p>ยอดขาย</p>
        </div>
    </div>
    <div class="col-3 col-m-6 col-sm-6" id="cancel-mgn">
        <div class="counter bg-danger">
            <p>
                <i class="fas fa-bug"></i>
            </p>
            <h3 id="orderCancel"></h3>
            <p>งานที่ยกเลิก</p>
        </div>
    </div>
</div>

<script>
$.ajax({
    method: 'POST',
    url: 'order_list.php',
    cache: true,
    success: function(response) {
        $('#home-list-table').html(response);
    }
});

$('#order-mng').click(function() {
    $.ajax({
        method: 'POST',
        url: 'admin_order_manage.php',
        cache: true,
        success: function(response) {
            $('#data').html(response);
        }
    });
});

$('#queues-mgn').click(function() {
    $.ajax({
        method: 'POST',
        url: 'admin_order_queues.php',
        cache: true,
        success: function(response) {
            $('#data').html(response);
        }
    });
});

$('#sale-mgn').click(function() {
    $.ajax({
        method: 'POST',
        url: 'admin_order_sale.php',
        cache: true,
        success: function(response) {
            $('#data').html(response);
        }
    });
});

$('#cancel-mgn').click(function() {
    $.ajax({
        method: 'POST',
        url: 'admin_order_cancel.php',
        cache: true,
        success: function(response) {
            $('#data').html(response);
        }
    });
});
</script>
<div class="row" id>
    <div class="col-8 col-m-12 col-sm-12">
        <div class="card">
            <div id="home-list-table"></div>
        </div>
    </div>
</div>