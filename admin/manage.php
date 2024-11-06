<?php 
ob_start();
session_start();
if(!(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin')) {
    header("location:../login.php");
    exit;
}
$user=$_SESSION['user_id'];
include("../connection.php");
require 'actions.php';
$sqlAdmins = "SELECT user_name, name, email, status FROM users WHERE role = 'admin'";
$resultAdmins = mysqli_query($con, $sqlAdmins);
$admins = array();

if ($resultAdmins) {
    while ($row = mysqli_fetch_assoc($resultAdmins)) {
        $admins[] = $row;
    }
}

$sqlStudents = "SELECT  user_id,user_name, name, email, status FROM users WHERE role = 'student'";
$resultStudents = mysqli_query($con, $sqlStudents);
$students = array();

if ($resultStudents) {
    while ($row = mysqli_fetch_assoc($resultStudents)) {
        $students[] = $row;
    }
}
if (isset($_POST['toggle_status'])) {
    $id = $_POST['student'];
    
   
    $currentStatus = getStatus($id);

  
    $newStatus = ($currentStatus === 'active') ? 'inactive' : 'active';
      $result = updateStatus($id, $newStatus);

    if ($result) {
        header("location:manage.php");
        exit;
    } else {
        echo mysqli_error($con);
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = $_POST['delete'];

   
    $deleteSql = "DELETE FROM users WHERE user_id = $id";
    $deleteResult = mysqli_query($con, $deleteSql);

    if ($deleteResult) {
      
        header("location:manage.php");
        exit;
    } else {
        echo mysqli_error($con);
    }
}


$imagePath = "../profileimages/person.png";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.15/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.15/dist/sweetalert2.all.min.js"></script>
    <!-- Add this to the <head> section of your HTML file -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script> -->


    <link rel="stylesheet" href="admin123.css">
    <script>
        function submitDeleteForm(studentId) {
    Swal.fire({
        title: 'Confirm Delete',
        text: 'Are you sure you want to delete this student?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'post';
            form.action = ''; 
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete';
            input.value = studentId;
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

    </script>  
    <title>Admin-Manage User</title>
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
                <a href="manage.php" class="active">
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
            <h1>MANAGE USERS</h1>
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
                <h2>Students</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th colspan="2">Actions</th>
                        </tr>
                        <?php foreach ($students as $student){ ?>
                        <tr>
                        
                            <td><?php echo $student['user_name']; ?></td>
                            <td><?php echo $student['name']; ?></td>
                            <td><?php echo $student['email']; ?></td>
                            <td><?php echo $student['status']; ?></td>
                            <td>
                                <form method="post" action="">
                                    <input type="hidden" name="student" value=<?php echo $student['user_id']; ?>>
                                    <input type="submit" name="toggle_status" value="<?php echo ($student['status'] === 'active') ? 'Deactivate' : 'Activate'; ?>">
                                </form>
                                
                                <button onclick="submitDeleteForm('<?php echo $student['user_id'];?>')">delete</button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <h2>Admins</h2>
    
                <table >
                    <thead>
                    <tr>
                    
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr></thead>
                    <tbody>
                    <?php foreach ($admins as $admin){ ?>
                        <tr>
                        
                            <td><?php echo $admin['user_name']; ?></td>
                            <td><?php echo $admin['name']; ?></td>
                            <td><?php echo $admin['email']; ?></td>
                            <td><?php echo $admin['status']; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

               
            </div>
        </main>
        <!-- End of Main Content -->

        

    </div>

 
    <script src="index.js"></script>

</body>

</html>