<?php

$author = 'username of current user';
$date = date("Y-m-d");

$title = $_POST['title'];
$desc = $_POST['desc'];
$city = $_POST['city'];
$province = $_POST['province'];
$country = $_POST['country'];

$duration = $_POST['duration'];


//echo $author;
//echo $date;
echo nl2br("$author\n");
echo nl2br("$date\n");
echo nl2br("Title: $title\n");
echo nl2br("Desc: $desc\n");
echo nl2br("City: $city\n");
if ($province === "") { // if no province given
    echo nl2br("no province given\n");
} else {
    echo nl2br("Province: $province\n");
}

echo nl2br("Country: $country\n");
echo nl2br("Duration: $duration\n");

?>