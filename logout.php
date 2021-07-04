<?php 
session_start();
    if(session_destroy()){
        
			echo "<script type='text/javascript'>";
            echo "alert('ออกจะระบบแล้ว');";
            echo "window.location = 'index.php' ;";
            echo "sessionStorage.clear()";
            echo "</script>";
    }
?>