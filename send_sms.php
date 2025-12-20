<?php
include 'db_config.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST["student_id"];
    $message = $_POST["message"];

    // Check if student exists in the "students" table
    $check_student = "SELECT * FROM students WHERE student_id = ?";
    $stmt_check_student = $conn->prepare($check_student);
    $stmt_check_student->bind_param("i", $student_id);
    $stmt_check_student->execute();
    $result_student = $stmt_check_student->get_result();

    if ($result_student->num_rows == 0) {
        die("<script>alert('Error: Student ID not found!'); window.location.href='send_sms.html';</script>");
    }

    // Insert SMS notification into the database
    $sql = "INSERT INTO sms_notifications (student_id, message, sent_at) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $student_id, $message);

    if ($stmt->execute()) {
        echo "<script>alert('SMS notification sent successfully!'); window.location.href='faculty_dashboard.html';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    // Close connections
    $stmt->close();
    $stmt_check_student->close();
    $conn->close();
}
?>
