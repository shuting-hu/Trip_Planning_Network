<?php
include 'connect.php';

$conn = OpenCon();

if (!isset($_POST["submit"])) {
    echo "error, nothing submitted.";
    exit;
}

$test = $_POST["foo"];
echo $test;



?>