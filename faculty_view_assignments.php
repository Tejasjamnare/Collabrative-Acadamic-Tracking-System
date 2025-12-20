<?php
include 'db_config.php'; // database connection

// Handle update on form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $assignment_id = intval($_POST['id']); // use 'id' column
    $update_query = "UPDATE assignments SET status = 'Completed' WHERE id = $assignment_id";
    if ($conn->query($update_query)) {
        echo "<script>alert('Assignment marked as completed.');</script>";
    } else {
        echo "Error updating assignment: " . $conn->error;
    }
}

// Fetch all assignments
$sql = "SELECT id, student_id, subject, title, due_date, file_path, status FROM assignments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty - Mark Assignments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f3;
            padding: 20px;
            text-align: center;
        }
        table {
            width: 95%;
            margin: auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
        }
        th {
            background: #007bff;
            color: #fff;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        form {
            display: inline;
        }
        .btn {
            padding: 6px 12px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn[disabled] {
            background: gray;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<h2>Faculty - Assignment Review</h2>

<table>
    <tr>
        <th>Student ID</th>
        <th>Subject</th>
        <th>Title</th>
        <th>Due Date</th>
        <th>Submitted File</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $link = $row['file_path'] ? "<a href='{$row['file_path']}' target='_blank'>View</a>" : "Not Submitted";
            echo "<tr>
                <td>{$row['student_id']}</td>
                <td>{$row['subject']}</td>
                <td>{$row['title']}</td>
                <td>{$row['due_date']}</td>
                <td>$link</td>
                <td>{$row['status']}</td>
                <td>";
            if ($row['status'] !== 'Completed') {
                echo "<form method='POST'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button class='btn' type='submit'>Mark Completed</button>
                      </form>";
            } else {
                echo "<button class='btn' disabled>Completed</button>";
            }
            echo "</td></tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No assignments found.</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php $conn->close(); ?>
