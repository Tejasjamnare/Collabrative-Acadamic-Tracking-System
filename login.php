<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $valid_users = [
        'student' => 'pass',
        'faculty' => 'pass',
        'parent'  => 'pass'
    ];

    if (isset($valid_users[$role]) && $valid_users[$role] === $password) {
        $_SESSION['role'] = $role;
        $_SESSION['username'] = $username;

        // Redirect based on role
        if ($role === 'student') {
            header("Location: student_dashboard.html");
        } elseif ($role === 'faculty') {
            header("Location: faculty_dashboard.html");
        } elseif ($role === 'parent') {
            header("Location: parent_dashboard.html");
        }
        exit();
    } else {
        echo "<script>alert('Invalid Credentials!'); window.location.href='login.html?role=$role';</script>";
    }
} else {
    header("Location: index.html");
    exit();
}
?>
