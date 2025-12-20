<?php
include 'db_config.php'; // Ensure database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];

    // Query to fetch assignments for the given student ID
    $query = "SELECT * FROM assignments WHERE student_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Your Assignments:</h2><table border='1'>
                <tr><th>Assignment Title</th><th>Subject</th><th>Due Date</th><th>Status</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['title'] . "</td><td>" . $row['subject'] . "</td><td>" . $row['due_date'] . "</td><td>" . $row['status'] . "</td></tr>";
        }

        echo "</table>";
    } else {
        echo "No assignments found for this student.";
    }

    $stmt->close();
}

$conn->close();
?>
