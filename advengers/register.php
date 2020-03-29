<?php
include'connect.php';
$username = $_POST['username'];
$password = $_POST['password'];
$conn = OpenCon();
$checkUsername = "select * from all_users where username = '$username'";
$updateAllUsers = "insert into all_users values ('$username', '$password')";
$updateRegUsers = "insert into regular_user values ('$username', NULL)";

$duplicate = mysqli_query($conn, $checkUsername) or die(mysqli_error($conn));
if (mysqli_num_rows($duplicate) > 0) {
	// error message: Username already existed.
} else {
	// update user table
	mysqli_query($conn, $updateAllUsers) or die(mysqli_error($conn));
	mysqli_query($conn, $updateRegUsers) or die(mysqli_error($conn));
	// back to login page, should we pop up "successful!" message before that?
	header("location: login.html");
}	
?>

