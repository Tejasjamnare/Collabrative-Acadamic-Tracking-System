<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "education_platform";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = false;
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST["student_id"];
    $name = $_POST["name"];

    // Insert into database
    $sql = "INSERT INTO students (student_id, name) VALUES ('$student_id', '$name')";

    if ($conn->query($sql) === TRUE) {
        $success = true;
    } else {
        $error = "Error: " . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add Student</h2>
        <form action="add_student.php" method="post">
            <label for="student_id">Student ID:</label>
            <input type="number" id="student_id" name="student_id" required>

            <label for="name">Student Name:</label>
            <input type="text" id="name" name="name" required>

            <input type="submit" value="Add Student">
        </form>

        <?php if (!empty($error)) : ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>

    <?php if ($success) : ?>
        <script>
            alert("Student added successfully!"); window.location.href='faculty_dashboard.html'
        </script>
    <?php endif; ?>
</body>
</html>
