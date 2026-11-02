<?php
include "db.php";

if(isset($_GET['id'])){
    $id = intval($_GET['id']); // sanitize input

    // Delete the question permanently
    $conn->query("DELETE FROM questions WHERE id=$id");

    if($conn->affected_rows > 0){
        $message = "✅ Question ID $id deleted successfully!";
    } else {
        $message = "⚠ Question ID $id not found or could not be deleted!";
    }
} else {
    $message = "⚠ No Question ID provided!";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Delete Question</title>
</head>
<body>

<script>
    // Show console log
    console.log("<?php echo $message; ?>");

    // Show alert
    alert("<?php echo $message; ?>");

    // Go back to previous page (Manage Questions)
    window.history.back();
</script>

</body>
</html>
