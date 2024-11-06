<?php
  session_start();
    if(isset($_SESSION['user_id'])&& isset($_SESSION['role'])){
        if($_SESSION['role']=='admin'){
            header("location:admin/dashboard.php");
            exit;}
    
    else if($_SESSION['role']=='student') {
        header("location:student/home.php");
        exit;
    }
}
else{
    header("location:login.php");
    exit;
}?>
