<?php ob_start(); ?>
<?php 
session_start();

// Check session variables
if (!(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'student')) {
    header("location:../login.php");
    exit;
}

$user = $_SESSION['user_id'];
$imagePath = "../profileimages/person.png"; 
include("../connection.php");

$query = "SELECT * FROM user_profiles WHERE user_id = '$user'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $imagePath = $row['path'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <script>
        $(document).ready(function(){
            $(".hamburger .hamburger__inner").click(function(){
                $(".wrapper").toggleClass("active");
            });
            $(".top_navbar .fas").click(function(){
                $(".profile_dd").toggleClass("active");
            });
        });

        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        document.addEventListener("DOMContentLoaded", function() {
            const profileImageElement = document.getElementById("profile");
            const imagePath = "<?php echo $imagePath; ?>"; 
            profileImageElement.src = imagePath;
        });
    </script>
    <title>Student - About</title>
    <link rel="icon" href="favicon.png" sizes="120x120" type="image/png">
    <style>
        body {
            font-size: 18px; /* Increase base font size */
        }
        .container h2 {
            font-size:2.7em; /* Larger title font */
                }
        .container h3 {
            font-size:1.5em; /* Larger title font */
        }
        .profile_name {
            font-size: 22px;
        }
        .profile p {
            font-size: 20px;
        }
        .sidebar ul li a .title {
            font-size: 18px;
        }
    </style>
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
                <div class="logo">About</div>
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
                            <img id="profile" src="" alt="profile_pic">
                        </div>
                        <div class="profile_info">
                            <p>Welcome</p>
                            <p class="profile_name">User</p>
                        </div>
                    </div>
                    <ul>
                        <li><a href="home.php"><span class="icon"><i class="ri-home-4-fill"></i></span><span class="title">Home</span></a></li>
                        <li><a href="about.php" class="active"><span class="icon"><i class="ri-information-fill"></i></span><span class="title">About</span></a></li>
                        <li><a href="profile.php"><span class="icon"><i class="ri-account-circle-fill"></i></span><span class="title">Profile</span></a></li>
                        <li><a href="password.php"><span class="icon"><i class="ri-key-2-fill"></i></span><span class="title">Change Password</span></a></li>
                        <li><a href="complaint.php"><span class="icon"><i class="ri-add-circle-fill"></i></span><span class="title">Add Complaint</span></a></li>
                        <li><a href="history.php"><span class="icon"><i class="ri-check-double-line"></i></span><span class="title">Your Complaints</span></a></li>
                    </ul>
                </div>
            </div>

            <div class="container">
                <center>
                    <h2><strong><i>Welcome to the Department of Computer Science Complaint Register Portal</i></strong></h2>
                </center>
                <br><br><br><br><br><br><br>
                
                <center>
                    <h3>At the Department of Computer Science, University of Jaffna, we are dedicated to maintaining an environment of academic excellence and continuous growth. We understand that challenges can arise, and your feedback is crucial in helping us enhance our offerings and services. Our Complaint Register Portal serves as a platform for you to voice your concerns and contribute to the betterment of our department.</h3>
                </center>
                <br><br><br>
                
                <center>
                    <h3>To make your experience as seamless as possible, we've designed an intuitive portal for submitting complaints. The exclusive task at hand is to log in and complete the form to officially register your complaint. Our dedicated team is committed to addressing your concerns in a timely and effective manner.</h3>
                </center>
                    <br><br><br>
                <center>
                    <h3>Your complaint will be recorded and dealt with by the most appropriate team or person in our department.</h3>
                </center>
            </div>
        </div>
    </div>  
</body>
</html>
