<?php session_start();
include_once '../db.php';
include_once 'function.inc.php';

// $sql1 = "SELECT * FROM v_receipt GROUP BY OrderID ;";
// $sql2 = "SELECT DISTINCT* FROM v_receipt GROUP BY OrderID, detail_id ;";

$sql1 = "SELECT * FROM noti_ul ;";
$sql2 = "SELECT DISTINCT * FROM v_receipt ;";

$sql_stmt = $con->query($sql1);
$sql_stmt2 = $con->query($sql2);

$result = $sql_stmt->fetch_assoc();
$_result = $sql_stmt->fetch_assoc();
$meResult = $sql_stmt->fetch_assoc();

// print_r($_result);
// print_r($_result_a);
// echo $_result;

$str1 = '<?= number_format(';
$str2 = ',2)'

?>
<style>
.table-filter-container {
    text-align: right;
}
</style>

<body>
    <script>
    $(document).ready(function() {
        $.ajax({
            method: 'GET',
            dataType: 'JSON',
            url: 'order_Json_API.php',
            cache: true,
            success: function(response) {
                var order = response.order;
                var receipt = response.receipt;
                var table = document.getElementById('order-table');
                var data = '';
                var total = 0;

                for (i = 0; i < order.length; i++) {
                    for (o = 0, a = (o - 1); o < receipt.length; o++, a++) {
                        if (receipt[o].OrderID == order[i].OrderID) {
                            var name, detail
                            if (receipt[o].cus_name !== null) {
                                name = receipt[o].cus_name;
                            } else {
                                name = 'ไม่พบชื่อลูกค้า'
                            }
                            detail = receipt[o].p_name;
                        }
                    }
                    data = `<tr id='order-row-${order[i].OrderID}'>
                                <td>${order[i].OrderID}</td>
                                <td>${order[i].OrderDate}</td>
                                <td>${name}</td>
                                <td>${detail}</td>
                                <td>${number_format(order[i].total,2,'.',',')}</td>
                                <td id='status' class=''>${switchStatus(order[i].accept_FK)}</td>
                                <td>
                                <button type="button" id="btn-check" class="btn btn-info" onclick="CheckOrder(${order[i].OrderID})">ดูรายการ</button></td>
                            </tr>`;
                    total += parseInt(order[i].sum);
                    $(table).append(data);
                }
                $('.total').text('จำนวนเงินรวมทั้งหมด ' + number_format(total,2,'.',',') + ' บาท');
            },
            complete: function() {
                var table = $('#dataTable').DataTable({
                    dom: 'lr<"table-filter-container">tip',
                    order: [
                        [0, "desc"]
                    ],
                    initComplete: function(settings) {
                        var api = new $.fn.dataTable.Api(settings);
                        $('.table-filter-container', api.table().container()).append(
                            $('#table-filter').detach().show()
                        );

                        $('#table-filter select').on('change', function() {
                            table.search(this.value).draw();
                        });
                    }
                });

                // $('#dataTable').DataTable({

                //     "dom": 'lrtip',
                //     "order": [
                //         [0, "desc"]
                //     ]
                // });
                setInterval(function() {
                    $.ajax({
                        method: 'GET',
                        dataType: 'JSON',
                        url: 'order_Json_API.php',
                        cache: true,
                        success: function(response) {
                            var order = response.order;
                            var receipt = response.receipt;
                            var table = document.getElementById('order-table');
                            var data = '';

                            for (i = 0; i < order.length; i++) {
                                for (o = 0; o < receipt.length; o++) {
                                    if (receipt[o].OrderID == order[i]
                                        .OrderID) {
                                        var name, detail;
                                        name = receipt[o].name;
                                        detail = receipt[o].p_name;
                                    }
                                }
                                var row = $('#order-row-' + order[i].OrderID);

                                $(row[0]).find('#status').removeClass('blink');
                                if (row.length) {
                                    var status = $(row[0]).find('#status')
                                        .text();
                                    var new_status = switchStatus(order[i]
                                        .accept_FK);
                                    // console.log($(new_status).text());
                                    if (status !== $(new_status).text()) {
                                        $(row[0]).find('#status').html(
                                            new_status);
                                        $(row[0]).find('#status').addClass(
                                            'blink');
                                    }
                                }
                            }
                        }
                    });
                }, 5000);
            }
        });
    });

    function CheckOrder(id) {
        $.ajax({
            method: 'GET',
            url: 'order.php',
            data: {
                order_id: id
            },
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });

    }


    function OrderTableLive() {}
    </script>
    <div class="container">
        <h3 class="head">รายการสั่งซื้อ</h3>

        <p id="table-filter" style="display:none">
            ค้นหา :
            <select>
                <option value="">ทั้งหมด</option>
                <option>ยกเลิก</option>
                <option>ยังไม่ตรวจสอบ</option>
                <option>รอดำเนินการ</option>
                <option>สำเร็จ</option>
            </select>
        </p>

        <table class="table table-striped table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>เลขที่คำสั่งซื้อ</th>
                    <th>วันที่</th>
                    <th>ชื่อลูกค้า</th>
                    <th>รายละเอียด</th>
                    <th>ราคา</th>
                    <th>สถานะ</th>
                    <th> - </th>
                </tr>
            </thead>
            <tbody id="order-table">
            </tbody>

            <tbody>
                <tr>
                    <td colspan="8" style="text-align: right;">
                        <h5 class="total"></h5>
                    </td>
                </tr>
                <tr>
                    <td colspan="8" style="text-align: right;">
                        <a id="btn-back-home" type="button" class="btn btn-danger btn-lg">ย้อนกลับ</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!--End Top Product-->
    <script>
    $('#btn-back-home').click(function() {
        $.ajax({
            method: 'POST',
            url: 'admin_home.php',
            cache: true,
            success: function(response) {
                $('#home-btn').addClass("active");
                $(".list-group-item").not(this).removeClass("active");
                $('#data').html(response);
            }
        });
    });
    </script>
</body>