<?php
include "db.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Instructor Dashboard</title>
<style>
/* ===== Basic Reset ===== */
body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background: #f4f6f9;
    display: flex;
}

/* ===== Sidebar ===== */
.sidebar {
    width: 220px;
    background: #2c3e50;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    color: white;
    displa
    y: flex;
    flex-direction: column;
}

.sidebar h2 {
    text-align: center;
    padding: 20px 10px;
    font-size: 20px;
    border-bottom: 1px solid #34495e;
}

.sidebar a {
    color: white;
    padding: 15px 20px;
    text-decoration: none;
    display: block;
    transition: 0.3s;
}

.sidebar a:hover {
    background: #34495e;
    cursor: pointer;
}

/* ===== Main Content ===== */
.main-content {
    margin-left: 220px;
    padding: 30px;
    width: calc(100% - 220px);
}

/* ===== Cards ===== */
.card {
    background: white;
    width: 400px;
    margin: 20px 0;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* Buttons */
button, a.button-link {
    display: inline-block;
    padding: 12px 20px;
    background: #2980b9;
    color: white;
    text-decoration: none;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: 0.3s;
    margin-top: 5px;
}

button:hover, a.button-link:hover {
    background: #1f6690;
}

/* Form Inputs */
input[type="text"], select {
    width: 100%;
    padding: 10px;
    margin: 8px 0 18px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

/* ===== Professional Table ===== */
.prof-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.prof-table th {
    background: #2980b9;
    color: white;
    padding: 12px;
}

.prof-table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.prof-table tr:hover {
    background: #f1f4f7;
}

.edit-btn {
    background: #27ae60;
    color: white;
    padding: 6px 12px;
    text-decoration: none;
    border-radius: 4px;
    margin-right: 5px;
}

.delete-btn {
    background: #e74c3c;
    color: white;
    padding: 6px 12px;
    text-decoration: none;
    border-radius: 4px;
}

/* Back Button */
.back-btn {
    background: #7f8c8d;
    padding: 8px 15px;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 15px;
}
</style>
</head>

<body>

<!-- ===== Sidebar ===== -->
<div class="sidebar">
    <h2>Instructor</h2>
    <a onclick="loadContent('dashboard')">Dashboard</a>
    <a onclick="loadContent('home')">Home</a>
    <a onclick="loadContent('about')">About</a>
    <a onclick="loadContent('contact')">Contact Us</a>
    <a onclick="loadContent('add_course')">Add Course</a>
    <a onclick="loadContent('create_exam')">Create Exam</a>
    <a onclick="loadContent('add_question')">Add Questions</a>
    <a onclick="loadContent('manage_questions')">Manage Questions</a>
    <a onclick="loadContent('view_results')">View Student Results</a>
    <a href="logout.php">Logout</a>
</div>

<!-- ===== Main Content ===== -->
<div class="main-content" id="mainContent">
    <h2>Welcome to Instructor!</h2>
    <p>Select an option from the sidebar to begin.</p>
</div>

<!-- ===== JavaScript for Dynamic Content ===== -->
<script>
function loadContent(page){
    const content = document.getElementById('mainContent');
    if(page === 'dashboard'){
        content.innerHTML = "<h2>Dashboard</h2><p>Instructor Dashboard overview.</p>";
    } else if(page === 'home'){
        content.innerHTML = "<h2>Home</h2><p>Welcome to the Instructor Portal.</p>";
    } else if(page === 'about'){
        content.innerHTML = "<h2>About</h2><p>This system manages courses, exams, and questions professionally.</p>";
    } else if(page === 'contact'){
        content.innerHTML = "<h2>Contact Us</h2><p>Email: support@university.edu<br>Phone: +251 123 456 789</p>";
    } else if(page === 'add_course'){
        content.innerHTML = `
        <div class="card">
            <h3>Create Course</h3>
            <form action="add_course.php" method="POST">
                Course Name<br>
                <input type="text" name="course">
                Department<br>
                <select name="dept_id">
                <?php
                $d=$conn->query("SELECT * FROM departments");
                while($row=$d->fetch_assoc()){
                    echo "<option value='".$row['id']."'>".$row['dept_name']."</option>";
                }
                ?>
                </select>
                <button type="submit">Create</button>
            </form>
        </div>`;
    } else if(page === 'create_exam'){
        content.innerHTML = `<div class="card"><a href="create_exam.php" class="button-link">Go to Create Exam</a></div>`;
    } else if(page === 'add_question'){
        content.innerHTML = `<div class="card"><a href="add_question.php" class="button-link">Go to Add Question</a></div>`;
    } else if(page === 'manage_questions'){
        content.innerHTML = `<div class="card"><a href="manage_questions.php" class="button-link">Go to Manage Questions</a></div>`;
    } else if(page === 'view_results'){
        content.innerHTML = `<div class="card"><a href="view_results.php" class="button-link">View Student Results</a></div>`;
    }
}
</script>

</body>
</html>
