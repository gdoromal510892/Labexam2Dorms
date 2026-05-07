<?php
session_start();
require_once("db.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container" style="width:90%;">

<h2>Dashboard</h2>

<p>Welcome, <b><?php echo htmlspecialchars($_SESSION['user']); ?></b></p>

<a href="add_student.php">+ Add Student</a> |
<a href="logout.php">Logout</a>

<h3>Student List</h3>

<table>
<tr>
    <th>ID</th>
    <th>Student ID</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Course</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo htmlspecialchars($row['student_id']); ?></td>
    <td><?php echo htmlspecialchars($row['fullname']); ?></td>
    <td><?php echo htmlspecialchars($row['email']); ?></td>
    <td><?php echo htmlspecialchars($row['course']); ?></td>
    <td>
        <form method="POST" action="delete_student.php" onsubmit="return confirm('Delete this student?');">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <button class="delete-btn">Delete</button>
        </form>
    </td>
</tr>
<?php } ?>

</table>

</div>

</body>
</html>