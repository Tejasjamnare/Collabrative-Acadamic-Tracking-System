<?php
include 'db_config.php';

$student_id = 1; // Fetch dynamically
$reason = $_POST['reason'];

$query = "INSERT INTO gate_pass (student_id, reason, status) VALUES ('$student_id', '$reason', 'Pending')";
if ($conn->query($query)) {
    echo "Gate pass request submitted!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
