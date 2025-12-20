<?php
session_start();
if (!isset($_SESSION['faculty_id'])) {
    header("Location: faculty_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            width: 60%;
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h2 {
            color: #333;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 10px;
            text-decoration: none;
            background: #007bff;
            color: white;
            font-size: 18px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Faculty Dashboard</h2>
        <a href="upa.html" class="btn">Update Attendance</a>
        <a href="update_marks.html" class="btn">Update Marks</a>
        <a href="update_activities.html" class="btn">Update Activities</a>
        <a href="update_assignments.html" class="btn">Update Assignments</a>
        <a href="update_improvement.html" class="btn">Update Improvement Areas</a>
        <a href="send_sms.html" class="btn">Send SMS</a>
        <a href="gatepass_faculty.html" class="btn">Gate Pass</a>
        <a href="faculty_view_assignments.php" class="btn">View Submitted Assignments</a>
        <a href="add_student.php" class="btn">Add Student</a>



    </div>
</body>
</html>
