<?php
include "db.php";

/* Fetch all results */
$result = $conn->query("SELECT * FROM results ORDER BY submitted_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>View Student Results</title>

<style>

/* Page style */
body{
    margin:0;
    font-family:Arial, Helvetica, sans-serif;
    background:#f4f6f9;
}

/* Container */
.container{
    width:90%;
    max-width:1000px;
    margin:40px auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 8px 25px rgba(0,0,0,0.15);
}

/* Title */
h2{
    text-align:center;
    color:#2980b9;
    margin-bottom:20px;
}

/* Table */
table{
    width:100%;
    border-collapse:collapse;
}

/* Header */
th{
    background:#2980b9;
    color:white;
    padding:12px;
}

/* Cells */
td{
    padding:10px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

/* Row hover */
tr:hover{
    background:#f1f1f1;
}

/* Score colors */
.pass{
    color:green;
    font-weight:bold;
}

.fail{
    color:red;
    font-weight:bold;
}

</style>
</head>

<body>

<div class="container">

<h2>Student Exam Results</h2>

<table>

<tr>
    <th>ID</th>
    <th>Student ID</th>
    <th>Exam ID</th>
    <th>Score</th>
    <th>Total</th>
    <th>Percentage</th>
    <th>Submitted At</th>
</tr>

<?php
if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){

        $percentage = ($row['score'] / $row['total']) * 100;
        $class = ($percentage >= 50) ? "pass" : "fail";

        echo "<tr>";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['student_id']."</td>";
        echo "<td>".$row['exam_id']."</td>";
        echo "<td class='$class'>".$row['score']."</td>";
        echo "<td>".$row['total']."</td>";
        echo "<td>".number_format($percentage,2)."%</td>";
        echo "<td>".$row['submitted_at']."</td>";
        echo "</tr>";
    }

}else{
    echo "<tr><td colspan='7'>No Results Found</td></tr>";
}
?>

</table>

</div>

</body>
</html>