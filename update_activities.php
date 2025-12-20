<?php
include 'db_connect.php';  // Ensure the database connection file is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $activity_name = $_POST['activity_name'];
    $activity_date = $_POST['activity_date'];
    $description = $_POST['description'];

    // Check if student exists in the database
    $check_student = "SELECT * FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($check_student);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "Error: Student ID not found!";
        exit();
    }

    // Insert or update activity record
    $sql = "INSERT INTO activities (student_id, activity_name, activity_date, description) 
            VALUES (?, ?, ?, ?) 
            ON DUPLICATE KEY UPDATE activity_name = VALUES(activity_name), description = VALUES(description)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $student_id, $activity_name, $activity_date, $description);

    if ($stmt->execute()) {
        echo "Activities updated successfully";
    } else {
        echo "Error updating activities: " . $conn->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>
