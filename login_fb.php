<?php
session_start();
if(isset($_POST['name'])){
    $_SESSION['ID'] = $_POST['id']; 
    $_SESSION['name'] = $_POST['name']; 
    $_SESSION['fbid'] = $_POST['fbid']; 
    $_SESSION['status'] = $_POST['status']; 
    // $_SESSION['remainPoints'] = 0; 
    
    $sql="SELECT * FROM user WHERE fb_id = $_POST[id] ;";
    $result = mysqli_query($con,$sql);				
    if(mysqli_num_rows($result)==1){
      $row = mysqli_fetch_array($result);         
      $_SESSION["ID"] = $row['ID'];
      $_SESSION["name"] = $row["name"];
      $_SESSION["pic"] = $row["Picture"];
      $_SESSION["status"] = $row["status"];
      $_SESSION['fbid'] = $row['fb_id']; 
      // $_SESSION['remainPoints'] = $row['RemainingPoints']; 
    }

}else{
  echo "What the hell are you doing?";
}
?>