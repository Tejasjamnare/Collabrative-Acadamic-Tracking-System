<?php
$conn = new mysqli("localhost", "root", "", "education_platform");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_POST['student_id'];
$subject = $_POST['subject'];
$title = $_POST['title'];
$description = $_POST['description'];
$due_date = $_POST['due_date'];
$status = $_POST['assignment_status'];

$sql = "INSERT INTO assignments (student_id, subject, title, description, due_date, status)
        VALUES ('$student_id', '$subject', '$title', '$description', '$due_date', '$status')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Assignment Updated successfully!'); window.location.href='faculty_dashboard.html';</script>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
