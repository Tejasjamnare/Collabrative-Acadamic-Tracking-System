<?php
include 'db_connect.php'; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST["student_id"];
    $subject = $_POST["subject"];
    $marks_obtained = $_POST["marks_obtained"];
    $total_marks = $_POST["total_marks"];
    $exam_type = $_POST["exam_type"];

    // Check if student exists
    $check_student = "SELECT * FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($check_student);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Insert or Update marks
        $sql = "INSERT INTO marks (student_id, subject, marks_obtained, total_marks, exam_type) 
                VALUES (?, ?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE 
                marks_obtained = VALUES(marks_obtained), 
                total_marks = VALUES(total_marks), 
                exam_type = VALUES(exam_type)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isdds", $student_id, $subject, $marks_obtained, $total_marks, $exam_type);

        if ($stmt->execute()) {
            echo "<script>alert('Marks Updated successfully!'); window.location.href='faculty_dashboard.html';</script>";
        } else {
            echo "Error updating marks: " . $conn->error;
        }
    } else {
        echo "Error: Student ID not found!";
    }

    $stmt->close();
    $conn->close();
}
?>
