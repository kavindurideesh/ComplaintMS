<?php
ob_start();
session_start();

if (isset($_SESSION['error'])) {
    echo "<div id='error-message'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("location:admin/dashboard.php");
        exit;
    } 
    elseif($_SESSION['role'] == 'staff')
    {
        header("location:staff/dashboard.php");
        exit;
    }
    else {
        header("location:student/home.php");
        exit;
    }
}

include("connection.php");
if (isset($_POST['login'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query to find user by username
        $query = "SELECT * FROM users WHERE user_name='$username'";
        $result = mysqli_query($con, $query);

        if (!$result) {
            die("Connection failed: " . mysqli_connect_error());
        }

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Check if the password matches the stored hash
            if (!password_verify($password, $row['password'])) {
                if ($row['status'] == 'active') {
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['role'] = $row['role'];
                    header("location:index.php");
                    ob_end_flush();
                } else {
                    $_SESSION['error'] = "Your account has been disabled";
                    header("location:login.php");
                    exit();
                }
            } else {
                $_SESSION['error'] = "Incorrect username or password";
                header("location:login.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Incorrect username or password";
            header("location:login.php");
            exit();
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
        #error-message {
            color: red;
            margin-top: 20px;
            text-align: center;
        }
    </style>
    <script>
        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body>
    <center>
        <h1 class="bh">COMPLAINT MANAGEMENT SYSTEM</h1>
    </center>
    <div class="login">
        <form action="" class="login__form" method="post">
            <h1 class="login__title">Login</h1>

            <!-- Display error message if set -->
            <?php
            if (isset($_SESSION['error'])) {
                echo "<div id='error-message'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']);
            }
            ?>

            <div class="login__content">
                <div class="login__box">
                    <i class="ri-user-3-line login__icon"></i>
                    <div class="login__box-input">
                        <input type="text" name="username" required class="login__input" placeholder=" ">
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
</body>

</html>