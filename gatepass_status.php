<?php
include 'db_connect.php'; // Make sure to include your database connection file

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    
    $query = "SELECT status FROM gate_pass WHERE student_id = '$student_id' ORDER BY request_date DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['status'];
    } else {
        echo "No request found";
    }
} else {
    echo "Invalid Request";
}
?>
