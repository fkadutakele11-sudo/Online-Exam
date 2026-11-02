<?php 
include "db.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Questions</title>
<style>
/* PAGE */
body{
    margin:0;
    font-family:Arial, Helvetica, sans-serif;
    background:#f4f6f9;
}

/* CONTAINER */
.table-container{
    width:90%;
    margin:40px auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 6px 18px rgba(0,0,0,0.12);
}

h2{
    color:#2980b9;
    margin-bottom:15px;
}

/* TOP ACTION PANEL */
.action-panel{
    display:flex;
    justify-content:flex-start;
    margin-bottom:20px;
    gap:10px;
}

.action-panel button{
    padding:8px 15px;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.back-btn{
    background:red;
}

.edit-btn-global{
    background:#27ae60;
}

.delete-btn-global{
    background:#e74c3c;
}

/* TABLE */
.prof-table{
    width:100%;
    border-collapse:collapse;
    cursor:pointer;
}

.prof-table th{
    background:#2980b9;
    color:white;
    padding:12px;
}

.prof-table td{
    padding:10px;
    border-bottom:1px solid #ddd;
}

.prof-table tr:hover{
    background:green;
}

/* SELECTED ROW */
.selected{
    background:#d1f0ff !important;
}
</style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="table-container">

    <h2>Manage Questions</h2>

    <!-- Top action panel -->
    <div class="action-panel">
        <button class="back-btn" onclick="goBack()"><-Back</button>
        <button class="edit-btn-global" onclick="editQuestion()">✎ Edit</button>
        <button class="delete-btn-global" onclick="deleteQuestion()">🗑 Delete</button>
    </div>

    <table class="prof-table" id="questionsTable">
        <tr>
            <th>ID</th>
            <th>Question</th>
            <th>A</th>
            <th>B</th>
            <th>C</th>
            <th>D</th>
        </tr>

        <?php
        $q = $conn->query("SELECT * FROM questions");
        while($row = $q->fetch_assoc()){
        ?>
        <tr data-id="<?php echo $row['id']; ?>">
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['question']; ?></td>
            <td><?php echo $row['A']; ?></td>
            <td><?php echo $row['B']; ?></td>
            <td><?php echo $row['C']; ?></td>
            <td><?php echo $row['D']; ?></td>
        </tr>
        <?php } ?>
    </table>

</div>

<script>
// BACK button
function goBack(){
    window.location.href = "instructor.php";
}

// SELECT ROW ON CLICK
let selectedRow = null;
const table = document.getElementById("questionsTable");
Array.from(table.getElementsByTagName("tr")).forEach((row, index)=>{
    if(index === 0) return; // skip header
    row.addEventListener("click", function(){
        if(selectedRow) selectedRow.classList.remove("selected");
        this.classList.add("selected");
        selectedRow = this;
        console.log("Selected question ID " + this.dataset.id);
    });
});

// GET selected question ID
function getSelectedQuestionId(){
    if(selectedRow) return selectedRow.dataset.id;
    alert("⚠ Please click on a question row first!");
    return null;
}

// EDIT
function editQuestion(){
    const id = getSelectedQuestionId();
    if(id){
        if(confirm("Do you want to edit question ID " + id + "?")){
            console.log("Editing question ID " + id);
            window.location.href = "edit_question.php?id=" + id;
        }
    }
}

// DELETE
function deleteQuestion(){
    const id = getSelectedQuestionId();
    if(id){
        if(confirm("Do you want to delete question ID " + id + "?")){
            console.log("Deleting question ID " + id);
            alert("✅ Question ID " + id + " deleted successfully!");
            window.location.href = "delete_question.php?id=" + id;
        }
    }
}
</script>

</body>
</html>
