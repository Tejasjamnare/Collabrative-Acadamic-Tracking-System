<?php
include 'db_config.php'; // Ensure this file contains correct DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'] ?? null;

    if (!$student_id) {
        die("Error: Student ID is required.");
    }

    // Fetch student activities
    $activities_query = "SELECT * FROM activities WHERE student_id = '$student_id'";
    $activities_result = $conn->query($activities_query);

    if ($activities_result->num_rows > 0) {
        echo "<h2>Activities for Student ID: $student_id</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Activity Name</th>
                    <th>Date</th>
                    <th>Description</th>
                </tr>";
        
        while ($row = $activities_result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['activity_name']}</td>
                    <td>{$row['activity_date']}</td>
                    <td>{$row['description']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<h2>No activities found for Student ID: $student_id</h2>";
    }
}

$conn->close();
?>
