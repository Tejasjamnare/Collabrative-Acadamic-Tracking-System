<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query_id = $_POST["query_id"];

    $query = "UPDATE student_queries SET status='Resolved' WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $query_id);

    if ($stmt->execute()) {
        echo "<script>alert('Query resolved successfully!'); window.location.href='view_queries.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
