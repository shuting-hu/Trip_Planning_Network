<?php
$query = $_GET['query'];
if (empty($query)) {
	header("location: index.php?search=false");
	return; 
}

$query = str_replace(',', ' ', $query);
$words = explode(' ', $query);
$wordsStr = implode("', '", $words);

include'connect.php';
$conn = OpenCon();
$sql = "CREATE OR REPLACE VIEW Subposts AS SELECT * FROM Trip_In WHERE trip_id IN (SELECT trip_id FROM Plans WHERE username IN ('$wordsStr') UNION SELECT trip_id FROM Trip_In WHERE location_Id IN (SELECT id FROM Location WHERE country IN ('$wordsStr') UNION SELECT id FROM Location WHERE province IN ('$wordsStr') UNION SELECT id FROM Location WHERE city IN ('$wordsStr')))";
$rsResult = mysqli_query($conn, $sql) or die(mysqli_error($conn));

header("location: index.php?search=true");

/*$sql = "CREATE VIEW Subposts
AS
SELECT *
FROM Trip_In T
WHERE T.trip_id IN
	((SELECT P.trip_id
	FROM Plans
	WHERE P.username = '$word')
	UNION
	(SELECT T2.trip_id
	FROM Trip_In T2
	WHERE T2.location_id IN
		(SELECT id FROM Location
		WHERE country = '$word'
		OR province = '$word'
		OR city = '$word')));"*/
?>