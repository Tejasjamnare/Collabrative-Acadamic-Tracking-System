<?php
include 'db_connect.php'; // Ensure this file exists and has the correct database connection settings

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $action_type = $_POST['action_type'];
    $details = $_POST['details'];

    if (empty($student_id) || empty($action_type) || empty($details)) {
        die("All fields are required.");
    }

    switch ($action_type) {
        case "update_attendance":
            $query = "INSERT INTO attendance (student_id, date, status) VALUES (?, NOW(), ?)";
            break;
        case "update_marks":
            $query = "INSERT INTO marks (student_id, subject, marks_obtained, total_marks, exam_type) VALUES (?, ?, ?, ?, ?)";
            break;
        case "update_activities":
            $query = "INSERT INTO activities (student_id, details) VALUES (?, ?)";
            break;
        case "update_assignments":
            $query = "INSERT INTO assignments (student_id, details) VALUES (?, ?)";
            break;
        case "update_improvement":
            $query = "INSERT INTO improvement_areas (student_id, details) VALUES (?, ?)";
            break;
        case "send_sms":
            $query = "INSERT INTO sms_logs (student_id, message) VALUES (?, ?)";
            break;
        case "gate_pass":
            $query = "INSERT INTO gate_pass (student_id, reason, status) VALUES (?, ?, 'Pending')";
            break;
        default:
            die("Invalid action type.");
    }

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters dynamically based on action type
    switch ($action_type) {
        case "update_attendance":
            $stmt->bind_param("is", $student_id, $details);
            break;
        case "update_marks":
            list($subject, $marks_obtained, $total_marks, $exam_type) = explode(',', $details);
            $stmt->bind_param("isiii", $student_id, $subject, $marks_obtained, $total_marks, $exam_type);
            break;
        case "update_activities":
        case "update_assignments":
        case "update_improvement":
        case "send_sms":
            $stmt->bind_param("is", $student_id, $details);
            break;
        case "gate_pass":
            $stmt->bind_param("is", $student_id, $details);
            break;
    }

    if ($stmt->execute()) {
        echo "Record updated successfully!";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
