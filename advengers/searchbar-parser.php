<?php
include'connect.php';
$conn = OpenCon();

// reset view
$sql = "DROP VIEW IF EXISTS Subposts";
$rsResult = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$query = $_GET['query'];
$query = str_replace(',', ' ', $query);
$words = explode(' ', $query);

foreach ($words as $word) {
    $sql = "CREATE VIEW Subposts AS SELECT * FROM Trip_In WHERE trip_id IN (SELECT trip_id FROM Plans WHERE username = '$word' UNION SELECT trip_id FROM Trip_In WHERE location_Id IN (SELECT id FROM Location WHERE country = '$word' OR province = '$word' OR city = '$word'))";
    $rsResult = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    header("location: index.php?search=true");
}
?>