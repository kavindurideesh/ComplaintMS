<?php ob_start(); ?>

<?php
    session_start();
    
    if(isset($_SESSION['error'])){
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['invalidmail'])) {
        echo $_SESSION['invalidmail'];
    }
    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['role'] == 'admin') {
            header("location:admin/dashboard.php");
            exit;
        } else {
            header("location:student/home.php");
            exit;
        }
    }

    include ("connection.php");
    if (isset($_POST['login'])) {
        if ((isset($_POST['username']) && isset($_POST['password']))) {
            $username = $_POST['username'];
            $password = $_POST['password'];
             echo"st";
            $query = "select * from users where user_name='$username'";
            $result = mysqli_query($con, $query);
            if (!$result) {
                die("connection failed" . mysqli_connect_error());
            }
            echo "hello";
           if(mysqli_num_rows($result)!=0){
            $row = mysqli_fetch_assoc($result);
            echo "hi";
           if (!password_verify($password, $row['password'])) {
               echo "cor";
            if($row['status']=='active'){
                echo "act";
                  
             $_SESSION['user_id'] = $row['user_id'];
               
              $_SESSION['role'] = $row['role'];
                   header("location:index.php");
                
                ob_end_flush();
            }
            else{
                echo "<script>deactivatedmsg();</script>";
            }
  


} 

                  
            else {
                echo "<script>showerr();</script>";
            }
        }
        else{
            echo "<script>showerr();</script>";
        }

    
    }
    
    }

    ?>
<!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
      <link rel="stylesheet" href="login.css">

      <title>CMS</title>
      <link rel="icon" href="Images/favicon.png" sizes="120x120" type="image/png">
      <style>
      #error-message{
     background-color:red;
      }
      
    </style>
    
   
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        function showerr() {
            document.getElementById("error-message").innerHTML = "Enter a valid username or password";
        }

        function deactivatedmsg() {
            document.getElementById("error-message").innerHTML = "Your account has been disabled";
        }
    </script>
</head>
<body>
    <center><h1 class="bh">COMPLAINT MANAGEMENT SYSTEM</h1></center>
    <div class="login">
        <form action="" class="login__form" method="post">
            <h1 class="login__title">Login</h1>
            <p> <?php
    if (isset($_SESSION['error'])) {
        echo "<div id='error-message'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']);
    }
    ?></p>
            <div id="error-message"></div> <!-- Place the error message container here, just after the title -->

            <div class="login__content">
                <div class="login__box">
                    <i class="ri-user-3-line login__icon"></i>
                    <div class="login__box-input">
                        <input type="username" name="username" required class="login__input" placeholder=" ">
                        <label for="" class="login__label">Username</label>
                    </div>
                </div>

                <div class="login__box">
                    <i class="ri-lock-2-line login__icon"></i>
                    <div class="login__box-input">
                        <input type="password" name="password" required class="login__input" id="login-pass" placeholder=" ">
                        <label for="" class="login__label">Password</label>
                    </div>
                </div>
            </div>

            <div class="login__check">
                <div class="login__check-group">
                    <input type="checkbox" class="login__check-input">
                    <label for="" class="login__check-label">Remember me</label>
                </div>
                <a href="otp.php" class="login__forgot">Forgot Password?</a>
            </div>

            <button type="submit" class="login__button" name="login">Login</button>
        </form>
    </div>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<div id='error-message'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']);
    }
    ?>
</body>

      <?php
    session_start();
    
    if(isset($_SESSION['error'])){
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['invalidmail'])) {
        echo $_SESSION['invalidmail'];
    }
    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['role'] == 'admin') {
            header("location:admin/dashboard.php");
            exit;
        } else {
            header("location:student/home.php");
            exit;
        }
    }

    include ("connection.php");
    if (isset($_POST['login'])) {
        if ((isset($_POST['username']) && isset($_POST['password']))) {
            $username = $_POST['username'];
            $password = $_POST['password'];
             echo"st";
            $query = "select * from users where user_name='$username'";
            $result = mysqli_query($con, $query);
            if (!$result) {
                die("connection failed" . mysqli_connect_error());
            }
            echo "hello";
           if(mysqli_num_rows($result)!=0){
            $row = mysqli_fetch_assoc($result);
            echo "hi";
           if (password_verify($password, $row['password'])) {
               echo "cor";
            if($row['status']=='active'){
                echo "act";
                  
             $_SESSION['user_id'] = $row['user_id'];
               
              $_SESSION['role'] = $row['role'];
                   header("location:index.php");
                
                ob_end_flush();
            }
            else{
                echo "<script>deactivatedmsg();</script>";
            }
  


} 

                  
            else {
                echo "<script>showerr();</script>";
            }
        }
        else{
            echo "<script>showerr();</script>";
        }

    
    }
    
    }

    ?>
   </body>
</html>
