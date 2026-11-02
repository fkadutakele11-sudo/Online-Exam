<?php
include "db.php";

// Check if department & course are selected
$selected_dept = isset($_POST['department_id']) ? $_POST['department_id'] : null;
$selected_course = isset($_POST['course_id']) ? $_POST['course_id'] : null;
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>
<style>
/* Body */
body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background: #f4f6f9;
}

/* Page Header */
h2 {
    text-align: center;
    color: #2980b9;
    margin-top: 30px;
}

/* Card */
.card {
    background: white;
    width: 450px;
    margin: 30px auto;
    padding: 25px 30px;
    border-radius: 10px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* Labels and Selects */
label {
    font-weight: bold;
    display: block;
    margin: 10px 0 5px 0;
    color: #444;
}

select {
    width: 100%;
    padding: 10px;
    margin-bottom: 18px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 14px;
}

/* Button */
button {
    width: 100%;
    padding: 12px;
    background: #2980b9;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 15px;
    transition: 0.3s;
}

button:hover {
    background: #1f6690;
}

/* Exam Cards */
.exam-card {
    background: #e8f0fe;
    padding: 15px 20px;
    margin-top: 15px;
    border-radius: 8px;
}

.exam-title {
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

a.start-btn {
    display: inline-block;
    padding: 8px 15px;
    background: #2980b9;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: 0.3s;
    font-size: 14px;
}

a.start-btn:hover {
    background: #1f6690;
}
</style>
</head>
<body>
<?php include "navbar.php"; ?>

<h2>Student Dashboard</h2>

<!-- Student Actions: View Profile & Results -->
<div class="card">
    <h3 style="text-align:center; color:#2980b9;">Quick Actions</h3>
    <div style="display:flex; justify-content:space-around; margin-top:20px;">
        <a href="view_profile.php" class="start-btn" style="background:#27ae60;">View Profile</a>
        <a href="view_results.php" class="start-btn" style="background:#e67e22;">View Results</a>
    </div>
</div>

<!-- Department & Course Selection -->
<div class="card">
<form method="POST" action="">
<label>Select Department</label>
<select name="department_id" required>
<option value="0" disabled>-- Choose Department --</option>
<?php
$departments = $conn->query("SELECT * FROM departments");
while($d = $departments->fetch_assoc()){
    $selected = ($selected_dept == $d['id']) ? "selected" : "";
    echo "<option value='".$d['id']."' $selected>".$d['dept_name']."</option>";
}
?>
</select>

<label>Select Course</label>
<select name="course_id" id="courseSelect" required>
<option value="0" disabled>-- Choose Course --</option>
</select>

<script>
// Get all courses from PHP
const courses = <?php
$all_courses = [];
$c_result = $conn->query("SELECT * FROM courses");
while($c = $c_result->fetch_assoc()){
    $all_courses[] = $c;
}
echo json_encode($all_courses);
?>;

const courseSelect = document.getElementById('courseSelect');
const selectedCourse = <?php echo json_encode($selected_course); ?>;

// Populate course dropdown based on selected department
function populateCourses(deptId){
    courseSelect.innerHTML = '<option value="0" disabled>-- Choose Course --</option>';
    courses.forEach(c => {
        if(c.department_id == deptId){
            const opt = document.createElement('option');
            opt.value = c.id;
            opt.textContent = c.course_name;
            if(c.id == selectedCourse) opt.selected = true;
            courseSelect.appendChild(opt);
        }
    });
}

// Initial population if department already selected
<?php if($selected_dept): ?>
populateCourses(<?php echo $selected_dept; ?>);
<?php endif; ?>

document.querySelector('select[name="department_id"]').addEventListener('change', function(){
    populateCourses(this.value);
});
</script>

<button type="submit">Show Exams</button>
</form>
</div>

<?php
// Only show exams if department and course are selected
if($selected_dept && $selected_course){
    $result = $conn->query("SELECT * FROM exams WHERE course_id='$selected_course'");
    while($row = $result->fetch_assoc()){
        echo "<div class='card exam-card'>";
        echo "<div class='exam-title'>Exam ID: ".$row['id']." | Type: ".$row['exam_type']."</div>";
        echo "<a class='start-btn' href='take_exam.php?exam=".$row['id']."'>Start Exam</a>";
        echo "</div>";
    }
}
?>

</body>
</html>