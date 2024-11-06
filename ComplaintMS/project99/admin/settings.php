<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start(); ?>
<?php


session_start();

if (!(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin')) {
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
$name = "user";
$sql = "select * from users where user_id='$user'";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
}

$queryLocations = "SELECT * FROM location";
$resultLocations = mysqli_query($con, $queryLocations);


$queryComplaintTypes = "SELECT * FROM complaint_type";
$resultComplaintTypes = mysqli_query($con, $queryComplaintTypes);

if (isset($_POST['submit_location'])) {
    $location_name = mysqli_real_escape_string($con, $_POST['location_name']);


    $check_query = "SELECT * FROM location WHERE location_name = '$location_name'";
    $check_result = mysqli_query($con, $check_query);

    if ($check_result) {
       
        if (mysqli_num_rows($check_result) > 0) {
    
            echo "<script>alert('location already exists'); </script>";
        } else {
   
            $insert_query = "INSERT INTO location (location_name) VALUES ('$location_name')";
            if (mysqli_query($con, $insert_query)) {
       
                echo "Location added successfully.";
                header("location:settings.php");
            } else {
              
                echo "Error: " . mysqli_error($con);
            }
        }
    } else {
       
        echo "Error: " . mysqli_error($con);
    }
}
if (isset($_POST['add_complaint_type'])) {
    $type = $_POST['complaint_type'];


    $check_query = "SELECT * FROM complaint_type WHERE type = '$type'";
    $check_result = mysqli_query($con, $check_query);

    if ($check_result) {
       
        if (mysqli_num_rows($check_result) > 0) {
    
            echo "<script>alert('type already exists'); </script>";
        } else {
   
            $insert_query = "INSERT INTO complaint_type (type) VALUES ('$type')";
            if (mysqli_query($con, $insert_query)) {
       
                echo "tupe added successfully.";
                header("location:settings.php");
            } else {
              
                echo "Error: " . mysqli_error($con);
            }
        }
    } else {
       
        echo "Error: " . mysqli_error($con);
    }
}

if (isset($_GET['delete_location'])) {
    $location_id = $_GET['delete_location'];
    
    $delete_query = "DELETE FROM location WHERE location_id = '$location_id'";
    
    if (mysqli_query($con, $delete_query)) {

        echo "Location deleted successfully.";
        header("location:settings.php");
    } else {
      
        echo "Error: " . mysqli_error($con);
    }
}



if (isset($_GET['delete_type'])) {
    $id = $_GET['delete_type'];


    $delete_query = "DELETE FROM complaint_type WHERE type_id = '$id'";
    
    if (mysqli_query($con, $delete_query)) {
       
        echo "Location deleted successfully.";
        header("location:settings.php");
    } else {
       
        echo "Error: " . mysqli_error($con);
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
    <link rel = "stylesheet" href="popupstyle.css" >
    <title>Admin-Location Settings</title>
    <link rel="icon" href="favicon.png" sizes="120x120" type="image/png">
</head>

<script>
      if(window.history.replaceState){
    window.history.replaceState(null,null,window.location.href);}
</script>
<body>

    <div class="container" id="blur">
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
                <a href="profile.php">
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
                <a href="complaints.php" class="active">
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
                <a href="create.php">
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
        <h1>SETTINGS</h1>
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
            

            <div class="recent-orders">
                <h2>Locations Table</h2>
                <form class="form1" method="post" action="">
                    <label for="location_name">Location Name :</label>
                    <input id="location_name" name="location_name" required>
                    <button type="submit" class="btn btn-primary" name="submit_location">Add Location</button>
                </form>
                <table>
                    <thead>
                        <tr>
                        
                            <th>Location Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Print data from the 'locations' table
                        if (mysqli_num_rows($resultLocations) > 0) {
                            while ($row = mysqli_fetch_assoc($resultLocations)) {
                                echo "<tr>";
                                echo "<td>" . $row["location_name"] . "</td>";
                                echo "<td><a href='settings.php?delete_location=" . $row["location_id"] . "'>Delete</a></td>"; 
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <h2>Complaint Types Table</h2>
                <form class="form1" method="POST" action="settings.php">
                    <label for="complaint_type">Complaint Type :</label>
                    <input type="text" id="complaint_type" name="complaint_type" required>
                    <button type="submit" class="btn btn-primary" name="add_complaint_type">Add Type</button>
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
            
                        if (mysqli_num_rows($resultComplaintTypes) > 0) {
                            while ($row = mysqli_fetch_assoc($resultComplaintTypes)) {
                                echo "<tr>";
                            
                                echo "<td>" . $row["type"] . "</td>";
                                echo "<td><a href='settings.php?delete_type=". $row["type_id"] . "'>Delete</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script src="index.js"></script>
</script>
         if(window.history.replaceState){
                window.history.replaceState(null,null,window.location.href);
            }</script>
</body>
</html>