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
echo nl2br("Duration: $duration\n\n");


$attrname0 = $_POST['attrname0'];
if ($attrname0 != "") {
    $attrnumds0 = $_POST['attrnumds0'];
    $attrtype0 = $_POST['attrtype0'];
    $attrdesc0 = $_POST['attrdesc0'];
    echo nl2br("Attraction 1: $attrname0\n");
    echo nl2br("$/$$/$$$: $attrnumds0\n");
    echo nl2br("Type: $attrtype0\n");
    echo nl2br("Description: $attrdesc0\n\n");
} else {
    echo nl2br("no attraction 1\n\n");
}

$attrname1 = $_POST['attrname1'];
if ($attrname1 != "") {
    $attrnumds1 = $_POST['attrnumds1'];
    $attrtype1 = $_POST['attrtype1'];
    $attrdesc1 = $_POST['attrdesc1'];
    echo nl2br("Attraction 2: $attrname1\n");
    echo nl2br("$/$$/$$$: $attrnumds1\n");
    echo nl2br("Type: $attrtype1\n");
    echo nl2br("Description: $attrdesc1\n\n");
} else {
    echo nl2br("no attraction 2\n\n");
}

$attrname2 = $_POST['attrname2'];
if ($attrname2 != "") {
    $attrnumds2 = $_POST['attrnumds2'];
    $attrtype2 = $_POST['attrtype2'];
    $attrdesc2 = $_POST['attrdesc2'];
    echo nl2br("Attraction 3: $attrname2\n");
    echo nl2br("$/$$/$$$: $attrnumds2\n");
    echo nl2br("Type: $attrtype2\n");
    echo nl2br("Description: $attrdesc2\n\n");
} else {
    echo nl2br("no attraction 3\n\n");
}

$actname0 = $_POST['actname0'];
if ($actname0 != "") {
    $actnumds0 = $_POST['actnumds0'];
    $acttype0 = $_POST['acttype0'];
    $actdesc0 = $_POST['actdesc0'];
    echo nl2br("Activity 1: $actname0\n");
    echo nl2br("$/$$/$$$: $actnumds0\n");
    echo nl2br("Type: $acttype0\n");
    echo nl2br("Description: $actdesc0\n\n");
} else {
    echo nl2br("no activity 1\n\n");
}

$actname1 = $_POST['actname1'];
if ($actname1 != "") {
    $actnumds1 = $_POST['actnumds1'];
    $acttype1 = $_POST['acttype1'];
    $actdesc1 = $_POST['actdesc1'];
    echo nl2br("Activity 2: $actname1\n");
    echo nl2br("$/$$/$$$: $actnumds1\n");
    echo nl2br("Type: $acttype1\n");
    echo nl2br("Description: $actdesc1\n\n");
} else {
    echo nl2br("no activity 2\n\n");
}

$actname2 = $_POST['actname2'];
if ($actname2 != "") {
    $actnumds2 = $_POST['actnumds2'];
    $acttype2 = $_POST['acttype2'];
    $actdesc2 = $_POST['actdesc2'];
    echo nl2br("Activity 3: $actname2\n");
    echo nl2br("$/$$/$$$: $actnumds2\n");
    echo nl2br("Type: $acttype2\n");
    echo nl2br("Description: $actdesc2\n\n");
} else {
    echo nl2br("no activity 3\n\n");
}

$restname0 = $_POST['restname0'];
if ($restname0 != "") {
    $restnumds0 = $_POST['restnumds0'];
    $resttype0 = $_POST['resttype0'];
    echo nl2br("Restaurant 1: $restname0\n");
    echo nl2br("$/$$/$$$: $restnumds0\n");
    echo nl2br("Type: $resttype0\n\n");
} else {
    echo nl2br("no restaurant 1\n\n");
}

$restname1 = $_POST['restname1'];
if ($restname1 != "") {
    $restnumds1 = $_POST['restnumds1'];
    $resttype1 = $_POST['resttype1'];
    echo nl2br("Restaurant 2: $restname1\n");
    echo nl2br("$/$$/$$$: $restnumds1\n");
    echo nl2br("Type: $resttype1\n\n");
} else {
    echo nl2br("no restaurant 2\n\n");
}

?>