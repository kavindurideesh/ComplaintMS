<?php
session_start();       // Start the session
session_unset();       // Unset all session variables
session_destroy();     // Destroy the session

if (!isset($_SESSION['user_id'])) {
    echo "Session destroyed successfully.";
} else {
    echo "Session not destroyed.";
}

header("Location: ./login.php");  // Redirect to the login page
exit();
?>
