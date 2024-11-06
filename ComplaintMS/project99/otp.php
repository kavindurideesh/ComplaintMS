<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
        <link rel="stylesheet" href="css/otp1.css">

        <title>OTP Verification</title>
        <link rel="icon" href="images/favicon.png" sizes="120x120" type="image/png">

        <script>
            if(window.history.replaceState){
                window.history.replaceState(null,null,window.location.href);
            }

            document.getElementById('resendButton').addEventListener('click', function() {
                sendOtp();
            });
                
                
            function sendOtp() {
                window.location.href="sendotp.php";
            }
                
         
        </script>

    </head>
    <body>
        <center><h1 class = "bh">COMPLAINT MANAGEMENT SYSTEM</h1></center>
        <?php
            
            session_start();
            
            if(isset($_SESSION['user_id'])&& isset($_SESSION['role'])){
                if($_SESSION['role']=='admin'){
                    header("location:admin/dashboard.php");
                    exit;}
            
            else if($_SESSION['role']=="student"){
                header("location:student/home.php");
                exit;
            }
        }
        
            if(isset($_SESSION['user_id'])){
                displayform2();
        
            }
            else{
                displayform1();
            }
            include ("connection.php");
            if (isset($_POST['submit'])) { 
        
            if (isset($_POST['email'])) {
                $email = $_POST['email'];
        
                $queryforemail = "select * from users where email='$email'";
                $result = mysqli_query($con, $queryforemail);
                echo "hi".mysqli_num_rows($result);
                if (!$result) {
                    echo "Connection failed: " . mysqli_connect_error();
                }
                else{
                if (mysqli_num_rows($result) != 0) {
                    $_SESSION['email'] = $email;
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['user_id'] = $row['user_id'];
                    header("location:sendotp.php");
                    exit;
                } else {
                    echo "<script>showerr();</script>";
                }
            }
        }
            }
        
            if(isset($_SESSION['user_id'])&&isset($_SESSION['timestamp'])){
                $user=$_SESSION['user_id'];
           
                $time=$_SESSION['timestamp'];
               echo "Sss";
            
            if (isset($_POST['verify'])&&isset($_POST['otp'])) {
                $inputOTP = $_POST['otp'];
        
                $queryforotp="select * from authentication where user_id='$user' and timestamp='$time' ";
                $result=mysqli_query($con,$queryforotp);
                if (!$result) {
                    
                    echo "Query error: " . mysqli_error($con);}
                    
                if(mysqli_num_rows($result)!=0){
                    $row=mysqli_fetch_assoc($result);
                
                if ($inputOTP==$row['otp'] && $time==$row['timestamp']) {
                    
                    $query = "select * from users where user_id='$user'";
                    $userlist = mysqli_query($con, $query);
                    if(!$userlist){
                        echo mysqli_error($con);
                    }
                    echo "Ssss";
                    $retrieved=mysqli_fetch_assoc($userlist);
                    if ($retrieved) {
                       
                         header("location:newpass.php");
                         exit;
        
                        }
                    } 
                } 
                else {
                    $message='invalidotp';
                }
            }}
            
        
        
        
        function showerr(){
            echo "enter a valid email";
        }
        
     

        function displayform1(){
            ?>
            <div class="login">
                <form action="otp.php" method="post" class="login__form">
                    <div class="login__content">
                        <div class="login__box">
                            <i class="ri-mail-line login__icon"></i>

                            <div class="login__box-input">
                                <input type="text" name="email" required class="login__input" placeholder=" ">
                                <label for="email" class="login__label">Email</label>
                            </div>
                        </div>
                    </div>

                    <input type="submit" class="login__button" name="submit" value="Submit">

                </form>
            </div>

            <?php 
        }
        
        function displayform2(){
            ?>
            <div class="login">
                <form action="" method="post" class="login__form">
                    <div class="login__content">
                        <div class="login__box">
                            <i class="ri-mail-line login__icon"></i>

                            <div class="login__box-input">
                                <input type="text" name="otp" id="otp" required class="login__input" placeholder=" ">
                                <label for="otp" class="login__label">Otp</label>
                                <span><?php if(isset($message)&& $message='invalidotp'){echo"invaliotp";}?></span><br>
                            </div>
                        </div>
                    </div>

                    <input type="submit" class="login__button" name="verify" value="Verify">

                    <input type="submit" class="login__button" id="resendButton" name="resend" value="Resend">

                </form>
            </div>

        <?php 
        } 
        ?>

    </body>
</html>
