<?php
include "../connection.php";

$query = "SELECT location_name FROM location"; // Replace 'your_table_name' with your actual table name for locations
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $locations = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $locations[] = $row['location_name'];
    }
    
    // Send the locations as JSON response
    echo json_encode($locations);
} else {
    echo json_encode(array()); // No locations found
}




?>
