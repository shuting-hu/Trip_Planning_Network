<?php
session_start(); // TODO

include'connect.php';
$username = $_POST['username'];
$password = $_POST['password'];
$conn = OpenCon();
$sql = "select * from All_Users where username = '$username' and password = '$password'";

$rsResult = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if (mysqli_num_rows($rsResult) > 0) {
	// TODO: how to pass username info to index.html?
	// how to keep signed in when redirected to another page???
	// UPDATE: maybe we have to use cookies/session
	header("location: index.html");
} else {
	echo "<script> alert('Invalid username or password. Please try again.');parent.location.href='login.html'; </script>";
}?>

