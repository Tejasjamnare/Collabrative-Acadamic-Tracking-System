<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education Platform</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Welcome to the Education Platform</h2>
    <div>
        <a href="login.php?role=faculty">Faculty Login</a>
        <a href="login.php?role=student">Student Login</a>
        <a href="login.php?role=parent">Parent Login</a>
    </div>
</body>
</html>
