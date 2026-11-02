<?php
include "db.php";

session_start(); // Ensure session is started

// Safely get student_id from session
if (!isset($_SESSION['student_id'])) {
    // If student ID is missing, redirect to login page
    header("Location: login.php");
    exit();
}
$student_id = $_SESSION['student_id']; // Logged-in student ID

$exam = $_POST['exam_id'];

// Fetch all questions for the exam
$q = $conn->query("SELECT * FROM questions WHERE exam_id=$exam");

$score = 0;
$total = $q->num_rows; // Total number of questions

while ($row = $q->fetch_assoc()) {
    $qid = $row['id'];

    if (isset($_POST["q$qid"])) {
        if ($_POST["q$qid"] == $row['correct']) {
            $score++;
        }
    }
}

// --- INSERT RESULT INTO DATABASE ---
$stmt = $conn->prepare("INSERT INTO results (student_id, exam_id, score, total) VALUES (?, ?, ?, ?)");
$stmt->bind_param("siii", $student_id, $exam, $score, $total);
$stmt->execute();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
<title>Exam Result</title>
<style>
/* Body and font */
body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background: #f4f6f9;
}
/* Result card */
.result-card {
    max-width: 400px;
    margin: 100px auto;
    background: white;
    padding: 30px 25px;
    border-radius: 10px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    text-align: center;
}
/* Score header */
h2 {
    font-size: 28px;
    color: #2980b9;
    margin-bottom: 20px;
}
/* Back button */
a.back-btn {
    display: inline-block;
    padding: 12px 20px;
    background: #2980b9;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
    transition: 0.3s;
}
a.back-btn:hover {
    background: #1f6690;
}
</style>
</head>
<body>

<div class="result-card">
    <h2>Your Score: <?php echo $score; ?> / <?php echo $total; ?></h2>
    <a class="back-btn" href="student.php">Back to Dashboard</a>
</div>

</body>
</html>