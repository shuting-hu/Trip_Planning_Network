<?php
session_start(); 

include "connect.php";
$username = $_POST['username'];
$password = $_POST['password'];

$conn = OpenCon();
$sql = "SELECT * FROM all_users WHERE username = '$username' AND password = '$password'";
$rsResult = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if (!empty(mysqli_fetch_array($rsResult, MYSQLI_ASSOC))) {
	$_SESSION["username"] = $username;
	
	// check for admin identity
	$sql = "select role from admin where username = '$username'";
  	$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  	$row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
  	if (empty($row)) { // regular user
  		$_SESSION['admin'] = false;
  	} else { // admin
  		$_SESSION['admin'] = true;
  		$_SESSION['asAdmin'] = true;
  		$_SESSION['role'] = $row['role'];
  	}
  	
  	header("location: index.php");
} else {
	echo "<script> alert('Invalid username or password. Please try again.');parent.location.href='login.html'; </script>";
}
?>

