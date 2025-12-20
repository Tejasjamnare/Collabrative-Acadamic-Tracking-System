<?php
include 'db_config.php';

// Fetch pending gate pass requests
$query = "SELECT * FROM gate_pass WHERE status='Pending'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Gate Pass</title>
</head>
<body>
    <h2>Pending Gate Pass Requests</h2>

    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>Pass ID</th>
                <th>Student ID</th>
                <th>Reason</th>
                <th>Issue Date</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["pass_id"]; ?></td>
                    <td><?php echo $row["student_id"]; ?></td>
                    <td><?php echo $row["reason"]; ?></td>
                    <td><?php echo $row["issue_date"]; ?></td>
                    <td>
                        <form action="update_gatepass.php" method="post">
                            <input type="hidden" name="pass_id" value="<?php echo $row['pass_id']; ?>">
                            <select name="status">
                                <option value="Approved">Approve</option>
                                <option value="Rejected">Reject</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No pending requests.</p>
    <?php endif; ?>

    <?php
    $conn->close();
    ?>
</body>
</html>
