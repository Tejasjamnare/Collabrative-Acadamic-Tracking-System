<?php
$conn = new mysqli("localhost", "root", "", "education_platform");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_POST['student_id'];
$subject = $_POST['subject'];
$title = $_POST['title'];

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["assignment_file"]["name"]);

if (move_uploaded_file($_FILES["assignment_file"]["tmp_name"], $target_file)) {
    $sql = "UPDATE assignments SET file_path='$target_file', status='Completed'
            WHERE student_id='$student_id' AND subject='$subject' AND title='$title'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Assignment Submitted  Successfully!'); window.location.href='student_dashboard.html';</script>";
    } else {
        echo "Error updating assignment: " . $conn->error;
    }
} else {
    echo "File upload failed.";
}

$conn->close();
?>
