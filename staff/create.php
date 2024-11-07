<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();

session_start();

// Ensure only admins can access this page
if (!(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'staff')) {
    header("location:../login.php");
    exit;
}

$user = $_SESSION['user_id'];
$imagePath = "../profileimages/person.png";
include("../connection.php");

// Fetch user profile image
$query = "SELECT * FROM user_profiles WHERE user_id = '$user'";
$result = mysqli_query($con, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $imagePath = $row['path'];
}

$name = "Admin";
$sql = "SELECT * FROM users WHERE user_id='$user'";
$result = mysqli_query($con, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
}

// Fetch locations and complaint types for dropdowns
$locationsQuery = "SELECT * FROM location";
$locationsResult = mysqli_query($con, $locationsQuery);

$typesQuery = 'SELECT * FROM complaint_type';
$typesResult = mysqli_query($con, $typesQuery);

// Handling the form submission (same as earlier)
if (isset($_POST['submit_complaint'])) {
    $username = $_POST['username'];
    $contact = $_POST['contact'];
    $location = $_POST['location'];
    $type = $_POST['type'];
    $date = $_POST['date'];
    $issue = $_POST['issue'];
    $serial = $_POST['serial'];

    // Default image path
    $imagePath1 = "../Cimg/complaint.png";

    // Handle file upload for complaint image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxFileSize) {
            $uploadDir = __DIR__.'/../Cimg/';
            $fileName = preg_replace("/[^a-zA-Z0-9.]/", "_", $fileName); // Sanitize file name
            $newFileName = basename($fileName);
            $destPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $imagePath1 = '../Cimg/'.$newFileName; // Store the path for DB insertion
            } else {
                echo "Error moving the uploaded file.";
            }
        } else {
            echo "Invalid file type or file too large.";
        }
    }

    // Insert the complaint into the database
    $query = "INSERT INTO complaints (user_id, user_name, contact, location, type, date, issue, serial, status, image_path)
              VALUES ('$user', '$username', '$contact', '$location', '$type', '$date', '$issue', '$serial', 'unresolved', '$imagePath1')";

    if (mysqli_query($con, $query)) {
        header("location: dashboard.php"); // Redirect to complaints history after submission
        exit;
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
    <title>Admin - Create Complaint</title>
    <link rel="icon" href="favicon.png" sizes="120x120" type="image/png">
</head>
<body>

<div class="container" id="blur">
    <aside>
        <div class="toggle">
            <div class="close" id="close-btn">
                <span class="material-icons-sharp">close</span>
            </div>
        </div>

        <div class="sidebar">
            <a href="dashboard.php">
                <span class="material-icons-sharp">dashboard</span>
                <h3>Dashboard</h3>
            </a>
            <a href="profile.php">
                <span class="material-icons-sharp">person</span>
                <h3>Profile</h3>
            </a>
            <a href="reports.php">
                <span class="material-icons-sharp">report_gmailerrorred</span>
                <h3>Reports</h3>
            </a>
            <a href="create.php" class="active">
                <span class="material-icons-sharp">person_add</span>
                <h3>Create Complaint</h3>
            </a>
            <a href="../logout.php">
                <span class="material-icons-sharp">logout</span>
                <h3>Logout</h3>
            </a>
        </div>
    </aside>

    <main>
        <h1>Create Complaint</h1>
        <div class="nav">
            <button id="menu-btn">
                <span class="material-icons-sharp">menu</span>
            </button>
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
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="inputfield">
                        <label>User Name</label>
                        <input type="text" class="input" name="username" required>
                    </div>
                    <div class="inputfield">
                        <label>Contact No</label>
                        <input type="text" class="input" name="contact" required>
                    </div>
                    <div class="inputfield">
                        <label>Location</label>
                        <div class="custom_select">
                            <select name="location" required>
                                <option value="">Select Location</option>
                                <?php
                                // Populate the location options
                                if ($locationsResult && mysqli_num_rows($locationsResult) > 0) {
                                    while ($location = mysqli_fetch_assoc($locationsResult)) {
                                        echo "<option value='".$location['location_id']."'>".$location['location_name']."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="inputfield">
                        <label>Type</label>
                        <div class="custom_select">
                            <select name="type" required>
                                <option value="">Select Complaint Type</option>
                                <?php
                                // Populate the complaint type options
                                if ($typesResult && mysqli_num_rows($typesResult) > 0) {
                                    while ($type = mysqli_fetch_assoc($typesResult)) {
                                        echo "<option value='".$type['type_id']."'>".$type['type']."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="inputfield">
                        <label>Date</label>
                        <input type="date" class="input" name="date" required>
                    </div>
                    <div class="inputfield">
                        <label>Description of Issue</label>
                        <textarea name="issue" class="textarea" required></textarea>
                    </div>
                    <div class="inputfield">
                        <label>Serial</label>
                        <input type="text" class="input" name="serial">
                    </div>
                    <div class="inputfield">
                        <label>Upload Image</label>
                        <input type="file" class="input" name="image" accept="image/*">
                    </div>
                    <div class="inputfield">
                        <input type="submit" name="submit_complaint" value="Submit Complaint" class="btn">
                    </div>
                </form>
            </div>
        </div><br><br>
    </main>
</div>

<script src="index.js"></script>

</body>
</html>
