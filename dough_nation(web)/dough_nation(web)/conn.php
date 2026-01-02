<?php 
$conn = mysqli_connect("localhost", "root", "", "dough_nation");

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>
