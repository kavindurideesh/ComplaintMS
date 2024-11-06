<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
        <link rel="stylesheet" href="css/newpass.css">

        <title>New Password</title>
        <link rel="icon" href="images/favicon.png" sizes="120x120" type="image/png">
    </head>

    <body>

        <div class="login">
            <form action="" method="post" class="login__form">
                <div class="login__content">
                    <div class="login__box">
                        <i class="ri-mail-line login__icon"></i>

                        <div class="login__box-input">
                            <input type="password" name="password" required class="login__input" placeholder=" ">
                            <label for="password" class="login__label">Enter new password</label>
                        </div>
                    </div>
                </div>

                <input type="submit" class="login__button" name="newpass" value="Submit">

            </form>
        </div>

    <?php
    include ("connection.php");
    session_start();
     if(isset($_SESSION['user_id'])&& isset($_SESSION['role'])){
        if($_SESSION['role']=='admin'){
            header("location:/admin/home.php");
            exit;}
    
    else {
        header("location:/student/home.php");
        exit;
    }
}
    if(isset($_POST['newpass'])){
       if(isset($_SESSION['user_id']) && isset($_POST['password'])){
           $user=$_SESSION['user_id'];
           $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
           $sql = "UPDATE users SET password ='$password' WHERE user_id = '$user'";
           $result=mysqli_query($con,$sql);
           if(!$result){
            echo mysqli_error($con);
           }
           session_unset();
           session_destroy();
     
           header('location:login.php');
           exit;
       }
    }
    ?>
</body>
</html>
