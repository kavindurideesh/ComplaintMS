<<<<<<< HEAD
<?php
session_start();
include("../connection.php");

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];
$issue_id = $_POST['issue_id'];
$action = $_POST['action']; // 'add' or 'remove'

// Validate issue_id and action
if (!isset($issue_id) || !isset($action)) {
    die("Invalid issue or action.");
}

// Process based on the action
if ($action == 'add') {
    // Increment upvote count for the issue in the complaints table
    $query = "UPDATE complaints SET up_count = up_count + 1 WHERE issue_id = '$issue_id'";
    if (!mysqli_query($con, $query)) {
        die("Error updating upvote count: " . mysqli_error($con));
    }

    // Insert a new vote into the votes table
    $query = "INSERT INTO votes (user_id, issue_id) VALUES ('$user_id', '$issue_id')";
    if (!mysqli_query($con, $query)) {
        die("Error inserting vote: " . mysqli_error($con));
    }

    // Return success
    echo "added";
} elseif ($action == 'remove') {
    // Decrement upvote count for the issue in the complaints table
    $query = "UPDATE complaints SET up_count = up_count - 1 WHERE issue_id = '$issue_id'";
    if (!mysqli_query($con, $query)) {
        die("Error updating upvote count: " . mysqli_error($con));
    }

    // Remove the vote from the votes table
    $query = "DELETE FROM votes WHERE user_id = '$user_id' AND issue_id = '$issue_id'";
    if (!mysqli_query($con, $query)) {
        die("Error deleting vote: " . mysqli_error($con));
    }

    // Return success
    echo "removed";
} else {
    die("Invalid action.");
}
?>
=======
<?php
session_start();
include("../connection.php");

if (isset($_POST['issue_id'])) {
    $issue_id = $_POST['issue_id'];

    // Increment the up_count for the given complaint
    $query = "UPDATE complaints SET up_count = up_count + 1 WHERE issue_id = $issue_id";
    if (mysqli_query($con, $query)) {
        echo "Success";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
>>>>>>> 94db9d7 (create admin user types and update database to have admin user types table)
