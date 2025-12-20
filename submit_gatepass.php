<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST["student_id"];
    $reason = $_POST["reason"];

    $sql = "INSERT INTO gate_pass (student_id, reason, status) VALUES ('$student_id', '$reason', 'Pending')";

    if ($conn->query($sql) === TRUE) {
        echo "Gate Pass Request Submitted Successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
