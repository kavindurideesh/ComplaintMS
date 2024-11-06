<?php ob_start(); ?>
<?php 


session_start();

// Debugging: Check the session variables



if(!(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'student')) {
     header("location:../login.php");
       exit;
}
	$user=$_SESSION['user_id'];
    $imagePath = "../profileimages/person.png"; 
    include("../connection.php");
    
    $query = "SELECT * FROM user_profiles WHERE user_id = '$user'";
    $result = mysqli_query($con, $query);
    
    
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imagePath = $row['path'];
    }
    
    
    include ("../connection.php");
 
  
 
    
    if(isset($_POST['change'])){
     $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
     $sql = "UPDATE users SET password ='$password' WHERE user_id = '$user'";
     $result=mysqli_query($con,$sql);
     if($result){
      header("location:./home.php");
      exit;
     }
      else{
         echo mysqli_error($con);
      }
    }
    
    
    
    
    ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/password.css">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
        <script>
            $(document).ready(function(){
                $(".hamburger .hamburger__inner").click(function(){
                $(".wrapper").toggleClass("active")
                })

                $(".top_navbar .fas").click(function(){
                $(".profile_dd").toggleClass("active");
                });
            })
            function validatePassword(event) {
                var newPassword = document.getElementById("new_password").value;
                var confirmPassword = document.getElementById("confirm_password").value;
                var confirmError = document.getElementById("confirm_password_error");

                if (newPassword !== confirmPassword) {
                    event.preventDefault();
                    confirmError.textContent = "Passwords do not match.";
                } else {
                    confirmError.textContent = ""; // Clear the error message
                }
            }
                        if(window.history.replaceState){
                window.history.replaceState(null,null,window.location.href);}
        </script>
         

        <title>Student-Change Password</title>
        <link rel="icon" href="favicon.png" sizes="120x120" type="image/png">
    </head>
    <body>
 
       
    <div class="wrapper">
            <div class="top_navbar">
                <div class="hamburger">
                    <div class="hamburger__inner">
                        <div class="one"></div>
                        <div class="two"></div>
                        <div class="three"></div>
                    </div>
                </div>
                <div class="menu">
                    <div class="logo">
                        CHANGE PASSWORD
                    </div>
                    <div class="right_menu">
                        <ul>
                            <li><i class="fas fa-user"></i>
                                <div class="profile_dd">
                                <div class="dd_item"><a href="../logout.php">Logout</a></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="main_container">
                <div class="sidebar">
                    <div class="sidebar__inner">
                        <div class="profile">
                            <div class="img">
                                <img src="<?php echo $imagePath ?>" alt="profile_pic">
                            </div>
                            <div class="profile_info">
                                <p>Welcome</p>
                                <p class="profile_name">User</p>
                            </div>
                        </div>
                        <ul>
                        <li><a href="home.php"><span class="icon"><i class="ri-home-4-fill"></i></span><span class="title">Home</span></a></li>
                            <li>
                                <a href="about.php" >
                                <span class="icon"><i class="ri-information-fill"></i></span>
                                <span class="title">About</span>
                                </a>
                            </li>
                            <li>
                                <a href="profile.php" >
                                <span class="icon"><i class="ri-account-circle-fill"></i></span>
                                <span class="title">Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="password.php" class="active">
                                <span class="icon"><i class="ri-key-2-fill"></i></span>
                                <span class="title">Change Password</span>
                                </a>
                            </li>
                            <li>
                                <a href="complaint.php">
                                <span class="icon"><i class="ri-add-circle-fill"></i></span>
                                <span class="title">Add Complaint</span>
                                </a>
                            </li>
                            <li>
                                <a href="history.php">
                                <span class="icon"><i class="ri-check-double-line"></i></span>
                                <span class="title">Your Complaints</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="container">
                    <div class="form">
                        <div class="title">
                            Change Password
                        </div>
                        <form action="" method="post">
                            <div class="inputfield">
                                <label>New Password</label>
                                <input required type="password" class="input" id="confirm_password" name="confirm_password">
                            </div>  
                            <div class="inputfield">
                                <label>Confirm Password</label>
                                <input required type="password" class="input" id="contact" name="contact">
                            </div>  
                            <div class="inputfield">
                                <input type="submit" name="change" value="CHANGE PASSWORD" class="btn" onclick="validatePassword(event)">
                            </div>
                        </form>
                    </div>
                </div>
            </div>	
        </div>
    </body>
</html>

    </body>
</html>
