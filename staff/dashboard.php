<?php

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



$queryUnresolved = "SELECT COUNT(*) as unresolvedCount FROM complaints WHERE status = 'unresolved'";
$resultUnresolved = mysqli_query($con, $queryUnresolved);
$rowUnresolved = mysqli_fetch_assoc($resultUnresolved);
$unresolvedCount = $rowUnresolved['unresolvedCount'];

// Find the number of solved complaints
$querySolved = "SELECT COUNT(*) as solvedCount FROM complaints WHERE status = 'resolved'";
$resultSolved = mysqli_query($con, $querySolved);
$rowSolved = mysqli_fetch_assoc($resultSolved);
$solvedCount = $rowSolved['solvedCount'];


$totalCount = $unresolvedCount + $solvedCount;



if (isset($_GET['id'])) {
    $id = $_GET['id'];
    include('connection.php');
    if(isset($_POST["comment"]) && isset($_POST["name"]) ){
        $comment = $_POST["comment"];
        $name =$_POST["name"];


    $query = "SELECT * from complaints where issue_id=$id";

        $result = mysqli_query($con,$query);

        while($row = mysqli_fetch_assoc($result)){
            $issue_id = $row['issue_id'];
            $user_id = $row['user_id'];

            $date = date('Y-m-d');
            $queryinsert = "INSERT into resolved_complaints (issue_id,user_id,date_solved,comments,resolved_by) values('$issue_id','$user_id','$date','$comment','$name')";

            $result2 = mysqli_query($con,$queryinsert);

            if(!($result2)){
                echo mysqli_error($con);
            }



            $queryupdate = "UPDATE complaints set status='resolved' where issue_id='$id'";
            $resultupdate = mysqli_query($con,$queryupdate);

            if(!($resultupdate)){
               echo mysqli_error($con);
            }
        }
        $urlWithoutId = strtok($_SERVER['REQUEST_URI'], '?');
        // Redirect to the URL without the "id" parameter
        header("Location: $urlWithoutId");
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
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <link rel = "stylesheet" href="popupstyle123.css" >
    <title>Admin-Dashboard</title>
    <link rel="icon" href="favicon.png" sizes="120x120" type="image/png">

    <style>
        main .analyse{
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.6rem;
        }

        .h{
            font-weight: 800;
            font-size: 1.8rem;
            display: flex;
            color: var(--color-dark);
        }

        main{
            margin-top: 0rem;
        }
        
        main .nav {
            display: flex;
            gap: 2rem;
            justify-content: flex-end;
            flex-direction: row;
            align-items: center;
            margin-top: -4rem;
        }

    </style>
</head>

<script>
document.addEventListener('DOMContentLoaded', function() {
  
    function togglePopup() {
        var blur = document.getElementById('blur');
        blur.style.filter = 'blur(200px)';
        blur.style.pointerEvents = 'none';
        blur.style.userSelect = 'none';

        var popup = document.getElementById('popup');
        popup.style.visibility = 'visible';
        popup.style.opacity = '1';
        popup.style.transition = '0.5s';
        popup.style.top = '50%';
    }

    


    var toggleButton = document.getElementById('toggleButton');
    toggleButton.addEventListener('click', togglePopup);
});   
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
                <a href="dashboard.php" class="active">
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
                <a href="settings.php">
                    <span class="material-icons-sharp">
                        settings
                    </span>
                    <h3>settings</h3>
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
            <h1 class="h">Dashboard</h1>
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
                        <img src="<?php echo $imagePath;?>">>
                    </div>
                </div>

            </div>
            <!-- Analyses -->
            <div class="analyse">
                <div class="sales">
                    <div class="status">
                        <div class="info">
                            <h3>Total Complaints</h3>
                            <h1 class="h"><?php echo $totalCount ;?></h1>
                        </div>
                        
                    </div>
                </div>
                <div class="visits">
                    <div class="status">
                        <div class="info">
                            <h3>Resolved Complaints</h3>
                            <h1 class="h"><?php echo $solvedCount ;?></h1>
                        </div>
                        
                    </div>
                </div>
                <div class="searches">
                    <div class="status">
                        <div class="info">
                            <h3>Unresolved Complaints</h3>
                            <h1 class="h"><?php echo $unresolvedCount ;?></h1>
                        </div>
                       
                    </div>
                </div>
            </div>

            <div class="recent-orders">
                <h2>Complaints</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Issue</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('../connection.php');

                        $query = "SELECT users.name AS name, complaints.user_name, complaints.issue_id, complaints.contact, complaints.date, complaints.type,
                         complaints.status, complaints.issue FROM users INNER JOIN complaints ON users.user_id = complaints.user_id WHERE
                          complaints.status = 'unresolved';";

                        $result = mysqli_query($con, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['issue_id'];
                        ?>
                            <tr>
                                <td><?php echo $row['user_name'] ?></td>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["contact"]; ?></td>
                                <td><?php echo $row["date"]; ?></td>
                                <td><?php echo $row["type"]; ?></td>
                                <td><?php echo $row["issue"]; ?></td>
                                <td><?php echo $row["status"]; ?></td>
                              <td style="text-align:center;"><button class="button" id="toggleButton">Change Status</button></td>
                            </tr>
                        <?php }

                        ?>
                    </tbody>
                </table>
               
            </div>
        </main>
        <!-- End of Main Content -->

        


        </div>


    </div>

    <div id="popup">
        <div id="closePopup">
            <i class="fas fa-xmark" >X</i>
        </div>
    <form method="post" action="dashboard.php?id=<?php echo $id ?>">
        <h1>ADD COMMENT</h1>
        <label for="name">Resolved by</label><br>
        <input type="text" name="name" value="" required>
        <label for="cmt">Comment of issue</label><br>
        <textarea name="comment" id="cmt" required></textarea> <br><br>
        <input type="submit" class="btn" name="submit" value="ADD">
    </form>
</div>
    <script>
        function popupClose(){
            var popup = document.getElementById('popup');
            var blur = document.getElementById('blur');
            blur.style.filter="none";
            popup.style.visibility = 'hidden';
            blur.style.pointerEvents = 'unset';
             blur.style.userSelect = 'unset';
            console.log("Hello")
        }
        const closePopup = document.getElementById("closePopup");
        closePopup.addEventListener("click",popupClose)
    </script>
    <script src="index.js"></script>

</body>



</html>