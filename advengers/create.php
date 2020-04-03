<?php

// DONE TODO - handle uppercase/lowercase?
// DONE TODO - refactor this whole thing lmao
// DONE TODO - caption for photo 

// TODO - make it work for variable user (cookies?)
// if only there were more time :( TODO - editing the form???
// No lol TODO - allow more inputs?
// TODO - reload feed on go back
// TODO - CSS for everything, including CSS for error nothing submitted page

include 'connect.php';

$conn = OpenCon();

if (!isset($_POST["submit"])) {
    echo "error, nothing submitted.";
    exit;
}

// or die(mysqli_error($conn)); to check sql errors

function sanitizeStr($str) {
    $str = str_replace("'", "\'", $str);
    $str = trim($str);
    $str = !empty($str) ? "'$str'" : "NULL"; // to allow for ez string concat
    return $str;
}

// FOR TESTING - FILL IN LATER
$testuser = "insert into `All_Users`(username, password, name)
    values('test', 'abc', 'joe');";
$testuserresult = mysqli_query($conn, $testuser);
$testuserresult = mysqli_query($conn, "insert into Regular_User (username, profile_picture) values('test', NULL)");


$author = 'test';
$date = date("Y-m-d");

$title = sanitizeStr($_POST['title']);
$desc = sanitizeStr($_POST['desc']);

$city = sanitizeStr($_POST['city']);
$province = sanitizeStr($_POST['province']);
$country = sanitizeStr($_POST['country']);

$duration = $_POST['duration'];


// uses auto-increment so dont need to specify pk val
$addloc = "insert into `Location`(country, province, city) values($country, $province, $city);";
$addlocresult = mysqli_query($conn, $addloc);

$loc_id = mysqli_query($conn, "select id from location where lower(country)=lower($country) and lower(city)=lower($city)") or die(mysqli_error($conn));
$loc_id = ($loc_id->fetch_assoc())['id'];


$addtrip = "insert into `Trip_In`(title, location_id, duration, description)
    values($title, $loc_id, '$duration', $desc);";
$addtripresult = mysqli_query($conn, $addtrip);

$tripid = mysqli_insert_id($conn);


$addplans = "insert into Plans(username, trip_id)
    values('$author', $tripid)";
$addplansresult = mysqli_query($conn, $addplans);


function addAttr($dbconn, $i, $loc_idx, $tripidx) {
    $attrname = sanitizeStr($_POST["attrname$i"]);
    if ($attrname !== "NULL") {
        $attrnumds = $_POST["attrnumds$i"];
        $attrtype = sanitizeStr($_POST["attrtype$i"]);
        $attrdesc = sanitizeStr($_POST["attrdesc$i"]);

        $addAttrQ = mysqli_query($dbconn,
        "insert into Attraction_In(attr_name, location_id, type, description, num_dollar_signs)
        values ($attrname, $loc_idx, $attrtype, $attrdesc, $attrnumds)");
        
        $inclAttrQ = mysqli_query($dbconn, 
        "insert into IncludesAttraction(trip_id, attr_name, location_id) values ($tripidx, $attrname, $loc_idx)");
    }
}



function addAct($dbconn, $i, $loc_idx, $tripidx) {
    $actname = sanitizeStr($_POST["actname$i"]);
    if ($actname !== "NULL") {
        $actnumds = $_POST["actnumds$i"];
        $acttype = sanitizeStr($_POST["acttype$i"]);
        $actdesc = sanitizeStr($_POST["actdesc$i"]);

        $addActQ = mysqli_query($dbconn,
        "insert into Activity(name, type, num_dollar_signs, description)
        values ($actname, $acttype, $actnumds, $actdesc)");

        $addActLocQ = mysqli_query($dbconn,
        "insert into IsAt(activity_name, location_id)
        values ($actname, $loc_idx)");

        $inclActQ = mysqli_query($dbconn, 
        "insert into IncludesActivity(trip_id, activity_name) values($tripidx, $actname)");
    }
}

function addRest($dbconn, $i, $loc_idx, $tripidx) {
    $restname = sanitizeStr($_POST["restname$i"]);
    if ($restname !== "NULL") {
        $restnumds = $_POST["restnumds$i"];
        $resttype = sanitizeStr($_POST["resttype$i"]);

        $addRestQ = mysqli_query($dbconn,
        "insert into Restaurant(name, cuisine_type, num_dollar_signs)
        values ($restname, $resttype, $restnumds)");
        $addRestLocQ = mysqli_query($dbconn,
        "insert into OperatesAt(restaurant_name, location_id)
        values ($restname, $loc_idx)");

        $inclRestQ = mysqli_query($dbconn, 
        "insert into IncludesRestaurant(trip_id, restaurant_name) values($tripidx, $restname)");
    }
}




// 1 = text, 2 = photo, 3 = video
function addYT($yt0, $dbconn, $date0, $tripid0, $loc_id0) {
    if ($yt0 != "") {
        $addmedia0 = mysqli_query($dbconn, "insert into media(date, type) values ('$date0', 3)");
        $mediaid0 = mysqli_insert_id($dbconn);
        $addyt0 = mysqli_query($dbconn, "insert into video(post_id, url) values($mediaid0, '$yt0')");
        $addposts0 = mysqli_query($dbconn, "insert into posts(post_id, trip_id) values($mediaid0, $tripid0)");
        $addtags0 = mysqli_query($dbconn, "insert into tags(post_id, location_id) values($mediaid0, $loc_id0)");
    }
}

for ($j = 0; $j < 3; $j++) {
    addAttr($conn, $j, $loc_id, $tripid);
    addAct($conn, $j, $loc_id, $tripid);
    addRest($conn, $j, $loc_id, $tripid);
    addYT($_POST["yt$j"], $conn, $date, $tripid, $loc_id);
}

// addYT($_POST['yt0'], $conn, $date, $tripid, $loc_id);
// addYT($_POST['yt1'], $conn, $date, $tripid, $loc_id);
// addYT($_POST['yt2'], $conn, $date, $tripid, $loc_id);

function addTxt($txt0, $dbconn, $date0, $tripid0, $loc_id0) {
    if ($txt0 != "") {
        //$txt0 = htmlspecialchars($txt0);
        $txt0 = sanitizeStr($txt0);
        echo $txt0;
        $addmedia0 = mysqli_query($dbconn, "insert into media(date, type) values ('$date0', 1)") or die(mysqli_error($dbconn));
        $mediaid0 = mysqli_insert_id($dbconn);
        $addtxt0 = mysqli_query($dbconn, "insert into text(post_id, words) values($mediaid0, $txt0)") or die(mysqli_error($dbconn));
        $addposts0 = mysqli_query($dbconn, "insert into posts(post_id, trip_id) values($mediaid0, $tripid0)") or die(mysqli_error($dbconn));
        $addtags0 = mysqli_query($dbconn, "insert into tags(post_id, location_id) values($mediaid0, $loc_id0)") or die(mysqli_error($dbconn));
    }
}

addTxt($_POST['text0'], $conn, $date, $tripid, $loc_id);
addTxt($_POST['text1'], $conn, $date, $tripid, $loc_id);


$target_dir = "uploads/$author/";
// count files by shotsy - https://stackoverflow.com/questions/37363231/how-to-count-number-of-uploaded-files-in-php
// for loop -  https://makitweb.com/multiple-files-upload-at-once-with-php/
// $countfiles = count(array_filter($_FILES['fileToUpload']['name']));
// echo "aaaa";
// echo $countfiles;
// echo "aaaa";
$countfiles = 3;

for ($i = 0; $i<$countfiles; $i++) {
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
    echo nl2br("TARGET IS: $target_file\n");
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    if (empty($_FILES["fileToUpload"]["tmp_name"][$i])) {
        echo "exiting, no image provided";
        continue;
    }

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$i]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
        continue;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        continue;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $imgname = basename($_FILES["fileToUpload"]["name"][$i]);
        echo nl2br("\n\nSorry, file $imgname already exists. Please rename the file and try again.\n\n");
        $uploadOk = 0;
        continue;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
            $addMedia = mysqli_query($conn, "insert into media (date, type) values ('$date', 2)") or die(mysqli_error($conn));
            $mediaid = mysqli_insert_id($conn);
            $cap = $_POST["caption$i"];
            $cap = sanitizeStr($cap);
            echo $cap;
            $addPhoto = mysqli_query($conn, "insert into photo(post_id, caption, file_path) values($mediaid, $cap, '$target_file')") or die(mysqli_error($conn));
            $addposts0 = mysqli_query($conn, "insert into posts(post_id, trip_id) values($mediaid, $tripid)") or die(mysqli_error($conn));
            $addtags0 = mysqli_query($conn, "insert into tags(post_id, location_id) values($mediaid, $loc_id)") or die(mysqli_error($conn));
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
echo nl2br("\n\n hello world \n\n");

mysqli_close($conn);

/*
use this to check output


SELECT P.username, T.trip_id, T.location_id, T.title, IR.restaurant_name, R.cuisine_type, R.num_dollar_signs
FROM Plans P, Trip_In T, IncludesRestaurant IR, Restaurant R
WHERE P.trip_id = T.trip_id AND IR.trip_id = T.trip_id AND IR.restaurant_name = R.name;

SELECT P.username, T.trip_id, T.location_id, T.title, I.attr_name, A.type, A.num_dollar_signs
FROM Plans P, Trip_In T, IncludesAttraction I, Attraction_In A
WHERE P.trip_id = T.trip_id AND I.trip_id = T.trip_id AND A.attr_name = I.attr_name AND A.location_id = I.location_id;
 
SELECT P.username, T.trip_id, T.location_id, T.title, IA.activity_name, A.type, A.num_dollar_signs
FROM Plans P, Trip_In T, IncludesActivity IA, Activity A
WHERE P.trip_id = T.trip_id AND IA.trip_id = T.trip_id AND IA.activity_name = A.name;

SELECT * FROM Activity;
SELECT * FROM Attraction_In;
SELECT * FROM Restaurant;
SELECT * FROM Location;

SELECT * FROM Video;
SELECT * FROM Text;

*/


?>