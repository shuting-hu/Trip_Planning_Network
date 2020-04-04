<?php
$query = $_GET['query'];
if (empty($query)) {
	header("location: index.php?search=false");
	return; 
}

$query = str_replace(',', ' ', $query);
$words = explode(' ', $query);

include'connect.php';
$conn = OpenCon();

// reset view
$sql = "CREATE OR REPLACE VIEW Subposts AS SELECT * FROM Trip_In WHERE trip_id = -1";
$rsResult = mysqli_query($conn, $sql) or die(mysqli_error($conn));
foreach ($words as $word) {
    /*$sql = "CREATE OR REPLACE VIEW Temp AS SELECT * FROM Subposts";
    $rsResult = mysqli_query($conn, $sql) or die(mysqli_error($conn));*/
    $sql = "CREATE OR REPLACE VIEW Subposts AS (/*SELECT * FROM Temp UNION*/ SELECT * FROM Trip_In WHERE trip_id IN (SELECT trip_id FROM Plans WHERE username = '$word' UNION SELECT trip_id FROM Trip_In WHERE location_Id IN (SELECT id FROM Location WHERE country = '$word' OR province = '$word' OR city = '$word')))";
    $rsResult = mysqli_query($conn, $sql) or die(mysqli_error($conn));
}

header("location: index.php?search=true");
?>