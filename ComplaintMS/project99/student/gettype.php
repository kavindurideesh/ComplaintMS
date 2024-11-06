<?php
include "../connection.php";


$query = "SELECT type FROM complaint_type"; // Replace 'your_table_name' with your actual table name for locations
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $types = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $types[] = $row['type'];
    }
    
    // Send the locations as JSON response
    echo json_encode($types);
} else {
    echo json_encode(array()); // No locations found
}




?>
