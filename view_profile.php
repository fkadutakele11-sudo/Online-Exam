<?php
session_start(); // start session
include "db.php"; // your database connection
include "navbar.php"; // optional, include navigation if you have

// Get the logged-in student ID from session
$student_id = $_SESSION['student_id'] ?? null;

// If student is not logged in, show message
if (!$student_id) {
    echo "<p style='text-align:center;color:red; margin-top:50px;'>You are not logged in.</p>";
    exit;
}

// Fetch student information from database
$sql = "SELECT * FROM students WHERE id='$student_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<p style='text-align:center;color:red; margin-top:50px;'>Student not found.</p>";
    exit;
}

$student = $result->fetch_assoc();
?>

<!-- Page Heading -->
<h2 style="text-align:center; color:#2980b9; margin-top:30px;">My Profile</h2>

<!-- Profile Card -->
<div class="card" style="width:500px; margin:30px auto; padding:25px 30px; border-radius:10px; box-shadow: 0 8px 25px rgba(0,0,0,0.15); background:#fff;">
    <table style="width:100%; border-collapse:collapse; font-size:14px;">
        <tr>
            <th style="text-align:left; padding:8px; color:#2980b9;">Field</th>
            <th style="text-align:left; padding:8px; color:#2980b9;">Details</th>
        </tr>
        <tr>
            <td style="padding:8px; font-weight:bold;">Name</td>
            <td style="padding:8px;"><?php echo htmlspecialchars($student['name']); ?></td>
        </tr>
        <tr>
            <td style="padding:8px; font-weight:bold;">Email</td>
            <td style="padding:8px;"><?php echo htmlspecialchars($student['email']); ?></td>
        </tr>
        <tr>
            <td style="padding:8px; font-weight:bold;">Department</td>
            <td style="padding:8px;">
                <?php
                $dept_res = $conn->query("SELECT dept_name FROM departments WHERE id='".$student['department_id']."'");
                echo htmlspecialchars($dept_res->fetch_assoc()['dept_name']);
                ?>
            </td>
        </tr>
        <tr>
            <td style="padding:8px; font-weight:bold;">Course</td>
            <td style="padding:8px;">
                <?php
                $course_res = $conn->query("SELECT course_name FROM courses WHERE id='".$student['course_id']."'");
                echo htmlspecialchars($course_res->fetch_assoc()['course_name']);
                ?>
            </td>
        </tr>
    </table>
</div>

<!-- Optional: Back to Dashboard -->
<div style="text-align:center; margin-top:20px;">
    <a href="student_dashboard.php" class="start-btn" style="background:#2980b9; padding:10px 20px; color:#fff; text-decoration:none; border-radius:5px;">Back to Dashboard</a>
</div>