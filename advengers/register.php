<?php
include'connect.php';
$username = $_POST['username'];
$name = $_POST['name'];
$password = $_POST['password'];
$conn = OpenCon();
$checkUsername = "select * from all_users where username = '$username'";
$updateAllUsers = "insert into all_users values ('$username', '$password', '$name')";
$updateRegUsers = "insert into regular_user (username) values ('$username')";

$duplicate = mysqli_query($conn, $checkUsername) or die(mysqli_error($conn));
if (mysqli_num_rows($duplicate) > 0) {
	echo "<script> alert('Username already existed.');parent.location.href='register.html'; </script>";
} else {
	// update user tables
	mysqli_query($conn, $updateAllUsers) or die(mysqli_error($conn));
	mysqli_query($conn, $updateRegUsers) or die(mysqli_error($conn));
	// back to login page, should we pop up "successful!" message before that?
	header("location: login.html");
}	
?>

