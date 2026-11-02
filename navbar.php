<!DOCTYPE html>
<html>
<head>

<style>

/* RESET */

body{
margin:0;
font-family: "Segoe UI", Arial, sans-serif;
background:#f4f6f9;
}

/* NAVBAR */

.navbar{
background:linear-gradient(90deg,#1f6690,#2980b9);
width:100%;
position:fixed;
top:0;
left:0;
box-shadow:0 4px 12px rgba(0,0,0,0.15);
z-index:1000;
}

/* MENU LIST */

.navbar ul{
margin:0;
padding:0;
list-style:none;
display:flex;
justify-content:center;
align-items:center;
}

/* MENU ITEMS */

.navbar li{
    padding:40px 50px;
}

/* LINKS */

.navbar a{
text-decoration:none;
color:white;
font-size:17px;
font-weight:600;
letter-spacing:0.5px;
transition:all 0.3s ease;
padding:8px 14px;
border-radius:5px;
}

/* HOVER EFFECT */

.navbar a:hover{
background:rgba(255,255,255,0.15);
color:#eaf6ff;
}

/* PAGE SPACE */

.page{
margin-top:120px;
text-align:center;
padding:40px;
}

/* TITLE */

.page h2{
color:#2980b9;
font-size:32px;
margin-bottom:10px;
}

/* PARAGRAPH */

.page p{
font-size:18px;
color:#555;
max-width:600px;
margin:auto;
line-height:1.6;
}

</style>

</head>

<body>

<!-- Navigation Bar -->

<div class="navbar">

<ul>

<li><a href="index.php">Home</a></li>

<li><a href="about.php">About</a></li>

<li><a href="contact.php">Contact</a></li>

<li><a href="index.php">Login</a></li>

</ul>

</div>

<div class="page">

<h2>Welcome to Online Exam System</h2>

<p>This system allows students to take exams online.</p>

</div>

</body>
</html>