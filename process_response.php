<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query_id = $_POST['query_id'];
    $response_text = trim($_POST['response_text']);

    $query = "UPDATE student_queries SET response = ?, status = 'Resolved' WHERE query_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $response_text, $query_id);

    if ($stmt->execute()) {
        echo "<script>alert('Response submitted successfully!'); window.location.href='faculty_dashboard.html';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

$conn->close();
?>
