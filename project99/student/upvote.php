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
