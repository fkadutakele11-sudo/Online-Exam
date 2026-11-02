<?php
include "db.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<style>

/* Body */
body{
margin:0;
font-family: Arial, Helvetica, sans-serif;
background:#f4f6f9;
}

/* Top Bar */
.topbar{
background:#2980b9;
color:white;
padding:15px;
display:flex;
justify-content:space-between;
align-items:center;
}

.topbar h2{
margin:0;
}

/* Logout Button */
.logout-btn{
background:#e74c3c;
border:none;
padding:8px 15px;
color:white;
border-radius:5px;
cursor:pointer;
}

.logout-btn:hover{
background:#c0392b;
}

/* Container */
.container{
max-width:900px;
margin:40px auto;
padding:0 20px;
}

/* Cards */
.card{
background:white;
padding:25px 30px;
border-radius:10px;
box-shadow:0 8px 20px rgba(0,0,0,0.1);
margin-bottom:30px;
}

/* Headings */
h3{
color:#2980b9;
margin-bottom:15px;
}

/* Inputs */
input[type="text"], input[type="password"], select{
width:100%;
padding:10px;
margin-bottom:18px;
border:1px solid #ccc;
border-radius:5px;
font-size:14px;
}

/* Buttons */
button{
padding:12px 20px;
background:#2980b9;
border:none;
color:white;
font-size:15px;
border-radius:5px;
cursor:pointer;
transition:0.3s;
}

button:hover{
background:#1f6690;
}

/* Divider */
hr{
border:none;
height:1px;
background:#ccc;
margin:40px 0;
}

/* Message */
.message{
color:green;
font-weight:bold;
margin-top:10px;
}

</style>

</head>
<body>

<?php include "navbar.php"; ?>

<!-- Top Header -->
<div class="topbar">
<h2>Admin Dashboard</h2>

<button class="logout-btn" onclick="goBack()">Logout</button>
</div>

<div class="container">

<!-- ============================= -->
<!-- ADD DEPARTMENT -->
<!-- ============================= -->

<div class="card">

<h3>Add Department</h3>

<form method="POST">

<label>Department Name</label>
<input type="text" name="dept" required>

<button name="addDept">Add</button>

</form>

<?php
if(isset($_POST['addDept'])){
$dept=$_POST['dept'];

$conn->query("INSERT INTO departments(dept_name) VALUES('$dept')");

echo "<p class='message'>Department Added</p>";
}
?>

</div>

<hr>

<!-- ============================= -->
<!-- ROLE BASED USER REGISTRATION -->
<!-- ============================= -->

<div class="card">

<h3>Register User</h3>

<form method="POST">

<label>Select Role</label>
<select name="role" required>

<option value="">Choose Role</option>
<option value="admin">Admin</option>
<option value="instructor">Instructor</option>
<option value="student">Student</option>

</select>

<label>Student ID (Only for Student)</label>
<input type="text" name="sid">

<label>Full Name</label>
<input type="text" name="name" required>

<label>Password</label>
<input type="password" name="pass" required>

<label>Department</label>

<select name="dept">

<?php
$d=$conn->query("SELECT * FROM departments");

while($row=$d->fetch_assoc()){
echo "<option value='".$row['id']."'>".$row['dept_name']."</option>";
}
?>

</select>

<button name="registerUser">Register</button>

</form>

<?php

if(isset($_POST['registerUser'])){

$role=$_POST['role'];
$name=$_POST['name'];
$pass=$_POST['pass'];
$dept=$_POST['dept'];
$sid=$_POST['sid'];

if($role=="student"){

$conn->query("INSERT INTO users(role,name,student_id,password,department_id)
VALUES('student','$name','$sid','$pass','$dept')");

echo "<p class='message'>Student Created Successfully</p>";

}

elseif($role=="instructor"){

$conn->query("INSERT INTO users(role,name,password,department_id)
VALUES('instructor','$name','$pass','$dept')");

echo "<p class='message'>Instructor Registered</p>";

}

elseif($role=="admin"){

$conn->query("INSERT INTO users(role,name,password)
VALUES('admin','$name','$pass')");

echo "<p class='message'>Admin Created</p>";

}

}

?>

</div>

</div>

<script>

/* Logout → return to previous page */

function goBack(){

window.history.back();

}

</script>

</body>
</html>