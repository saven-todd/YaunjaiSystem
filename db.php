<?php


$con = new mysqli("localhost","root","","shopping_db") or die("Error: ".mysqli_error($con));
// $con = new mysqli("localhost","id16349131_shopping_db","imRw&xu6uxp\GAX9","id16349131_admin_weboil") or die("Error: ".mysqli_error($con));

mysqli_query($con, "SET NAMES 'utf8' ");
date_default_timezone_set("Asia/Bangkok");
/*$con = mysqli_connect("85.187.128.34","gettingc","!1qwertyuioP","gettingc_shopping_db")*/ 
?>