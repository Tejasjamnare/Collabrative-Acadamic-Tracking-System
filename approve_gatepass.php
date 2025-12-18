<?php
include 'db_config.php';

if (isset($_GET['id'])) {
    $pass_id = $_GET['id'];
    $sql = "UPDATE gate_pass SET status = 'Approved' WHERE pass_id = '$pass_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('approved successfully!'); window.location.href='faculty_dashboard.html';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
