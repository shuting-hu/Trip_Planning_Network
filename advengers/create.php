<?php
session_start();
$username = $_SESSION["username"];
// redirects to login if no active session
if (!isset($username)) {
    header("location: login.html");
}

include 'connect.php';

// COMMENT OUT ALL sql errors: FIND ' or die', REPLACE with ';//DEBUG or die'

// TODO sanitize inputs to remove apostrophe for example
function removeSpecialChars($str) {
    $str = str_replace("'", "\'", $str);
    $str = str_replace('"', "\"", $str);
    return $str;
}

$conn = OpenCon();
// FOR TESTING - FILL IN LATER
$testuser = "insert into `All_Users`(username, password, name)
    values('test', 'abc', 'joe');";
$testuserresult = mysqli_query($conn, $testuser);//DEBUG or die(mysqli_error($conn));


$author = 'test';
$date = date("Y-m-d");


$title = $_POST['title'];
$desc = $_POST['desc'];
$desc = !empty($desc) ? "'$desc'" : "NULL";

$city = $_POST['city'];
$province = $_POST['province'];
$country = $_POST['country'];

// gets stuck when i use this function
// $title = removeSpecialChars($_POST['title']);
// $desc = removeSpecialChars($_POST['desc']);
// $city = removeSpecialChars($_POST['city']);
// $province = removeSpecialChars($_POST['province']);
// $country = removeSpecialChars($_POST['country']);
$duration = $_POST['duration'];


// uses auto-increment so dont need to specify pk val
$province = !empty($province) ? "'$province'" : "NULL";
$addloc = "insert into `Location`(country, province, city)
    values('$country', $province, '$city');";
$addlocresult = mysqli_query($conn, $addloc);//DEBUG or die(mysqli_error($conn));

$loc_id = mysqli_query($conn, "select id from location where country='$country' and city='$city'");//DEBUG or die(mysqli_error($conn));
$loc_id = ($loc_id->fetch_assoc())['id'];


$addtrip = "insert into `Trip_In`(title, location_id, duration, description)
    values('$title', $loc_id, '$duration', $desc);";
$addtripresult = mysqli_query($conn, $addtrip);//DEBUG or die(mysqli_error($conn));

$tripid = mysqli_insert_id($conn);

$addplans = "insert into Plans(username, trip_id)
    values('$author', $tripid)";
$addplansresult = mysqli_query($conn, $addplans);//DEBUG or die(mysqli_error($conn));


$attrname0 = $_POST['attrname0'];
if ($attrname0 != "") {
    $attrnumds0 = $_POST['attrnumds0'];
    $attrtype0 = $_POST['attrtype0'];
    $attrdesc0 = $_POST['attrdesc0'];

    $attrtype0 = !empty($attrtype0) ? "'$attrtype0'" : "NULL";
    $attrdesc0 = !empty($attrdesc0) ? "'$attrdesc0'" : "NULL";

    $addattr0 = mysqli_query($conn,
    "insert into Attraction_In(attr_name, location_id, type, description, num_dollar_signs)
    values ('$attrname0', $loc_id, $attrtype0, $attrdesc0, $attrnumds0)");//DEBUG or die(mysqli_error($conn));
    
    $inclAttr0 = mysqli_query($conn, 
    "insert into IncludesAttraction(trip_id, attr_name, location_id) values ($tripid, '$attrname0', $loc_id)");

}

$attrname1 = $_POST['attrname1'];
if ($attrname1 != "") {
    $attrnumds1 = $_POST['attrnumds1'];
    $attrtype1 = $_POST['attrtype1'];
    $attrdesc1 = $_POST['attrdesc1'];
    
    $attrtype1 = !empty($attrtype1) ? "'$attrtype1'" : "NULL";
    $attrdesc1 = !empty($attrdesc1) ? "'$attrdesc1'" : "NULL";

    $addattr1 = mysqli_query($conn,
    "insert into Attraction_In(attr_name, location_id, type, description, num_dollar_signs)
    values ('$attrname1', $loc_id, $attrtype1, $attrdesc1, $attrnumds1)");//DEBUG or die(mysqli_error($conn));

    $inclAttr1 = mysqli_query($conn, 
    "insert into IncludesAttraction(trip_id, attr_name, location_id) values($tripid, '$attrname1', $loc_id)");
}

$attrname2 = $_POST['attrname2'];
if ($attrname2 != "") {
    $attrnumds2 = $_POST['attrnumds2'];
    $attrtype2 = $_POST['attrtype2'];
    $attrdesc2 = $_POST['attrdesc2'];

    $attrtype2 = !empty($attrtype2) ? "'$attrtype2'" : "NULL";
    $attrdesc2 = !empty($attrdesc2) ? "'$attrdesc2'" : "NULL";

    $addattr2 = mysqli_query($conn,
    "insert into Attraction_In(attr_name, location_id, type, description, num_dollar_signs)
    values ('$attrname2', $loc_id, $attrtype2, $attrdesc2, $attrnumds2)");//DEBUG or die(mysqli_error($conn));

    $inclAttr2 = mysqli_query($conn, 
    "insert into IncludesAttraction(trip_id, attr_name, location_id) values($tripid, '$attrname2', $loc_id)");
}

$actname0 = $_POST['actname0'];
if ($actname0 != "") {
    $actnumds0 = $_POST['actnumds0'];
    $acttype0 = $_POST['acttype0'];
    $actdesc0 = $_POST['actdesc0'];
    
    $acttype0 = !empty($acttype0) ? "'$acttype0'" : "NULL";
    $actdesc0 = !empty($actdesc0) ? "'$actdesc0'" : "NULL";

    $addact0 = mysqli_query($conn,
    "insert into Activity(name, type, num_dollar_signs, description)
    values ('$actname0', $acttype0, $actnumds0, $actdesc0)");//DEBUG or die(mysqli_error($conn));

    $addactloc0 = mysqli_query($conn,
    "insert into IsAt(activity_name, location_id)
    values ('$actname0', $loc_id)");//DEBUG or die(mysqli_error($conn));

    $inclAct0 = mysqli_query($conn, 
    "insert into IncludesActivity(trip_id, activity_name) values($tripid, '$actname0')");
}

$actname1 = $_POST['actname1'];
if ($actname1 != "") {
    $actnumds1 = $_POST['actnumds1'];
    $acttype1 = $_POST['acttype1'];
    $actdesc1 = $_POST['actdesc1'];

    $acttype1 = !empty($acttype1) ? "'$acttype1'" : "NULL";
    $actdesc1 = !empty($actdesc1) ? "'$actdesc1'" : "NULL";

    $addact1 = mysqli_query($conn,
    "insert into Activity(name, type, num_dollar_signs, description)
    values ('$actname1', $acttype1, $actnumds1, $actdesc1)");//DEBUG or die(mysqli_error($conn));

    $addactloc1 = mysqli_query($conn,
    "insert into IsAt(activity_name, location_id)
    values ('$actname1', $loc_id)");//DEBUG or die(mysqli_error($conn));

    $inclAct1 = mysqli_query($conn, 
    "insert into IncludesActivity(trip_id, activity_name) values($tripid, '$actname1')");
}

$actname2 = $_POST['actname2'];
if ($actname2 != "") {
    $actnumds2 = $_POST['actnumds2'];
    $acttype2 = $_POST['acttype2'];
    $actdesc2 = $_POST['actdesc2'];

    $acttype2 = !empty($acttype2) ? "'$acttype2'" : "NULL";
    $actdesc2 = !empty($actdesc2) ? "'$actdesc2'" : "NULL";

    $addact2 = mysqli_query($conn,
    "insert into Activity(name, type, num_dollar_signs, description)
    values ('$actname2', $acttype2, $actnumds2, $actdesc2)");//DEBUG or die(mysqli_error($conn));

    $addactloc2 = mysqli_query($conn,
    "insert into IsAt(activity_name, location_id)
    values ('$actname2', $loc_id)");//DEBUG or die(mysqli_error($conn));

    $inclAct2 = mysqli_query($conn, 
    "insert into IncludesActivity(trip_id, activity_name) values($tripid, '$actname2')");
}

$restname0 = $_POST['restname0'];
if ($restname0 != "") {
    $restnumds0 = $_POST['restnumds0'];
    $resttype0 = $_POST['resttype0'];
    
    $resttype0 = !empty($resttype0) ? "'$resttype0'" : "NULL";

    $addrest0 = mysqli_query($conn,
    "insert into Restaurant(name, cuisine_type, num_dollar_signs)
    values ('$restname0', $resttype0, $restnumds0)");//DEBUG or die(mysqli_error($conn));
    $addrestloc0 = mysqli_query($conn,
    "insert into OperatesAt(restaurant_name, location_id)
    values ('$restname0', $loc_id)");//DEBUG or die(mysqli_error($conn));

    $inclRest0 = mysqli_query($conn, 
    "insert into IncludesRestaurant(trip_id, restaurant_name) values($tripid, '$restname0')");
}

$restname1 = $_POST['restname1'];
if ($restname1 != "") {
    $restnumds1 = $_POST['restnumds1'];
    $resttype1 = $_POST['resttype1'];

    $resttype1 = !empty($resttype1) ? "'$resttype1'" : "NULL";

    $addrest1 = mysqli_query($conn,
    "insert into Restaurant(name, cuisine_type, num_dollar_signs)
    values ('$restname1', $resttype1, $restnumds1)");//DEBUG or die(mysqli_error($conn));
    $addrestloc1 = mysqli_query($conn,
    "insert into OperatesAt(restaurant_name, location_id)
    values ('$restname1', $loc_id)");//DEBUG or die(mysqli_error($conn));

    $inclRest1 = mysqli_query($conn, 
    "insert into IncludesRestaurant(trip_id, restaurant_name) values($tripid, '$restname1')");
}

echo nl2br("things probably worked??? but if you wanna check one by one, uncomment the 'or die' mysqli error handling lines\n\n");
echo nl2br("still left to do: media inputs\n\n");

mysqli_close($conn);

/*
use this to check output

SELECT P.username, T.trip_id, T.title, IR.restaurant_name, R.cuisine_type, R.num_dollar_signs
FROM Plans P, Trip_In T, IncludesRestaurant IR, Restaurant R
WHERE P.trip_id = T.trip_id AND IR.trip_id = T.trip_id AND IR.restaurant_name = R.name;

SELECT P.username, T.trip_id, T.title, I.attr_name, A.type, A.num_dollar_signs
FROM Plans P, Trip_In T, IncludesAttraction I, Attraction_In A
WHERE P.trip_id = T.trip_id AND I.trip_id = T.trip_id AND A.attr_name = I.attr_name AND A.location_id = I.location_id;
 
SELECT P.username, T.trip_id, T.title, IA.activity_name, A.type, A.num_dollar_signs
FROM Plans P, Trip_In T, IncludesActivity IA, Activity A
WHERE P.trip_id = T.trip_id AND IA.trip_id = T.trip_id AND IA.activity_name = A.name;

SELECT * FROM Activity;
SELECT * FROM Attraction_In;
SELECT * FROM Restaurant;

*/
?>