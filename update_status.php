<?php
include 'db_config.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $assignment_id = intval($_GET['id']);
    $status = $_GET['status'];

    if (!in_array($status, ['Completed', 'Pending'])) {
        die("Invalid status value.");
    }

    $query = "UPDATE assignments SET status = ? WHERE assignment_id = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("si", $status, $assignment_id);
        if ($stmt->execute()) {
            echo "<script>alert('Assignment status updated successfully!'); window.location.href='view_assignments.php';</script>";
        } else {
            echo "<script>alert('Failed to update status.'); window.location.href='view_assignments.php';</script>";
        }
        $stmt->close();
    } else {
        die("Database error: " . $conn->error);
    }
}

$conn->close();
?>
