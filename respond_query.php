<?php
include 'db_config.php';

if (!isset($_GET['query_id'])) {
    die("Query ID missing.");
}

$query_id = intval($_GET['query_id']);

$query = "SELECT q.query_text, s.name AS student_name FROM student_queries q 
          JOIN students s ON q.student_id = s.student_id 
          WHERE q.query_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $query_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Query not found.");
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Respond to Query</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
        }
        form {
            display: inline-block;
            margin-top: 50px;
        }
        textarea {
            width: 300px;
            height: 100px;
        }
        .btn {
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            margin-top: 10px;
            cursor: pointer;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Respond to Query from <?php echo htmlspecialchars($row['student_name']); ?></h2>
    <p><strong>Query:</strong> <?php echo htmlspecialchars($row['query_text']); ?></p>
    <form action="process_response.php" method="POST">
        <input type="hidden" name="query_id" value="<?php echo $query_id; ?>">
        <textarea name="response_text" required placeholder="Write your response..."></textarea><br>
        <button class="btn" type="submit">Submit Response</button>
    </form>
</body>
</html>
