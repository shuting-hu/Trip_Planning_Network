<?php
include 'connect.php';


// sanitize inputs to remove apostrophe for example

$author = 'username of current user';
$date = date("Y-m-d");

$title = $_POST['title'];
$desc = $_POST['desc'];
$city = $_POST['city'];
$province = $_POST['province'];
$country = $_POST['country'];
$duration = $_POST['duration'];

$conn = OpenCon();

// uses auto-increment so dont need to specify pk val
$province = !empty($province) ? "'$province'" : "NULL";
$addloc = "insert into `Location`(country, province, city)
    values('$country', $province, '$city');";
$addlocresult = mysqli_query($conn, $addloc) or die(mysqli_error($conn));

$loc_id = mysqli_query($conn, "select id from location where country='$country' and city='$city'") or die(mysqli_error($conn));
$loc_id = ($loc_id->fetch_assoc())['id'];

$attrname0 = $_POST['attrname0'];
if ($attrname0 != "") {
    $attrnumds0 = $_POST['attrnumds0'];
    $attrtype0 = $_POST['attrtype0'];
    $attrdesc0 = $_POST['attrdesc0'];

    $attrtype0 = !empty($attrtype0) ? "'$attrtype0'" : "NULL";
    $attrdesc0 = !empty($attrdesc0) ? "'$attrdesc0'" : "NULL";

    $addattr0 = mysqli_query($conn,
    "insert into Attraction_In(attr_name, location_id, type, description, num_dollar_signs)
    values ('$attrname0', $loc_id, $attrtype0, $attrdesc0, $attrnumds0)") or die(mysqli_error($conn));
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
    values ('$attrname1', $loc_id, $attrtype1, $attrdesc1, $attrnumds1)") or die(mysqli_error($conn));
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
    values ('$attrname2', $loc_id, $attrtype2, $attrdesc2, $attrnumds2)") or die(mysqli_error($conn));
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
    values ('$actname0', $acttype0, $actnumds0, $actdesc0)")  or die(mysqli_error($conn));

    $addactloc0 = mysqli_query($conn,
    "insert into IsAt(activity_name, location_id)
    values ('$actname0', $loc_id)")  or die(mysqli_error($conn));
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
    values ('$actname1', $acttype1, $actnumds1, $actdesc1)") or die(mysqli_error($conn));

    $addactloc1 = mysqli_query($conn,
    "insert into IsAt(activity_name, location_id)
    values ('$actname1', $loc_id)") or die(mysqli_error($conn));
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
    values ('$actname2', $acttype2, $actnumds2, $actdesc2)") or die(mysqli_error($conn));

    $addactloc2 = mysqli_query($conn,
    "insert into IsAt(activity_name, location_id)
    values ('$actname2', $loc_id)") or die(mysqli_error($conn));
}

$restname0 = $_POST['restname0'];
if ($restname0 != "") {
    $restnumds0 = $_POST['restnumds0'];
    $resttype0 = $_POST['resttype0'];
    
    $resttype0 = !empty($resttype0) ? "'$resttype0'" : "NULL";

    $addrest0 = mysqli_query($conn,
    "insert into Restaurant(name, cuisine_type, num_dollar_signs)
    values ('$restname0', $resttype0, $restnumds0)") or die(mysqli_error($conn));
    $addrestloc0 = mysqli_query($conn,
    "insert into OperatesAt(restaurant_name, location_id)
    values ('$restname0', $loc_id)") or die(mysqli_error($conn));
}

$restname1 = $_POST['restname1'];
if ($restname1 != "") {
    $restnumds1 = $_POST['restnumds1'];
    $resttype1 = $_POST['resttype1'];

    $resttype1 = !empty($resttype1) ? "'$resttype1'" : "NULL";

    $addrest1 = mysqli_query($conn,
    "insert into Restaurant(name, cuisine_type, num_dollar_signs)
    values ('$restname1', $resttype1, $restnumds1)") or die(mysqli_error($conn));
    $addrestloc1 = mysqli_query($conn,
    "insert into OperatesAt(restaurant_name, location_id)
    values ('$restname1', $loc_id)") or die(mysqli_error($conn));
}

echo nl2br("TODO: add media, posts, tags parts, trip, tripincludes stuff\n\n");

?>