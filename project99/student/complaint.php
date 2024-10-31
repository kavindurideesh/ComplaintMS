<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start();

session_start();

// Debugging: Check the session variables

if (!(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'student')) {
    header("location:../login.php");
    ob_end_flush();
}
$user = $_SESSION['user_id'];
include("../connection.php");
$query = "SELECT * FROM user_profiles WHERE user_id = '$user'";
$result = mysqli_query($con, $query);

$imagePath = "../profileimages/person.png";
$query = "SELECT * FROM user_profiles WHERE user_id = '$user'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $imagePath = $row['path'];
}


     function name(){
         if(isset($_POST['updater'])){
             $_SESSION['issue_id'] = $_POST['updater'];
             echo "update";
         }else{
             echo "submit";
         }
         
     }
     if (isset($_POST['updater'])) {
     
         $issue_id =  $_SESSION['issue_id'];
     
       
         $query = "SELECT * FROM complaints WHERE issue_id ='$issue_id'";
         $result = mysqli_query($con, $query);
         
         if ($result && mysqli_num_rows($result) > 0) {
           
             $row = mysqli_fetch_assoc($result);
           
     }
     else{
         echo mysqli_error($con);
     }
     }
     function setValue($val)
     {
     global $row; 
     if (isset($row[$val])) {
         echo $row[$val];
     } else {
         echo "";
     }
     }
     
     function setSelected($val, $optionValue)
     {
     global $row; 
     if (isset($row[$val]) && $row[$val] === $optionValue) {
         echo "selected";
     } else {
         echo "";
     }
     }
     
     function title(){
         if(isset($_POST['updater'])){
             
             echo "update the form";
         }else{
             echo "Add an complaint";
         }
     }
  
     if (isset($_POST['submit'])) {
         $username = $_POST['username'];
         $contact = $_POST['contact'];
         $location = $_POST['location'];
         $type = $_POST['type'];
         $date = $_POST['date'];
    
         $issue = $_POST['issue'];
         $serial = $_POST['serial'];
     
     
         $query = "INSERT INTO complaints (user_id,user_name,contact,location,type,date,issue,serial,status)
                   VALUES ('$user','$username','$contact', '$location', '$type', '$date', '$issue', '$serial','unresolved')";
     
         if (mysqli_query($con, $query)) {
            //echo "<script>window.location.href='studentuser.php';</script>";
         } else {
             echo "Error: " . mysqli_error($con);
         }
        
     }
     
     if (isset($_POST['update'])) {
     
     
         $issue_id=$_SESSION['issue_id'];
         $updatedUsername = $_POST['username'];
         $updatedLocation = $_POST['location'];
         $updatedType = $_POST['type'];
         $updatedDate = $_POST['date'];
    
         $updatedIssue = $_POST['issue'];
         $updatedSerial = $_POST['serial'];
     
         $updateQuery = "UPDATE complaints 
                         SET username = '$updatedUsername', 
                             location = '$updatedLocation', 
                             type = '$updatedType', 
                             date = '$updatedDate', 
                           
                             issue = '$updatedIssue', 
                             serial = '$updatedSerial' 
                         WHERE issue_id = '$issue_id'";
     
         if (mysqli_query($con, $updateQuery)) {
             unset($_SESSION['issue_id']);
             header("location:history.php");
             exit;
            
         } else {
             unset($_SESSION['issue_id']);
          echo "Error: " . mysqli_error($con);
         }
     }
     
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/complaint123.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            if(window.history.replaceState){
    window.history.replaceState(null,null,window.location.href);}
  

        document.addEventListener("DOMContentLoaded", function() {
            const profileImageElement = document.getElementById("profile");
            const imagePath = "<?php echo $imagePath; ?>"; 
            profileImageElement.src = imagePath;
        });
    
    </script>
    <style>
        #profile2 {
            border: 1px solid black;
            height: 60px;
            width: 60px;
            margin: 10px;
            border-radius: 50%;
            box-shadow: 2px 3px 10px black;
            background-color: white;
            background-size: 100%;
            background-position: center;
            background-size: 60px 60px;
        }
    </style>
    <title>Student-Complaint</title>
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
                    ADD COMPLAINT
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
                            <img id="profile" src="" alt="profile_pic">
                        </div>
                        <div class="profile_info">
                            <p>Welcome</p>
                            <p class="profile_name">User</p>
                        </div>
                    </div>
                    <ul>
                    <li><a href="home.php"><span class="icon"><i class="ri-home-4-fill"></i></span><span class="title">Home</span></a></li>
                        <li>
                            <a href="about.php">
                            <span class="icon"><i class="ri-information-fill"></i></span>
                            <span class="title">About</span>
                            </a>
                        </li>
                        <li>
                            <a href="profile.php">
                            <span class="icon"><i class="ri-account-circle-fill"></i></span>
                            <span class="title">Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="password.php">
                            <span class="icon"><i class="ri-key-2-fill"></i></span>
                            <span class="title">Change Password</span>
                            </a>
                        </li>
                        <li>
                            <a href="complaint.php" class="active">
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
                        Add Complaint On
                    </div>
                    <form action="" method="post">
                        <div class="inputfield">
                            <label>User Name</label>
                            <input required type="text" class="input" id="username" name="username" value="<?php setValue('user_name'); ?>">
                        </div>
                        <div class="inputfield">
                            <label>Contact No</label>
                            <input required type="text" class="input" id="contact" name="contact" value="<?php setValue('contact'); ?>">
                        </div>
                        <div class="inputfield">
                            <label>Location</label>
                            <div class="custom_select">
                                <select required id="location" name="location"></select>
                            </div>
                        </div>
                        <div class="inputfield">
                            <label>Type</label>
                            <div class="custom_select">
                                <select required id="type" name="type"></select>
                            </div>
                        </div>
                        <div class="inputfield">
                            <label>Date</label>
                            <input type="date" class="input" id="date" name="date" required value="<?php setValue('date'); ?>">
                        </div>
                        <div class="inputfield">
                            <label>Description of Issue</label>
                            <textarea id="issue" name="issue" required class="textarea"><?php setValue('issue'); ?></textarea>
                        </div>
                        <div class="inputfield">
                            <label>Serial</label>
                            <input type="text" class="input" id="serial" name="serial"  value="<?php setValue('serial'); ?>">
                        </div>
                        <div class="inputfield">
                            <label>Upload Image</label>
                            <input type="file" class="input" id="image" name="image" accept="image/*">
                        </div>
                        <div class="inputfield">
                            <input type="submit" name="<?php name(); ?>" value="<?php name(); ?>" class="btn" onclick="openPopup()">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
   
</body>
</html>
<script>
 fetch('./getloc.php', {
  method: 'POST', // or 'GET', 'PUT', etc.
  headers: {
    'Content-Type': 'application/json', // Specify the content type if needed
    // You can add other headers as needed
  },
})
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    // Handle the response data here
    console.log(data);
    var locationSelect = $("#location");
    locationSelect.empty();

    if (data.length > 0) {
      locationSelect.append("<option value='' disabled selected>Select Location</option>");

      for (var i = 0; i < data.length; i++) {
        locationSelect.append("<option value='" + data[i] + "'>" + data[i] + "</option>");
      }
    } else {
      locationSelect.append("<option value='' disabled selected>No locations found</option>");
    }
  })
  .catch(error => {
    // Handle errors here
    console.error('Fetch error:', error);
  });

        $(document).ready(function () {
    $.ajax({
        type: "POST",
        url: "gettype.php",
        dataType: "json",
        success: function (response) {
            var locationSelect = $("#type");
            locationSelect.empty();

            var hasOtherOption = false; // Track whether the "other" option is present in the response

            if (response.length > 0) {
                for (var i = 0; i < response.length; i++) {
                    if (response[i] === "other") {
                        locationSelect.prepend("<option value='other'>Other</option>");
                        hasOtherOption = true;
                    } else {
                        locationSelect.append("<option value='" + response[i] + "'>" + response[i] + "</option>");
                    }
                }
            }

            if (!hasOtherOption) {
                locationSelect.prepend("<option value='other'>Other</option>");
            }
        },
        error: function () {
            alert("Error fetching type options.");
        }
    });
});

    </script>
</script>
