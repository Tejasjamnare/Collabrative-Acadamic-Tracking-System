<?php 
include 'db_config.php';

$query = "SELECT q.query_id, s.name AS student_name, q.query_text, q.status, q.response 
          FROM student_queries q 
          JOIN students s ON q.student_id = s.student_id";

$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Student Queries</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            width: 90%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .btn {
            padding: 5px 10px;
            background: #28a745;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Student Queries</h2>
    <table>
        <tr>
            <th>Student Name</th>
            <th>Query</th>
            <th>Status</th>
            <th>Response</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row["student_name"]); ?></td>
                <td><?php echo htmlspecialchars($row["query_text"]); ?></td>
                <td><?php echo $row["status"]; ?></td>
                <td><?php echo $row["response"] ? htmlspecialchars($row["response"]) : "No response yet"; ?></td>
                <td><a class="btn" href="respond_query.php?query_id=<?php echo $row['query_id']; ?>">Respond</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>

<?php $conn->close(); ?>
