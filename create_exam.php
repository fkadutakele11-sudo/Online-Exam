<?php
include "db.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Create Exam</title>
<style>

/* Body */
body {
    margin:0;
    font-family: Arial, Helvetica, sans-serif;
    background: #f4f6f9;
}

/* Container */
.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 0 20px;
}

/* Card */
.card {
    background: white;
    padding: 25px 30px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

/* Headings */
h2 {
    color: #2980b9;
    text-align: center;
    margin-bottom: 25px;
}

label {
    font-weight: bold;
    color: #444;
    display: block;
    margin-top: 10px;
    margin-bottom: 5px;
}

/* Inputs and Selects */
input[type="number"], select {
    width: 100%;
    padding: 10px;
    margin-bottom: 18px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

/* Button */
button {
    padding: 12px 20px;
    background: #2980b9;
    border: none;
    color: white;
    font-size: 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #1f6690;
}

/* Message */
.message {
    color: green;
    font-weight: bold;
    margin-top: 15px;
    text-align: center;
}

</style>
</head>
<body>

<div class="container">

<div class="card">
<h2>Create Exam</h2>

<form method="POST">

<label>Course</label>
<select name="course_id">
<?php
$c=$conn->query("SELECT * FROM courses");
while($row=$c->fetch_assoc()){
    echo "<option value='".$row['id']."'>".$row['course_name']."</option>";
}
?>
</select>

<label>Exam Type</label>
<select name="type">
<option>Quiz</option>
<option>Test</option>
<option>Final</option>
</select>

<label>Time (minutes)</label>
<input type="number" name="time">

<button name="create">Create</button>

</form>

<?php
if(isset($_POST['create'])){
    $conn->query("INSERT INTO exams(course_id,exam_type,time_minutes)
    VALUES(
        '".$_POST['course_id']."',
        '".$_POST['type']."',
        '".$_POST['time']."'
    )");
    echo "<p class='message'>Exam Created</p>";
}
?>

</div> <!-- card -->
</div> <!-- container -->

</body>
</html>