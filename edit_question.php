<?php
include "db.php";

$id = intval($_GET['id']); // sanitize input

// Fetch existing question
$q = $conn->query("SELECT * FROM questions WHERE id=$id");
$row = $q->fetch_assoc();

// Handle update
if(isset($_POST['update'])){
    $question = $_POST['question'];
    $A = $_POST['A'];
    $B = $_POST['B'];
    $C = $_POST['C'];
    $D = $_POST['D'];
    $correct = $_POST['correct'];

    // Permanent update
    $conn->query("
        UPDATE questions SET
        question='$question',
        A='$A',
        B='$B',
        C='$C',
        D='$D',
        correct='$correct'
        WHERE id=$id
    ");

    // Success flag
    $successMessage = "✅ Question ID $id updated successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Question</title>
<style>
body{font-family:Arial;background:#f4f6f9;}
form{
    width:400px;
    margin:40px auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 6px 18px rgba(0,0,0,0.12);
}
input,select{
    width:100%;
    padding:8px;
    margin:8px 0;
    border:1px solid #ccc;
    border-radius:5px;
}
button{
    background:#2980b9;
    color:white;
    padding:10px;
    border:none;
    border-radius:5px;
    cursor:pointer;
}
button:hover{
    background:#1f6690;
}
.back-btn{
    background:#7f8c8d;
    margin-bottom:15px;
}
</style>
</head>

<body>

<!-- Back button -->
<button class="back-btn" onclick="goBack()">← Back</button>

<form method="POST">
<h3>Edit Question</h3>

Question
<input type="text" name="question" value="<?php echo htmlspecialchars($row['question']); ?>">

Option A
<input type="text" name="A" value="<?php echo htmlspecialchars($row['A']); ?>">

Option B
<input type="text" name="B" value="<?php echo htmlspecialchars($row['B']); ?>">

Option C
<input type="text" name="C" value="<?php echo htmlspecialchars($row['C']); ?>">

Option D
<input type="text" name="D" value="<?php echo htmlspecialchars($row['D']); ?>">

Correct Answer
<select name="correct">
    <option <?php if($row['correct']=='A') echo 'selected'; ?>>A</option>
    <option <?php if($row['correct']=='B') echo 'selected'; ?>>B</option>
    <option <?php if($row['correct']=='C') echo 'selected'; ?>>C</option>
    <option <?php if($row['correct']=='D') echo 'selected'; ?>>D</option>
</select>

<button type="submit" name="update" onclick="return confirmUpdate()">Update</button>
</form>

<script>
function confirmUpdate(){
    console.log("Do you want to update this question?");
    return confirm("Do you want to update this question?");
}

// Go back to manage questions
function goBack(){
    window.location.href = "manage_questions.php";
}

// Show success message if updated
<?php if(isset($successMessage)): ?>
    console.log("<?php echo $successMessage; ?>");
    alert("<?php echo $successMessage; ?>");
<?php endif; ?>
</script>

</body>
</html>
