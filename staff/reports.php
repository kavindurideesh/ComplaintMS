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



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="admin123.css">
    <link rel = "stylesheet" href="popupstyle.css" >
    <title>Admin-Reports</title>
    <link rel="icon" href="favicon.png" sizes="120x120" type="image/png">
   
        
</head>



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
                <a href="reports.php" class="active">
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
        <h1>REPORTS</h1>
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
      
                <div class="recent-orders">

                <h2>Solved Issues</h2>

    <table id="complaint" >

    <tr>
         <thead>
            <th>USER_NAME</th>
            <th>LOCATION</th>
            <th>TYPE</th>
            <th>ISSUE</th>
            <th>DATE_REGISTERED</th>
            <th>DATE_SOLVED</th>
            <th>COMMENTS</th>
            <th>RESOLVED_BY</th>

        </tr>
        </thead>
        <tbody>

        <?php


            include('../connection.php');


            $query = "SELECT u.user_name,c.contact,c.location,c.type,c.issue,c.date,date_solved,c.serial,r.comments,r.resolved_by
            from complaints as c , resolved_complaints as r , users as u
            where (c.issue_id=r.issue_id and u.user_id=r.user_id) order by date desc";


            if($result = mysqli_query($con,$query)){

            while($row = mysqli_fetch_assoc($result)){
                ?>


    <tr>

                <td><?php echo $row["user_name"]."<br>"; ?></td>
                <td><?php echo $row["location"]."<br>"; ?></td>
                <td> <?php echo $row["type"]."<br>"; ?></td>
                <td><?php echo $row["issue"]."<br>"; ?></td>
                <td><?php echo $row["date"]."<br>"; ?></td>
                <td><?php echo $row["date_solved"]."<br>"; ?></td>
                <td><?php echo $row["comments"]."<br>"."<br>"; ?></td>
                <td><?php echo $row["resolved_by"]."<br>"."<br>"; ?></td>
            </tr>

        <?php
            }
        }

        ?>
        </tbody>
        </table>

</div>

        </main


    </div>


    <script src="index.js"></script>

</body>



</html>