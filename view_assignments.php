<?php
include 'db_config.php';

// Fetch submitted assignments
$query = "SELECT assignment_id, student_id, subject, file_name, file_path, status FROM assignments WHERE status IN ('Pending', 'Completed')";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching assignments: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Submitted Assignments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #007bff;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        th {
            background: #007bff;
            color: white;
        }
        td a {
            text-decoration: none;
            color: #28a745;
            font-weight: bold;
        }
        td a:hover {
            color: #218838;
        }
        .status-btn {
            background: #ffc107;
            color: black;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .status-btn:hover {
            background: #e0a800;
        }
        .completed {
            background: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .no-data {
            margin-top: 20px;
            font-size: 18px;
            color: #d9534f;
        }
    </style>
</head>
<body>
    <h2>Submitted Assignments</h2>

    <?php if ($result->num_rows > 0) { ?>
        <table>
            <tr>
                <th>Assignment ID</th>
                <th>Student ID</th>
                <th>Subject</th>
                <th>File</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['assignment_id']); ?></td>
                    <td><?= htmlspecialchars($row['student_id']); ?></td>
                    <td><?= htmlspecialchars($row['subject']); ?></td>
                    <td>
                        <?php if (!empty($row['file_path'])) { ?>
                            <a href="<?= htmlspecialchars($row['file_path']); ?>" download><?= htmlspecialchars($row['file_name']); ?></a>
                        <?php } else { ?>
                            <span style="color: red;">No file uploaded</span>
                        <?php } ?>
                    </td>
                    <td>
                        <span class="<?= ($row['status'] == 'Completed') ? 'completed' : ''; ?>">
                            <?= htmlspecialchars($row['status']); ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($row['status'] == 'Pending') { ?>
                            <a href="update_status.php?id=<?= $row['assignment_id']; ?>&status=Completed" class="status-btn">Mark as Completed</a>
                        <?php } else { ?>
                            <span class="completed">Completed</span>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p class="no-data">No submitted assignments found.</p>
    <?php } ?>

    <?php $conn->close(); ?>
</body>
</html>
