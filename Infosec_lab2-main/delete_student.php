<?php
session_start();
require_once("db.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if(!$id){
        die("Invalid ID");
    }

    $stmt = $conn->prepare("DELETE FROM students WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: dashboard.php");
    exit();
}
?>