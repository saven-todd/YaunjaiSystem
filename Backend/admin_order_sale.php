<?php session_start();
include_once '../db.php';
include_once 'function.inc.php';


$dataPoints = array(
	array("y" => 25, "label" => "Sunday"),
	array("y" => 15, "label" => "Monday"),
	array("y" => 25, "label" => "Tuesday"),
	array("y" => 5, "label" => "Wednesday"),
	array("y" => 10, "label" => "Thursday"),
	array("y" => 0, "label" => "Friday"),
	array("y" => 20, "label" => "Saturday")
);
 
?>
<style>
.table-filter-container {
    text-align: right;
}
</style>

<body>
    <script>
    function addZero(i) {
        if (i < 10 && i > -1) {
            i = "0" + i;
        }
        if (i == -1) {
            i = "00";
        }
        return i;
    }

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

                    const currentdate = new Date();
                    const date1 = currentdate.getFullYear() + "-" + addZero((currentdate
                        .getMonth() + 1)) + "-" + addZero(currentdate.getDate());
                    const date2 = currentdate.getFullYear() + "-" + addZero((currentdate
                        .getMonth() + 1)) + "-" + addZero(((currentdate.getDate() - 7)));
                    const h = addZero(currentdate.getHours());
                    const m = addZero(currentdate.getMinutes());
                    const s = addZero(currentdate.getSeconds());
                    const now = date1 + " " + h + ":" + m + ":" + s;
                    const min = date2 + " " + "00:00:00";

                    if (order[i].accept_FK && order[i].OrderDate > min) {
                        data = `<tr id='order-row-${order[i].OrderID}'>
                                <td>${order[i].OrderID}</td>
                                <td>${order[i].OrderDate}</td>
                                <td>${name}</td>
                                <td>${detail}</td>
                                <td>${number_format(order[i].sum,2,'.',',')}</td>
                                <td id='status' class=''>${switchStatus(order[i].accept_FK)}</td>
                                <td>
                                <button type="button" id="btn-check" class="btn btn-info" onclick="CheckOrder(${order[i].OrderID})">ดูรายการ</button></td>
                            </tr>`;
                        total += parseInt(order[i].sum);
                        $(table).append(data);
                    }
                }
                $('.total').text('จำนวนเงินรวมทั้งหมด ' + number_format(total, 2, '.', ',') +
                    ' บาท');
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

    $('#report').click(function() {
        $.ajax({
            method: 'POST',
            url: 'income_report.php',
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });
    });
    </script>
    <div class="container">

        <div class="row" style="
background: #77A7FF;
border-radius: 5px;
box-shadow: 0px 0px 5px;
color: aliceblue;
margin-bottom:2em;
">
            <div style="
align-self: center;
margin: 0 auto;
padding-top: 0 a;
">
                <h3 class="head" style="
align-self: center;
margin: 0 auto;
padding-top: 0 a;
">ยอดขาย</h3>
            </div>

            <a id="report" type="button" class="btn btn-primary btn-lg" style="float: right;">ดูรายงานประจำสัปดาห์</a>
        </div>

        <p id="table-filter" style="display:none">
            ค้นหา :
            <select>
                <option value="">สัปดาห์นี้</option>
                <option value="<?=date('Y-m-d')?>">วันนี้</option>
                <option><?=date('Y-m-d',strtotime("-1 days"))?></option>
                <option><?=date('Y-m-d',strtotime("-2 days"))?></option>
                <option><?=date('Y-m-d',strtotime("-3 days"))?></option>
                <option><?=date('Y-m-d',strtotime("-4 days"))?></option>
                <option><?=date('Y-m-d',strtotime("-5 days"))?></option>
                <option><?=date('Y-m-d',strtotime("-6 days"))?></option>
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