<?php 
session_start(); // Ensure student_id is in session
include "db.php";

$exam=$_GET['exam'];

$q=$conn->query("SELECT * FROM questions WHERE exam_id=$exam");

// Collect all questions in array for paging
$questions = [];
while($row=$q->fetch_assoc()){
    $questions[] = $row;
}
$totalQuestions = count($questions);
$totalPages = ceil($totalQuestions/2);
?>

<!DOCTYPE html>
<html>
<head>
<title>Take Exam</title>
<style>

/* Body and font */
body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background: #f4f6f9;
}

/* Form container */
form {
    max-width: 700px;
    margin: 30px auto;
    background: white;
    padding: 25px 30px;
    border-radius: 10px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* Exam header */
h2 {
    text-align: center;
    color: #2980b9;
    margin-bottom: 20px;
}

/* Question */
.question {
    margin-top: 20px;
}

.question h4 {
    color: #333;
}

/* Radio buttons */
input[type="radio"] {
    margin-right: 8px;
    margin-top: 10px;
}

/* Navigation buttons */
button.nav-btn {
    padding: 10px 20px;
    margin: 15px 5px 0 5px;
    background: #2980b9;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

button.nav-btn:hover {
    background: #1f6690;
}

/* Submit button */
button#submitBtn {
    width: 100%;
    margin-top: 25px;
}
</style>
</head>

<body>

<form id="examForm" action="submit_exam.php" method="POST">

<h2>Exam ID: <?php echo $exam; ?></h2>

<input type="hidden" name="exam_id" value="<?php echo $exam; ?>">
<input type="hidden" name="student_id" value="<?php echo $_SESSION['student_id']; ?>">

<!-- Page indicator -->
<div style="text-align:center; margin-bottom:10px;">
    <span id="pageIndicator" style="font-weight:bold; color:#2980b9;">Page 1 of <?php echo $totalPages; ?></span>
</div>

<div id="questionsContainer">
<?php foreach($questions as $index => $row): ?>
<div class="question" data-index="<?php echo $index; ?>" style="display:none;">
    <h4><?php echo $row['question']; ?></h4>
    <label><input type="radio" name="q<?php echo $row['id']; ?>" value="A"><?php echo $row['A']; ?></label><br>
    <label><input type="radio" name="q<?php echo $row['id']; ?>" value="B"><?php echo $row['B']; ?></label><br>
    <label><input type="radio" name="q<?php echo $row['id']; ?>" value="C"><?php echo $row['C']; ?></label><br>
    <label><input type="radio" name="q<?php echo $row['id']; ?>" value="D"><?php echo $row['D']; ?></label><br>
</div>
<?php endforeach; ?>
</div>

<div style="text-align:center;">
    <button type="button" id="prevBtn" class="nav-btn">Previous</button>
    <button type="button" id="nextBtn" class="nav-btn">Next</button>
    <button type="submit" id="submitBtn" style="display:none;">Submit Exam</button>
</div>

</form>

<!-- ===============================
        2 Questions per Page Navigation
================================ -->
<script>
const questions = document.querySelectorAll(".question");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const submitBtn = document.getElementById("submitBtn");
const pageIndicator = document.getElementById("pageIndicator");
let currentPage = 0;
const perPage = 2;
const totalPages = Math.ceil(questions.length/perPage);

function showPage(page){
    questions.forEach((q,index)=>{
        q.style.display = (index >= page*perPage && index < (page+1)*perPage) ? "block" : "none";
    });

    prevBtn.style.display = (page===0) ? "none" : "inline-block";
    nextBtn.style.display = (page+1 >= totalPages) ? "none" : "inline-block";
    submitBtn.style.display = (page+1 >= totalPages) ? "inline-block" : "none";

    pageIndicator.textContent = "Page " + (page+1) + " of " + totalPages;
}

// Initial display
showPage(currentPage);

// Navigation
nextBtn.addEventListener("click", ()=>{
    if(currentPage < totalPages-1){
        currentPage++;
        showPage(currentPage);
    }
});

prevBtn.addEventListener("click", ()=>{
    if(currentPage > 0){
        currentPage--;
        showPage(currentPage);
    }
});
</script>

<!-- ===============================
     Enhanced Auto-Submit Timer
================================ -->
<script>
window.onload = function() {

    startFullscreen(); // start fullscreen automatically

    const examTime = <?php
        $exam_info = $conn->query("SELECT time_minutes FROM exams WHERE id='$exam'");
        $time_row = $exam_info->fetch_assoc();
        echo $time_row['time_minutes'] * 60 * 1000;
    ?>;

    let remaining = examTime / 1000;

    const timerContainer = document.createElement('div');
    timerContainer.style.textAlign = 'center';
    timerContainer.style.marginBottom = '15px';

    const timerText = document.createElement('div');
    timerText.style.fontSize = '18px';
    timerText.style.fontWeight = 'bold';
    timerText.style.color = '#27ae60';
    timerContainer.appendChild(timerText);

    const progressBar = document.createElement('div');
    progressBar.style.width = '80%';
    progressBar.style.height = '20px';
    progressBar.style.background = '#ddd';
    progressBar.style.margin = '10px auto';
    progressBar.style.borderRadius = '10px';

    const progressFill = document.createElement('div');
    progressFill.style.height = '100%';
    progressFill.style.width = '100%';
    progressFill.style.background = '#27ae60';
    progressFill.style.borderRadius = '10px';

    progressBar.appendChild(progressFill);
    timerContainer.appendChild(progressBar);

    document.querySelector('form')
        .insertBefore(timerContainer, document.querySelector('form').firstChild);

    const total = remaining;

    const interval = setInterval(() => {

        let minutes = Math.floor(remaining / 60);
        let seconds = remaining % 60;

        timerText.textContent =
            `Time Remaining: ${minutes}m ${seconds}s`;

        progressFill.style.width =
            (remaining / total * 100) + '%';

        if(remaining <= 60){
            progressFill.style.background = '#e74c3c';
            timerText.style.color = '#e74c3c';
            timerText.textContent =
            `⚠ Last Minute! Time Remaining: ${minutes}m ${seconds}s`;
        }

        remaining--;

        if(remaining < 0){
            clearInterval(interval);
            alert("Time is up! Your exam will be submitted automatically.");
            document.getElementById('examForm').submit();
        }

    },1000);
};
</script>

<!-- ===============================
        CHEAT PROTECTION
================================ -->
<script>
document.addEventListener("copy", e => e.preventDefault());
document.addEventListener("cut", e => e.preventDefault());
document.addEventListener("paste", e => e.preventDefault());
document.addEventListener("selectstart", e => e.preventDefault());

document.addEventListener("contextmenu", function(e){ e.preventDefault(); });

document.addEventListener("keydown", function(e){
    if (e.key === "F5") e.preventDefault();
    if (e.ctrlKey && e.key.toLowerCase() === "r") e.preventDefault();
});
</script>

<!-- ===============================
      PROFESSIONAL FULLSCREEN MODE
================================ -->
<script>
function startFullscreen(){
    const elem = document.documentElement;
    if(elem.requestFullscreen) elem.requestFullscreen();
    else if(elem.webkitRequestFullscreen) elem.webkitRequestFullscreen();
    else if(elem.msRequestFullscreen) elem.msRequestFullscreen();
}

document.addEventListener("fullscreenchange", function(){
    if(!document.fullscreenElement){
        alert("Fullscreen exited! Exam auto submitting...");
        document.getElementById("examForm").submit();
    }
});

document.addEventListener("click", startFullscreenOnce, { once: true });
function startFullscreenOnce(){
    const elem = document.documentElement;
    if(elem.requestFullscreen) elem.requestFullscreen();
    else if(elem.webkitRequestFullscreen) elem.webkitRequestFullscreen();
    else if(elem.msRequestFullscreen) elem.msRequestFullscreen();
}
</script>

</body>
</html>