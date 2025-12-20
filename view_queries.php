<?php 
include 'db_config.php';

// SQL query to fetch student queries
$query = "SELECT q.query_id, s.name AS student_name, q.query_text, q.status, q.response 
          FROM student_queries q 
          JOIN students s ON q.student_id = s.student_id";

// Execute the query and check for errors
$result = $conn->query($query);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . $conn->error); // This will display the specific error message
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Queries</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .btn {
            padding: 5px 10px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
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
                    <td><?php echo $row["student_name"]; ?></td>
                    <td><?php echo $row["query_text"]; ?></td>
                    <td><?php echo $row["status"]; ?></td>
                    <td><?php echo $row["response"] ? $row["response"] : "No response yet"; ?></td>
                    <td>
                        <a href="respond_query.php?query_id=<?php echo $row["query_id"]; ?>" class="btn">Respond</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
