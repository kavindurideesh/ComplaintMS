<?php 
error_reporting(E_ALL);
ini_set('display_errors',1);
ob_start(); ?>
<?php 

session_start();

if(!(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin')) {
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
$name = "user";
$sql = "select * from users where user_id='$user'";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
}

if (isset($_POST['upload'])) {
    $targetDirectory = "../profileimages/"; 
    $allowedExtensions = array("jpg", "jpeg");
    $maxFileSize = 1024 * 1024; // 2 MB

    $fileExtension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $imagePath = $targetDirectory . $_FILES["image"]["name"];

    // Check if user ID exists
    $query = "SELECT path FROM user_profiles WHERE user_id = '$user'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $userIdExists = true;

        // Delete the previous image if it exists
        $currentImagePath = $row['path'];
        if (file_exists($currentImagePath)) {
            unlink($currentImagePath);
        }
    } else {
        $userIdExists = false;
    }

    if (in_array($fileExtension, $allowedExtensions) && $_FILES["image"]["size"] <= $maxFileSize) {
        if ($userIdExists) {
            // Update the image path in the database
            $updateQuery = "UPDATE user_profiles SET path = '$imagePath' WHERE user_id = '$user'";
            $updateResult = mysqli_query($con, $updateQuery);

            if ($updateResult) {
                echo "Image updated successfully.";
            } else {
                echo "Error updating image record: " . mysqli_error($con);
            }
        } else {
            $insertQuery = "INSERT INTO user_profiles (user_id, path) VALUES ('$user', '$imagePath')";
            $insertResult = mysqli_query($con, $insertQuery);

            if ($insertResult) {
                echo "Image uploaded and record inserted successfully.";
            } else {
                echo "Error inserting image record: " . mysqli_error($con);
            }
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
            echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded for user " . $user;
        } else {
            echo "Error uploading the file.";
        }
    } else {
        echo "Only JPG and JPEG files up to 1MB are allowed.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
        <link rel="stylesheet" href="admin123.css">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <title>Admin-Profile</title>
        <link rel="icon" href="favicon.png" sizes="120x120" type="image/png">

        <style>
            body{
                width: 100vw;
                height: 100vh;
                font-family: 'Poppins', sans-serif;
                font-size: 0.88rem;
                user-select: none;
                overflow-x: hidden;
                color: var(--color-dark);
                background-color: var(--color-background);
            }

            h1{
                font-weight: 800;
                font-size: 1.8rem;
            }


            h3{
                font-weight: 500;
                font-size: 0.87rem;
            }

            aside{
                height: 100vh;
                width: 15rem;
                margin-left: -9rem;
            }

            aside .sidebar a{
                text-decoration: none;
            }

            main{
                margin-top: 1.4rem;
                margin-left: -9rem;
                width: 78.6rem;
            }
        </style>
    </head>

    <body>

        <div class="container">
            <!-- Sidebar Section -->
            <aside>
                <div class="toggle">
                    <div class="close" id="close-btn">
                        <span class="material-icons-sharp">
                            close
                        </span>
                    </div>
                </div>

                <div class="sidebar">
                    <a href="dashboard.php">
                        <span class="material-icons-sharp">
                            dashboard
                        </span>
                        <h3>Dashboard</h3>
                    </a>
                    <a href="profile.php" class="active">
                        <span class="material-icons-sharp">
                            person
                        </span>
                        <h3> Profile</h3>
                    </a>
                    <a href="manage.php">
                        <span class="material-icons-sharp">
                            manage_accounts
                        </span>
                        <h3> Manage Users</h3>
                    </a>
                    <a href="settings.php">
                        <span class="material-icons-sharp">
                            settings
                        </span>
                        <h3>Settings</h3>
                    </a>
                    <a href="reports.php">
                        <span class="material-icons-sharp">
                            report_gmailerrorred
                        </span>
                        <h3>Reports</h3>
                    </a>
                    <a href="createusers.php">
                        <span class="material-icons-sharp">
                            person_add
                            </span>
                        <h3>Create Users</h3>
                    </a>
                    <a href="../logout.php">
                        <span class="material-icons-sharp">
                            logout
                        </span>
                        <h3>Logout</h3>
                    </a>
                </div>
            </aside>
            <!-- End of Sidebar Section -->

            <!-- Main Content -->
            <main>
                <h1>PROFILE</h1>
                <div class="nav">
                    <button id="menu-btn">
                        <span class="material-icons-sharp">
                            menu
                        </span>
                    </button>
                    <div class="dark-mode">
                        <span class="material-icons-sharp active">
                            light_mode
                        </span>
                        <span class="material-icons-sharp">
                            dark_mode
                        </span>
                    </div>

                    <div class="profile">
                        <div class="info">
                            <p>Hey, <b><?php echo $name; ?></b></p>
                            <small class="text-muted">Admin</small>
                        </div>
                        <div class="profile-photo">
                            <img src="<?php echo $imagePath; ?>">
                        </div>
                    </div>
                </div>
                <!-- Analyses -->
                <div class="profile">
                    <div class="box-container">
                        <?php
                        include ("../connection.php");
                        $user=$_SESSION['user_id'];
                        $sql = "SELECT * FROM users WHERE user_id='$user'";
                        $result = mysqli_query($con, $sql);

                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                
                                
                        <div class="imgBx">
                            <img src="<?php echo $imagePath;?>">
                        </div>

                        <div class="box">
                            <p><strong>Username :</strong> <?php echo $row['user_name']; ?></p>
                            <p><strong>Email :</strong> <?php echo $row['email']; ?></p>
                            <p><strong>Role :</strong> <?php echo $row['role']; ?></p>  
                            <button class="btn btn-primary edit-btn" data-toggle="modal" data-target="#uploadModal" name="upload" value="">Edit</button>                   
                        </div>
                                
                            <?php }
                        } else {
                            echo "Error: " . mysqli_error($con);
                        }
                        
                        ?>
                    </div>
                </div>
            </main>
            <!-- End of Main Content -->
        </div>

        <div id="uploadModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Profile Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="uploadForm" action="profile.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="image">Select an image to upload (jpg, jpeg):</label>
                                <input type="file" class="form-control-file" name="image" id="image" accept=".jpg, .jpeg">
                            </div>
                            <div class="form-group text-center">
                                <input type="submit" name="upload" class="btn btn-primary" value="Edit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="index.js"></script>
    
    </body>
</html>