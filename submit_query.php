<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = intval($_POST['student_id']);  // student_id must be passed via POST
    $query_text = trim($_POST['query_text']);

    if (!empty($student_id) && !empty($query_text)) {
        $query = "INSERT INTO student_queries (student_id, query_text, status) VALUES (?, ?, 'Pending')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $student_id, $query_text);

        if ($stmt->execute()) {
            echo "<script>alert('Query submitted   Successfully!'); window.location.href='student_dashboard.html';</script>";
        } else {
            echo json_encode(["message" => "Error: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["message" => "Student ID and query text are required."]);
    }
}

$conn->close();
?>
