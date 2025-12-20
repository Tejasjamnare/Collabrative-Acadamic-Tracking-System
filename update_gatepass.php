<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pass_id = $_POST["pass_id"];
    $status = $_POST["status"];

    $query = "UPDATE gate_pass SET status=? WHERE pass_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $pass_id);

    if ($stmt->execute()) {
        echo "Gate pass status updated successfully.";
        header("Location: faculty_dashboard.php");
    } else {
        echo "Error updating status: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
