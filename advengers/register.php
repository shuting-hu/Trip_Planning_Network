<?php
include'connect.php';
$username = $_POST['username'];
$name = $_POST['name'];
$password = $_POST['password'];
$conn = OpenCon();
$checkUsername = "SELECT * FROM All_Users WHERE username = '$username'";
$updateAllUsers = "INSERT INTO All_Users VALUES ('$username', '$password', '$name')";
$updateRegUsers = "INSERT INTO Regular_User (username) VALUES ('$username')";
// TODO: upload pfp!!!

$duplicate = mysqli_query($conn, $checkUsername) or die(mysqli_error($conn));
if (mysqli_num_rows($duplicate) > 0) {
	echo "<script> alert('Sorry this username is already taken!');parent.location.href='register.html'; </script>";
} else {
	// update user tables
	mysqli_query($conn, $updateAllUsers) or die(mysqli_error($conn));
	mysqli_query($conn, $updateRegUsers) or die(mysqli_error($conn));
	// back to login page, should we pop up "successful!" message before that?
	header("location: login.html");
}	
?>

