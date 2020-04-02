<?php
session_start();
include 'connect.php';
// get val passed from login form
$username = $_POST['username'];
$password = $_POST['password'];
$conn = OpenCon();

// query db for user
$sql = "SELECT *
        FROM All_Users
        WHERE username = '$username' AND password = '$password'";
$query = mysqli_query($conn, $sql) or die("Failed to query data" . mysqli_error($conn));
$row = mysqli_fetch_row($query);
if (mysqli_num_rows($query) > 0) {
    $_SESSION['username'] = $username;
    header("location: index.php");
} else {
    echo "<script> alert('Invalid username or password. Please try again.'); parent.location.href='login.html'; </script>";
}
?>