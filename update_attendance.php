<?php
include 'db_connect.php';  // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST["student_id"];
    $date = $_POST["date"];
    $status = $_POST["status"];

    // Check if attendance record already exists for the given student and date
    $check_query = "SELECT * FROM attendance WHERE student_id = ? AND date = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("is", $student_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing record
        $update_query = "UPDATE attendance SET status = ? WHERE student_id = ? AND date = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sis", $status, $student_id, $date);

        if ($stmt->execute()) {
            echo "Attendance updated successfully!";
        } else {
            echo "Error updating attendance: " . $conn->error;
        }
    } else {
        // Insert new attendance record
        $insert_query = "INSERT INTO attendance (student_id, date, status) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("iss", $student_id, $date, $status);

        if ($stmt->execute()) {
            echo "<script>alert('Attendance Upated  successfully!'); window.location.href='faculty_dashboard.html';</script>";
        } else {
            echo "Error recording attendance: " . $conn->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>
