<?php

    include_once '../db.php';
    $sql = "DELETE FROM orders WHERE (accept_FK = 0 OR accept_FK = 5) ;";
    mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
    mysqli_close($con);
