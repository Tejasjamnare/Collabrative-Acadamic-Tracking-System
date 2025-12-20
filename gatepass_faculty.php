<?php
session_start();
include 'db_config.php';

$query = "SELECT * FROM gate_pass WHERE status = 'Pending'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gate Pass Requests</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; }
        .container { width: 70%; margin: auto; padding: 20px; background: white; border-radius: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        .approve { background: green; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; }
        .reject { background: red; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pending Gate Pass Requests</h2>
        <table>
            <tr>
                <th>Pass ID</th>
                <th>Student ID</th>
                <th>Reason</th>
                <th>Issue Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['pass_id']; ?></td>
                <td><?php echo $row['student_id']; ?></td>
                <td><?php echo $row['reason']; ?></td>
                <td><?php echo $row['issue_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <a href="approve_gatepass.php?id=<?php echo $row['pass_id']; ?>" class="approve">Approve</a>
                    <a href="reject_gatepass.php?id=<?php echo $row['pass_id']; ?>" class="reject">Reject</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>

<?php $conn->close(); ?>
