<?php
include "db.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Course</title>

<style>

/* Body */
body{
    margin:0;
    font-family:Arial, Helvetica, sans-serif;
    background:#f4f6f9;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

/* Card */
.card{
    background:white;
    padding:30px 35px;
    border-radius:10px;
    box-shadow:0 8px 25px rgba(0,0,0,0.1);
    width:350px;
}

/* Title */
h2{
    text-align:center;
    color:#2980b9;
}

/* Inputs */
input,select{
    width:100%;
    padding:10px;
    margin-top:8px;
    margin-bottom:18px;
    border-radius:5px;
    border:1px solid #ccc;
}

/* Button */
button{
    width:100%;
    padding:10px;
    background:#2980b9;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

button:hover{
    background:#1f6690;
}

/* Message */
.message{
    text-align:center;
    color:green;
    font-weight:bold;
    margin-bottom:15px;
}

</style>
</head>

<body>
<?php include "navbar.php"; ?>
<div class="card">

<h2>Add Course</h2>

<?php

// Run insert only after form submission
if(isset($_POST['course']) && isset($_POST['dept_id'])){

$course = $_POST['course'];
$dept = $_POST['dept_id'];

$conn->query("INSERT INTO courses(course_name,department_id)
VALUES('$course','$dept')");

echo "<p class='message'>Course Added Successfully</p>";

}
?>

<form method="POST">

<label>Course Name</label>
<input type="text" name="course" required>

<label>Select Department</label>
<select name="dept_id" required>

<option value="">-- Select Department --</option>

<?php
$result = $conn->query("SELECT * FROM departments");

while($row = $result->fetch_assoc()){
echo "<option value='".$row['id']."'>".$row['dept_name']."</option>";
}
?>

</select>

<button type="submit">Add Course</button>

</form>

</div>

</body>
</html>