<?php
include 'db_config.php'; // Ensure correct DB connection

// Get Student ID from the parent input (Assuming Parent enters Student ID)
$student_id = $_POST['student_id'] ?? null;

if (!$student_id) {
    die("Error: Student ID is required.");
}

// Fetch Student Name
$student_name_query = "SELECT name FROM students WHERE student_id = '$student_id'";
$student_name_result = $conn->query($student_name_query);
$student_name = ($student_name_result && $student_name_result->num_rows > 0) ? $student_name_result->fetch_assoc()['name'] : "Unknown";

// Fetch Attendance Data
$attendance_query = "SELECT date, status FROM attendance WHERE student_id = '$student_id'";
$attendance_result = $conn->query($attendance_query);

// Fetch Marks Data
$marks_query = "SELECT subject, marks_obtained, total_marks, exam_type FROM marks WHERE student_id = '$student_id'";
$marks_result = $conn->query($marks_query);

// Fetch Assignment Status
$assignment_query = "SELECT subject, due_date, status, file_path FROM assignments WHERE student_id = '$student_id'";
$assignment_result = $conn->query($assignment_query);

// Fetch Activities
$activity_query = "SELECT activity_name, activity_date, description FROM activities WHERE student_id = '$student_id'";
$activity_result = $conn->query($activity_query);

// Fetch Gate Pass Requests
$gatepass_query = "SELECT reason, issue_date, status FROM gate_pass WHERE student_id = '$student_id'";
$gatepass_result = $conn->query($gatepass_query);

// Fetch Student Queries and Faculty Responses
$query_response_query = "SELECT query_text, response, status FROM student_queries WHERE student_id = '$student_id'";
$query_response_result = $conn->query($query_response_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data View</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 85%;
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        h2 {
            color: #007bff;
        }
        h3 {
            color: #333;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }
        th {
            background: #007bff;
            color: white;
            padding: 12px;
            font-size: 16px;
            text-transform: uppercase;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        tr:hover {
            background: #ddd;
            transition: 0.3s;
        }
        .no-data {
            text-align: center;
            font-style: italic;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Details</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($student_name); ?></p>
        <p><strong>Student ID:</strong> <?php echo htmlspecialchars($student_id); ?></p>

        <!-- Attendance -->
        <h3>Attendance Records</h3>
        <table>
            <tr><th>Date</th><th>Status</th></tr>
            <?php if ($attendance_result && $attendance_result->num_rows > 0) {
                while ($row = $attendance_result->fetch_assoc()) {
                    echo "<tr><td>{$row['date']}</td><td>{$row['status']}</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2' class='no-data'>No attendance records found.</td></tr>";
            } ?>
        </table>

        <!-- Marks -->
        <h3>Marks</h3>
        <table>
            <tr><th>Subject</th><th>Marks Obtained</th><th>Total Marks</th><th>Exam Type</th></tr>
            <?php if ($marks_result && $marks_result->num_rows > 0) {
                while ($row = $marks_result->fetch_assoc()) {
                    echo "<tr><td>{$row['subject']}</td><td>{$row['marks_obtained']}</td><td>{$row['total_marks']}</td><td>{$row['exam_type']}</td></tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='no-data'>No marks records found.</td></tr>";
            } ?>
        </table>

        <!-- Assignment Status -->
        <h3>Assignment Status</h3>
        <table>
            <tr><th>Subject</th><th>Due Date</th><th>Status</th><th>Submitted File</th></tr>
            <?php 
            if ($assignment_result && $assignment_result->num_rows > 0) {
                while ($row = $assignment_result->fetch_assoc()) {
                    $status_color = '';
                    $status = $row['status'];
                    $due_date = $row['due_date'];
                    $file_link = $row['file_path'] ? "<a href='{$row['file_path']}' target='_blank'>View File</a>" : "Not Uploaded";

                    // Handle invalid or blank due date
                    if ($due_date == '0000-00-00' || empty($due_date)) {
                        $due_date = "Not Set";
                    }

                    // Check if status is available and assign color
                    if (!empty($status)) {
                        if ($status == 'Pending') {
                            $status_color = 'background-color: #f8d7da; color: #721c24;'; // Red for Pending
                        } else if ($status == 'Completed') {
                            $status_color = 'background-color: #d4edda; color: #155724;'; // Green for Completed
                        } else {
                            $status_color = 'background-color: #fff3cd; color: #856404;'; // Yellow for other statuses
                        }
                    } else {
                        $status_color = 'background-color: #e2e3e5; color: #6c757d;'; // Gray for blank or unknown status
                    }

                    // Create the row with status color applied
                    echo "<tr>
                            <td>{$row['subject']}</td>
                            <td>{$due_date}</td>
                            <td style='$status_color'>{$status}</td>
                            <td>$file_link</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='no-data'>No assignment records found.</td></tr>";
            }
            ?>
        </table>

        <!-- Activities -->
        <h3>Student Activities</h3>
        <table>
            <tr><th>Activity Name</th><th>Date</th><th>Description</th></tr>
            <?php if ($activity_result && $activity_result->num_rows > 0) {
                while ($row = $activity_result->fetch_assoc()) {
                    echo "<tr><td>{$row['activity_name']}</td><td>{$row['activity_date']}</td><td>{$row['description']}</td></tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='no-data'>No activities found.</td></tr>";
            } ?>
        </table>

        <!-- Gate Pass Requests -->
        <h3>Gate Pass Requests</h3>
        <table>
            <tr><th>Reason</th><th>Issue Date</th><th>Status</th></tr>
            <?php if ($gatepass_result && $gatepass_result->num_rows > 0) {
                while ($row = $gatepass_result->fetch_assoc()) {
                    echo "<tr><td>{$row['reason']}</td><td>{$row['issue_date']}</td><td>{$row['status']}</td></tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='no-data'>No gate pass requests found.</td></tr>";
            } ?>
        </table>

        <!-- Student Queries and Faculty Responses -->
        <h3>Student Queries & Faculty Responses</h3>
        <table>
            <tr><th>Query</th><th>Faculty Response</th><th>Status</th></tr>
            <?php if ($query_response_result && $query_response_result->num_rows > 0) {
                while ($row = $query_response_result->fetch_assoc()) {
                    echo "<tr><td>{$row['query_text']}</td><td>";
                    echo $row['response'] ? $row['response'] : "No response yet";
                    echo "</td><td>{$row['status']}</td></tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='no-data'>No queries submitted.</td></tr>";
            } ?>
        </table>
    </div>
</body>
</html>

<?php $conn->close(); ?>
