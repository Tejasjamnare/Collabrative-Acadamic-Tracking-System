<?php
include 'db_config.php';

// Get Student ID from POST data
$student_id = $_POST['student_id'] ?? null;

if (!$student_id) {
    die("Error: Student ID is required.");
}

// Fetch Student Name
$student_name_query = "SELECT name FROM students WHERE student_id = '$student_id'";
$student_name_stmt = $conn->prepare("SELECT name FROM students WHERE student_id = ?");
$student_name_stmt->bind_param("i", $student_id);
$student_name_stmt->execute();
$student_name_result = $student_name_stmt->get_result();
$student_name = ($student_name_result->num_rows > 0) ? $student_name_result->fetch_assoc()['name'] : "Unknown";
$student_name_stmt->close();

// Fetch Attendance Data
$attendance_stmt = $conn->prepare("SELECT date, status FROM attendance WHERE student_id = ?");
$attendance_stmt->bind_param("i", $student_id);
$attendance_stmt->execute();
$attendance_result = $attendance_stmt->get_result();

// Fetch Marks Data
$marks_stmt = $conn->prepare("SELECT subject, marks_obtained, total_marks, exam_type FROM marks WHERE student_id = ?");
$marks_stmt->bind_param("i", $student_id);
$marks_stmt->execute();
$marks_result = $marks_stmt->get_result();

// Fetch Assignment Status
$assignment_query = "SELECT subject, due_date, status, file_path FROM assignments WHERE student_id = '$student_id'";
$assignment_result = $conn->query($assignment_query);

// Fetch Activities
$activity_stmt = $conn->prepare("SELECT activity_name, activity_date, description FROM activities WHERE student_id = ?");
$activity_stmt->bind_param("i", $student_id);
$activity_stmt->execute();
$activity_result = $activity_stmt->get_result();

// Fetch Gate Pass Requests
$gatepass_stmt = $conn->prepare("SELECT reason, issue_date, status FROM gate_pass WHERE student_id = ?");
$gatepass_stmt->bind_param("i", $student_id);
$gatepass_stmt->execute();
$gatepass_result = $gatepass_stmt->get_result();

// Fetch SMS Notifications
$sms_stmt = $conn->prepare("SELECT message, sent_at FROM sms_notifications WHERE student_id = ?");
$sms_stmt->bind_param("i", $student_id);
$sms_stmt->execute();
$sms_result = $sms_stmt->get_result();

// Prepare CSV Data
$output = fopen("php://output", "w");
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="student_dashboard_details.csv"');

// Column headers
fputcsv($output, ["Category", "Details"]);

// Student Information
fputcsv($output, ["Student Name", $student_name]);

// Attendance Data
fputcsv($output, ["Attendance Records"]);
fputcsv($output, ["Date", "Status"]);
while ($row = $attendance_result->fetch_assoc()) {
    fputcsv($output, [$row['date'], $row['status']]);
}

// Marks Data
fputcsv($output, ["Marks Records"]);
fputcsv($output, ["Subject", "Marks Obtained", "Total Marks", "Exam Type"]);
while ($row = $marks_result->fetch_assoc()) {
    fputcsv($output, [$row['subject'], $row['marks_obtained'], $row['total_marks'], $row['exam_type']]);
}

// Assignment Status Data
fputcsv($output, ["Assignment Status"]);
fputcsv($output, ["Subject", "Due Date", "Status", "Submitted File"]);
while ($row = $assignment_result->fetch_assoc()) {
    $file_link = $row['file_path'] ? $row['file_path'] : "Not Uploaded";
    fputcsv($output, [$row['subject'], $row['due_date'], $row['status'], $file_link]);
}

// Activities Data
fputcsv($output, ["Activities"]);
fputcsv($output, ["Activity Name", "Date", "Description"]);
while ($row = $activity_result->fetch_assoc()) {
    fputcsv($output, [$row['activity_name'], $row['activity_date'], $row['description']]);
}

// Gate Pass Requests
fputcsv($output, ["Gate Pass Requests"]);
fputcsv($output, ["Reason", "Issue Date", "Status"]);
while ($row = $gatepass_result->fetch_assoc()) {
    fputcsv($output, [$row['reason'], $row['issue_date'], $row['status']]);
}

// SMS Notifications
fputcsv($output, ["SMS Notifications"]);
fputcsv($output, ["Message", "Sent At"]);
while ($row = $sms_result->fetch_assoc()) {
    fputcsv($output, [$row['message'], $row['sent_at']]);
}

fclose($output);
$conn->close();
exit;
?>
