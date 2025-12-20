<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['student_id'])) {
    die("Error: Student not logged in!");
}

$student_id = $_SESSION['student_id'];

$query = "SELECT status, request_time FROM gate_pass WHERE student_id = '$student_id' ORDER BY request_time DESC LIMIT 1";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css"> 
</head>
<body>
    <div class="container">
        <h2>Student Dashboard</h2>

        <div>
            <a href="update_queries.html" class="btn">Update Queries</a>
            <a href="submit_assignment.html" class="btn">Submit Assignment</a>
            <a href="gatepass_student.html" class="btn">Request Gate Pass</a>
        </div>

        <h3>Gate Pass Status</h3>
        <div class="status-box">
            <?php 
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo "<p>Latest Request: " . $row['request_time'] . "</p>";
                echo "<p>Status: <strong>" . strtoupper($row['status']) . "</strong></p>";
            } else {
                echo "<p>No gate pass request found.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
