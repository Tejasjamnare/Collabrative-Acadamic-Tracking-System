<?php
include 'db_config.php'; // Ensure correct DB connection

// Get Student ID from the parent input (Assuming Parent enters Student ID)
$student_id = $_POST['student_id'] ?? null;

if (!$student_id) {
    die("Error: Student ID is required.");
}

// Fetch Student Name
$student_name_stmt = $conn->prepare("SELECT name FROM students WHERE student_id = ?");
$student_name_stmt->bind_param("i", $student_id);
$student_name_stmt->execute();
$student_name_result = $student_name_stmt->get_result();
$student_name = ($student_name_result->num_rows > 0) ? $student_name_result->fetch_assoc()['name'] : "Unknown";
$student_name_stmt->close();

// Attendance
$attendance_stmt = $conn->prepare("SELECT date, status FROM attendance WHERE student_id = ?");
$attendance_stmt->bind_param("i", $student_id);
$attendance_stmt->execute();
$attendance_result = $attendance_stmt->get_result();

// Marks
$marks_stmt = $conn->prepare("SELECT subject, marks_obtained, total_marks, exam_type FROM marks WHERE student_id = ?");
$marks_stmt->bind_param("i", $student_id);
$marks_stmt->execute();
$marks_result = $marks_stmt->get_result();

// Assignments
$assignment_query = "SELECT subject, due_date, status, file_path FROM assignments WHERE student_id = '$student_id'";
$assignment_result = $conn->query($assignment_query);

// Activities
$activity_stmt = $conn->prepare("SELECT activity_name, activity_date, description FROM activities WHERE student_id = ?");
$activity_stmt->bind_param("i", $student_id);
$activity_stmt->execute();
$activity_result = $activity_stmt->get_result();

// Improvement Areas
$improvement_stmt = $conn->prepare("SELECT improvement_area FROM improvements WHERE student_id = ?");
$improvement_stmt->bind_param("i", $student_id);
$improvement_stmt->execute();
$improvement_result = $improvement_stmt->get_result();


// Gate Pass
$gatepass_stmt = $conn->prepare("SELECT reason, issue_date, status FROM gate_pass WHERE student_id = ?");
$gatepass_stmt->bind_param("i", $student_id);
$gatepass_stmt->execute();
$gatepass_result = $gatepass_stmt->get_result();

// SMS Notifications
$sms_stmt = $conn->prepare("SELECT message, sent_at FROM sms_notifications WHERE student_id = ?");
$sms_stmt->bind_param("i", $student_id);
$sms_stmt->execute();
$sms_result = $sms_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Parent Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
            text-align: center;
        }
        .container {
            background: white;
            padding: 20px;
            width: 90%;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        h2 { color: #007bff; }
        h3 {
            background: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0 30px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:nth-child(even) { background: #f9f9f9; }
        .no-data {
            text-align: center;
            font-style: italic;
            color: #888;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container" id="report">
    <h2>Parent Dashboard</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($student_name); ?></p>
    <p><strong>Student ID:</strong> <?php echo htmlspecialchars($student_id); ?></p>

    <h3>Attendance Records</h3>
    <table>
        <tr><th>Date</th><th>Status</th></tr>
        <?php if ($attendance_result->num_rows > 0) {
            while ($row = $attendance_result->fetch_assoc()) {
                echo "<tr><td>{$row['date']}</td><td>{$row['status']}</td></tr>";
            }
        } else {
            echo "<tr><td colspan='2' class='no-data'>No attendance records found.</td></tr>";
        } ?>
    </table>

    <h3>Marks</h3>
    <table>
        <tr><th>Subject</th><th>Marks Obtained</th><th>Total Marks</th><th>Exam Type</th></tr>
        <?php if ($marks_result->num_rows > 0) {
            while ($row = $marks_result->fetch_assoc()) {
                echo "<tr><td>{$row['subject']}</td><td>{$row['marks_obtained']}</td><td>{$row['total_marks']}</td><td>{$row['exam_type']}</td></tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='no-data'>No marks records found.</td></tr>";
        } ?>
    </table>

    <h3>Assignment Status</h3>
    <table>
        <tr><th>Subject</th><th>Due Date</th><th>Status</th><th>Submitted File</th></tr>
        <?php if ($assignment_result && $assignment_result->num_rows > 0) {
            while ($row = $assignment_result->fetch_assoc()) {
                $due_date = $row['due_date'] == '0000-00-00' ? "Not Set" : $row['due_date'];
                $file_link = $row['file_path'] ? "View File" : "Not Uploaded";
                echo "<tr>
                    <td>{$row['subject']}</td>
                    <td>{$due_date}</td>
                    <td>{$row['status']}</td>
                    <td>{$file_link}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='no-data'>No assignment records found.</td></tr>";
        } ?>
    </table>

    <h3>Student Activities</h3>
    <table>
        <tr><th>Activity Name</th><th>Date</th><th>Description</th></tr>
        <?php if ($activity_result->num_rows > 0) {
            while ($row = $activity_result->fetch_assoc()) {
                echo "<tr><td>{$row['activity_name']}</td><td>{$row['activity_date']}</td><td>{$row['description']}</td></tr>";
            }
        } else {
            echo "<tr><td colspan='3' class='no-data'>No activities found.</td></tr>";
        } ?>
    </table>


    <h3>Improvement Areas</h3>
<table>
    <tr><th>Improvement Area</th></tr>
    <?php
    if ($improvement_result->num_rows > 0) {
        while ($row = $improvement_result->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($row['improvement_area']) . "</td></tr>";
        }
    } else {
        echo "<tr><td class='no-data'>No improvement areas recorded.</td></tr>";
    }
    ?>
</table>


    <h3>Gate Pass Requests</h3>
    <table>
        <tr><th>Reason</th><th>Issue Date</th><th>Status</th></tr>
        <?php if ($gatepass_result->num_rows > 0) {
            while ($row = $gatepass_result->fetch_assoc()) {
                echo "<tr><td>{$row['reason']}</td><td>{$row['issue_date']}</td><td>{$row['status']}</td></tr>";
            }
        } else {
            echo "<tr><td colspan='3' class='no-data'>No gate pass requests found.</td></tr>";
        } ?>
    </table>

    <h3>SMS Notifications</h3>
    <table>
        <tr><th>Message</th><th>Sent At</th></tr>
        <?php if ($sms_result->num_rows > 0) {
            while ($row = $sms_result->fetch_assoc()) {
                echo "<tr><td>{$row['message']}</td><td>{$row['sent_at']}</td></tr>";
            }
        } else {
            echo "<tr><td colspan='2' class='no-data'>No SMS notifications found.</td></tr>";
        } ?>
    </table>
</div>

<!-- Download Button -->
<button onclick="downloadPDF()">Download Report as PDF</button>

<!-- HTML2PDF JS Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script>
    function downloadPDF() {
        const element = document.getElementById('report');
        const opt = {
            margin: 0.3,
            filename: 'Student_Report_<?php echo $student_id; ?>.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>

</body>
</html>

<?php $conn->close(); ?>
