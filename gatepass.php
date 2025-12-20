<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pass_id = $_POST['pass_id'];
    $status = $_POST['status'];

    // Update gate pass status
    $update_query = "UPDATE gate_pass SET status = ? WHERE pass_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $status, $pass_id);

    if ($stmt->execute()) {
        echo "Gate pass status updated successfully!";
    } else {
        echo "Error updating gate pass: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request!";
}
?>
