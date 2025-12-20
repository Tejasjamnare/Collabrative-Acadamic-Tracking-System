<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure both fields are set before using them
    if (isset($_POST['student_id']) && isset($_POST['improvement'])) {
        $student_id = $_POST['student_id'];
        $improvement = $_POST['improvement'];

        // Check if student exists
        $check_student = "SELECT * FROM students WHERE student_id = ?";
        $stmt = $conn->prepare($check_student);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Insert or Update improvement area
            $sql = "INSERT INTO improvements (student_id, improvement_area) 
                    VALUES (?, ?) 
                    ON DUPLICATE KEY UPDATE improvement_area = VALUES(improvement_area)";
        
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $student_id, $improvement);

            if ($stmt->execute()) {
                echo"<script>alert('ImpovementArea Updated successfully!'); window.location.href='faculty_dashboard.html';</script>";
            } else {
                echo "Error updating improvement area: " . $conn->error;
            }
        } else {
            echo "Error: Student ID not found!";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Error: Missing student_id or improvement field.";
    }
}
?>
