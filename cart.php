<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        include "include/headerauth.php" ;
    ?>
</head>

<body>
    <div class="container">
        <!-- Static navbar -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                </div>
                <h3>ตะกร้าสินค้าของฉัน</h3>
                <!-- Main component for a primary marketing message or call to action -->
                <?php
                    if ($action == 'removed'): echo "<div class=\"alert alert-warning\">ลบสินค้าเรียบร้อยแล้ว</div>" ; endif;
                    if ($meCount == 0){
                    echo "<div class=\"alert alert-warning\">ไม่มีสินค้าอยู่ในตะกร้า</div>" ;
                    } elseif ($meCount > 0) {                    
                    ?>
                <form action="updatecart.php" method="post" name="fromupdate">
                    <table border="2" class="table table-striped" id="example1" align="center">
                        <thead>
                            <tr class="info">
                                <td width='15%'>#</td>
                                <td width='5%'>รหัสสินค้า</td>
                                <td width=20%>ชื่อสินค้า</td>
                                <td width=30%>รายละเอียด</td>
                                <td width=20%>จำนวน</td>
                                <td width=30%>ราคาต่อหน่วย</td>
                                <td width=30%>จำนวนเงิน</td>
                                <td width=40%></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_price = 0;
                            $num = 0;
                            while ($meResult = mysqli_fetch_assoc($meQuery))
                            {
                            $key = array_search($meResult['p_id'], $_SESSION['cart']);
                            $total_price = $total_price + ($meResult['p_price'] * $_SESSION['qty'][$key]);
                            ?>
                            <tr>
                                <td width="100px"><img src="Backend/p_img/<?=$meResult['p_img'];?>" alt="..."
                                        class="img-thumbnail" width="100%">
                                <td><?php echo $meResult['p_id']; ?></td>
                                <td><?php echo $meResult['p_name']; ?></td>
                                <td><?php echo $meResult['p_detail']; ?></td>
                                <td>
                                    <input type="text" name="qty[<?php echo $num; ?>]"
                                        value="<?php echo $_SESSION['qty'][$key]; ?>" class="form-control"
                                        style="text-align: center;">
                                    <input type="hidden" name="arr_key_<?php echo $num; ?>" value="<?php echo $key; ?>">
                                </td>
                                <td><?php echo number_format($meResult['p_price'],2); ?></td>
                                <td><?php echo number_format(($meResult['p_price'] * $_SESSION['qty'][$key]),2); ?></td>
                                <td>
                                    <a class="btn btn-danger btn-lg"
                                        href="removecart.php?itemId=<?php echo $meResult['p_id']; ?>" role="button">
                                        <span class="glyphicon glyphicon-trash"></span>
                                        ลบ</a>
                                </td>
                            </tr>
                            <?php
                            $num++;
                            }
                            ?>
                            <tr>
                                <td colspan="8" style="text-align: right;">
                                    <h4>จำนวนเงินรวมทั้งหมด <?php echo number_format($total_price,2); ?> บาท</h4>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align: right;">
                                    <button type="submit" class="btn btn-info btn-lg">คำนวณราคาสินค้าใหม่</button>
                                    <a href="order.php" type="button" class="btn btn-primary btn-lg">สั่งซื้อสินค้า</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <?php
                } //End while
                mysqli_close($con);
                ?>
            </div>
        </div>
    </div> <!-- /container -->
    <!--End Top Product-->
    <?php include "include/footer.php" ;
?>
</body>

</html>