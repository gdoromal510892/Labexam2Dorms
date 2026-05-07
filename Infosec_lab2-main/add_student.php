<?php
session_start();
require_once("db.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['add'])){

    $student_id = trim($_POST['student_id']);
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    $course_description = trim($_POST['course_description']);

    if(empty($student_id) || empty($fullname) || empty($email)){
        die("Required fields missing.");
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        die("Invalid email format.");
    }

    // CHECK DUPLICATE
    $check = $conn->prepare("SELECT student_id FROM students WHERE student_id=?");
    $check->bind_param("s", $student_id);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0){
        die("Student ID already exists!");
    }

    // INSERT
    $stmt = $conn->prepare("
        INSERT INTO students (student_id, fullname, email, course, course_description)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("sssss", $student_id, $fullname, $email, $course, $course_description);
    $stmt->execute();

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Student</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h2>Add Student</h2>

<form method="POST">
    <input type="text" name="student_id" placeholder="Student ID" required>
    <input type="text" name="fullname" placeholder="Full Name" required>
    <input type="text" name="email" placeholder="Email" required>
    <input type="text" name="course" placeholder="Course" required>
    <input type="text" name="course_description" placeholder="Course Description">
    <button name="add">Add Student</button>
</form>

</div>

</body>
</html>