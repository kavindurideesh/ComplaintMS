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
require('actions.php');

if (isset($_POST['createuser'])) {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    
    $result = createUser($username, $name, $email, $password, $role);

    if ($result) {
        header("location: manage.php");
        exit;
    } else {
        echo mysqli_error($con);
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
    <!-- <link rel = "stylesheet" href="popupstyle.css" > -->
    
    <title>Admin-Create User</title>
    <link rel="icon" href="favicon.png" sizes="120x120" type="image/png">
    <style>
        main .recent-orders .form1 button,
main .recent-orders .p-3 button{
    background-color: var(--color-primary);
    color: white;
    border-radius: 4px;
    padding: 2px;
    margin-left: 5px;
}
    </style>
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
                <a href="create.php" class="active">
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
            <h1>CREATE USERS</h1>
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

            <div class="analyse">
                <div class="sales">
                    <form method="post" action="" class="p-3">
                        <div class="inputfield">
                            <label for="username" class="form-label">Username :</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>

                        <div class="inputfield">
                            <label for="name" class="form-label">Name :</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="inputfield">
                            <label for="email" class="form-label">Email :</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>

                        <div class="inputfield">
                            <label for="password" class="form-label">Password :</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        <div class="inputfield">
                            <label for="role" class="form-label">Role :</label>
                            <div class="custom_select">
                                <select class="form-select" name="role" required>
                                    <option value="admin">Admin</option>
                                    <option value="student">Student</option>
                                </select>
                            </div>
                        </div>
                
                        <button type="submit" class="btn btn-primary" name="createuser">Create User</button>
                    </form>
                </div>
            </div><br><br>
               <h2>Upload Excel</h2>
<form class="" action="" method="post" enctype="multipart/form-data">
			<input type="file" name="excel" required value=""><span>(username,name,email,password,role)</span>
			<button type="submit" name="import">Import</button>
		</form>
        </main>
        <!-- End of Main Content -->
    </div>


    <script src="index.js"></script>

</body>

</script>
         if(window.history.replaceState){
                window.history.replaceState(null,null,window.location.href);
            }</script>

</html>
<?php
include("../connection.php");
		if(isset($_POST["import"])){
			$fileName = $_FILES["excel"]["name"];
			$fileExtension = explode('.', $fileName);
       $fileExtension = strtolower(end($fileExtension));
			$newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

			$targetDirectory = "uploads/" . $newFileName;
			move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

			error_reporting(0);
			ini_set('display_errors', 0);

			require 'excelReader/excel_reader2.php';
			require 'excelReader/SpreadsheetReader.php';

			$reader = new SpreadsheetReader($targetDirectory);
			foreach($reader as $key => $row){
				$username = $row[0];
				$name = $row[1];
				$email = $row[2];
                $password = $row[3];
                $role = $row[4];

				if(mysqli_query($con, "INSERT INTO users VALUES('', '$username', '$name', '$email','$password','$role','active')")){
                    echo
                    "
                    <script>
                    alert('Succesfully Imported');
                    document.location.href = '';
                    </script>
                    ";
                }
                else{
                    echo
                    "
                    <script>
                    alert('Import failed');
                    document.location.href = '';
                    </script>
                    ";
                }
			}

			
		}
		?>
        