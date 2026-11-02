<?php
session_start();
include "db.php";

$name = $_POST['name'] ?? '';

function showMessage($message){
echo "
<!DOCTYPE html>
<html>
<head>
<title>Login Message</title>

<style>

body{
font-family: Arial;
background: linear-gradient(135deg,#2980b9,#6dd5fa);
height:100vh;
display:flex;
align-items:center;
justify-content:center;
margin:0;
}

.box{
background:white;
padding:40px;
border-radius:10px;
text-align:center;
box-shadow:0 5px 15px rgba(0,0,0,0.2);
width:350px;
}

h2{
color:#e74c3c;
}

button{
padding:10px 20px;
background:#2980b9;
border:none;
color:white;
border-radius:5px;
cursor:pointer;
margin-top:15px;
}

button:hover{
background:#1f6391;
}

</style>
</head>

<body>

<div class='box'>
<h2>$message</h2>
<a href='index.html'><button>Back to Login</button></a>
</div>

</body>
</html>
";
}

if($name == ""){
showMessage("Please enter name");
exit;
}

$sql = "SELECT * FROM users WHERE name='$name'";
$result = $conn->query($sql);

if($result->num_rows == 0){
showMessage("User not found");
exit;
}

$user = $result->fetch_assoc();

$_SESSION['user_id'] = $user['id'];
$_SESSION['role'] = $user['role'];

if($user['role'] == "admin"){
header("Location: admin.php");
exit;
}

if($user['role'] == "instructor"){
header("Location: instructor.php");
exit;
}

if($user['role'] == "student"){
header("Location: student.php");
exit;
}
?>