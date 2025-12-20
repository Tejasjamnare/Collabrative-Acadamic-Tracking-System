<?php
include 'db_config.php';

$student_id = 1; // Fetch dynamically in a real system

$query = "SELECT subject, marks_obtained, total_marks, exam_type FROM marks WHERE student_id = $student_id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Marks</title>
</head>
<body>
    <h2>Your Marks</h2>
    <table border="1">
        <tr>
            <th>Subject</th>
            <th>Marks Obtained</th>
            <th>Total Marks</th>
            <th>Exam Type</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['subject']; ?></td>
                <td><?= $row['marks_obtained']; ?></td>
                <td><?= $row['total_marks']; ?></td>
                <td><?= $row['exam_type']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
