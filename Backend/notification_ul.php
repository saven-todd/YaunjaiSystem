<?php
require '../db.php';
include_once 'function.inc.php';

$sql = "SELECT * FROM v_noti_bar ORDER BY date DESC LIMIT 7;";
$result = mysqli_query($con,$sql);
$row_am = mysqli_fetch_assoc($result);

do {    
    if($row_am['type'] == 2){
        echo "
        <li id='notification_ul-$row_am[order_id]' onclick='orderReceipt($row_am[order_id]);' class='item-list-data starbucks ".SwitchUlColor($row_am['read_status'])."'>
            <div class=notify_icon>
                <img src='../IMG/Screenshot 2021-02-26 010218.png' class=icon alt=''>
            </div>
            <div class=notify_data>
                <div class=title>
                ฿ แจ้งการชำระเงิน
                </div>
                <div class=sub_title>
                    เลขที่คำสั่งซื้อ : $row_am[order_id]
                </div>
            </div>
            <div class=notify_status style='text-align: -webkit-right; width: 100px;'>
                <p style='width: max-content;'>".Switchaccept_FK($row_am['accept_FK'])."</p>
            </div>
        </li>";    
    }else if ($row_am['type'] == 1){
        echo "
        <li id='notification_ul-$row_am[order_id]' onclick='orderReceipt($row_am[order_id]);' class='item-list-data starbucks ".SwitchUlColor($row_am['read_status'])."'>
            <div class=notify_icon>        
                <img src='../IMG/logo.png' class=icon alt=''>
            </div>
            <div class=notify_data>
                <div class=title>
                ".Switchnotification_type($row_am['notification_type']).
                "</div>
                <div class=sub_title>
                    เลขที่คำสั่งซื้อ : $row_am[order_id]
                </div>
            </div>
            <div class=notify_status style='text-align: -webkit-right; width: 100px;'>
                <p style='width: max-content;'>".Switchaccept_FK($row_am['accept_FK'])."</p>
            </div>
        </li>";
    }
} while ($row_am =  mysqli_fetch_assoc($result));