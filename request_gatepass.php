<?php
session_start();
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["student_id"]) || !isset($_POST["reason"])) {
        die("Error: Missing student_id or reason.");
    }

    $student_id = intval($_POST["student_id"]);  // Ensure integer
    $reason = trim($_POST["reason"]);

    // Check if student exists in the students table
    $check_student = $conn->prepare("SELECT student_id FROM students WHERE student_id = ?");
    $check_student->bind_param("i", $student_id);
    $check_student->execute();
    $result = $check_student->get_result();

    if ($result->num_rows == 0) {
        die("Error: Student ID does not exist.");
    }

    // Insert into gate_pass table
    $stmt = $conn->prepare("INSERT INTO gate_pass (student_id, reason, status) VALUES (?, ?, 'Pending')");
    $stmt->bind_param("is", $student_id, $reason);

    if ($stmt->execute()) {
        echo "<script>alert('Gatepass Requested  successfully!'); window.location.href='student_dashboard.html';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
