<?php
include "db.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Question</title>
<style>

/* Body */
body {
    margin:0;
    font-family: Arial, Helvetica, sans-serif;
    background: #f4f6f9;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* Card */
.card {
    background: white;
    padding: 30px 35px;
    border-radius: 10px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    width: 500px;
}

/* Headings */
h2 {
    color: #2980b9;
    text-align: center;
    margin-bottom: 25px;
}

/* Labels and inputs */
label {
    font-weight: bold;
    color: #444;
    display: block;
    margin-top: 10px;
    margin-bottom: 5px;
}

input[type="text"], select {
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
    width: 100%;
}

button:hover {
    background: #1f6690;
}

/* Success message */
.message {
    color: green;
    font-weight: bold;
    margin-top: 15px;
    text-align: center;
    font-size: 16px;
}

</style>
</head>
<body>

<div class="card">
<h2>Add Question</h2>

<form method="POST">

<label>Exam</label>
<select name="exam_id">
<?php
$e=$conn->query("SELECT * FROM exams");
while($row=$e->fetch_assoc()){
    echo "<option value='".$row['id']."'>Exam ".$row['id']."</option>";
}
?>
</select>

<label>Question</label>
<input type="text" name="question">

<label>Option A</label>
<input type="text" name="A">

<label>Option B</label>
<input type="text" name="B">

<label>Option C</label>
<input type="text" name="C">

<label>Option D</label>
<input type="text" name="D">

<label>Correct Answer</label>
<select name="correct">
<option>A</option>
<option>B</option>
<option>C</option>
<option>D</option>
</select>

<button name="add">Add Question</button>
</form>

<?php
if(isset($_POST['add'])){
    $conn->query("INSERT INTO questions (exam_id,question,A,B,C,D,correct)
    VALUES(
        '".$_POST['exam_id']."',
        '".$_POST['question']."',
        '".$_POST['A']."',
        '".$_POST['B']."',
        '".$_POST['C']."',
        '".$_POST['D']."',
        '".$_POST['correct']."'
    )");
    echo "<p class='message'>Question Added</p>";
}
?>

</div>

</body>
</html>