<?php
session_start(); 

include'connect.php';
$username = $_POST['username'];
$password = $_POST['password'];
$conn = OpenCon();
$sql = "select * from All_Users where username = '$username' and password = '$password'";

$rsResult = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if (mysqli_num_rows($rsResult) > 0) {
	$_SESSION["username"] = $username;
	header("location: index.php");
} else {
	echo "<script> alert('Invalid username or password. Please try again.');parent.location.href='login.html'; </script>";
}
?>

