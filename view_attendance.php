<?php
include 'db_config.php';

$student_id = 1; // Fetch dynamically in a real system

$query = "SELECT date, status FROM attendance WHERE student_id = $student_id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Attendance</title>
</head>
<body>
    <h2>Your Attendance</h2>
    <table border="1">
        <tr>
            <th>Date</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['date']; ?></td>
                <td><?= $row['status']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
