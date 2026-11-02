<?php
$conn = new mysqli("localhost","root","","online_exam");

if($conn->connect_error){
    die("Connection failed");
}
else{
    echo "connection successfull.";
}
?>