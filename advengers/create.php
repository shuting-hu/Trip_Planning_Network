<?php
session_start();
$username = $_SESSION["username"];
// redirects to login if no active session
if (!isset($username)) {
    header("location: login.html");
}

// IF THERE IS TIME--
// TODO: refactoring -- move css into separate css file
// TODO: fix line breaking, move form box down so it doesnt overlap with header

?>

<html>
<head>
    <title>Create Plan</title>
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <style>
        * {
            font-family: sans-serif;
        }

        body {
            /* background-color: #72669A; */
            background-image: url("images/webpage/bkgd.png");
            background-repeat: no-repeat;
            height: 100%;
            /* background-position: center; */
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment:fixed;
            background-position:center bottom;
        }

        .form_heading1 {
            font-weight: bold;
            font-size: 18px;
            line-height: 1.6;
        }
        
        .form_heading2 {
            
        }

        .form_instr {

        }

        #form_wrapper {
            position: fixed;
            /* top: 100px; */
            overflow-y: scroll;
            width: 700px;
            height: 800px;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.9);
            border: 5px solid #000000;
            box-sizing: border-box;
            box-shadow: -3px 3px 3px rgba(0, 0, 0, 0.25);
            border-radius: 15px;
            z-index: 2;
            /* cursor: pointer; */
            padding: 50px;
        }

        .btn_submit {
            background-color: #E9E3FF;
            color: black;
            width: 150px;
            margin-top: 5px;
            padding: 5px;
            font-style: normal;
            font-weight: bold;
            font-size: 18px;
            line-height: 30px;
            text-align: center;
            border: 5px solid black;
            box-sizing: border-box;
            box-shadow: -3px 3px 3px rgba(0, 0, 0, 0.25);
            border-radius: 25px;
            transition-duration: 0.3s;
            cursor: pointer;
        }
        .btn_submit:hover {
            background-color: #4A3D79;
            color: white;
        }

        input[type=text] {
            width: 40%;
            font-size: 14px;
            padding: 6px 6px;
            margin: 4px 0;
            box-sizing: border-box;
            border: 1px solid #555;
            outline: none;
        }

        input[type=text]:focus {
            /* position: fixed; */
            background-color: #E9E3FF;
        }

        #btn_home {
            cursor: pointer;
        }

        .header { 
            /* this somehow works as a sticky header idek what i did */
            width: 100%;
            height: 50px;
            position: fixed;
            top: 0;
            left: 0;
            /* background: #cac3e4; */
            background: rgba(255, 255, 255, 0);
        }

        #btn_home {
            position: absolute;
            top: 8px;
            left: 8px;
            max-height: 35px;
            width: auto;
            height: auto;
            vertical-align: middle;
            padding-top: 2px;
            padding-left: 6px;
            padding-bottom: 1px;
        }

        .overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            width: 100%;
            opacity: 0;
            transition: .2s ease;
            background-color: rgba(255, 255, 255, 0);
        }

        .header:hover .overlay {
            opacity: 1;
        }

        #btn_home2 {
            cursor: pointer;
            max-height: 48px; 
            width: auto;
            height: auto;
            vertical-align: middle;
            padding-top: 0px;
            padding-left: 12px;
            padding-bottom: 20px;
        }

        textarea {
            font-size: 12px;
        }

        textarea:focus {
            background-color: #E9E3FF;
        }
        

    </style>
    <script>
        function goHome() {
            window.location = "index.php";
        }

    </script>
</head>
<body>
    <div class="header">
        <!-- <img id="btn_home" src="images/webpage/dinosoar.png" onclick="goHome()" width="100" height="100"> -->
        <img id="btn_home" src="images/webpage/origami.png" onclick="goHome()" width="100" height="100">
        <div class="overlay">
            <img src="images/webpage/dinosoar.png" onclick="goHome()" alt="fly home!" id="btn_home2">
        </div>
    </div>
    
    <div id="form_wrapper">
    <form id="form" action="" method="post" enctype="multipart/form-data">
        <label class="form_heading1">About</label><br>
        <label for="titlebox">trip plan title</label><br>
        
        <input id="titlebox" name="title" type="text" maxlength="70" value="paris tour!" required><br>
        <label for="descbox">description</label><br>
        <input id="descbox" name="desc" type="text" maxlength="280" value="eating baguettes all day"><br><br>
        
        <label class="form_heading1">Location</label><br>
        <label for="citybox">city</label>
        <br>
        <input id="citybox" name="city" type="text" maxlength="70" value="Paris" required>
        <br>
        <label for="provbox">province</label>
        <br>
        <input id="provbox" name="province" type="text" maxlength="70" placeholder="optional">
        <br>
        <label for="countrybox">country</label>
        <br>
        <input id="countrybox" name="country" type="text" maxlength="70" value="France" required>
        <br><br>
        
        <label class="form_heading1">Duration</label><br>
        <div class="radio toolbar">
            <input type="radio" name="duration" id="daytrip" value="daytrip" checked="checked"><label for="daytrip">daytrip</label><br>
            <input type="radio" name="duration" id="1week" value="1 week trip"><label for="1week">1 week trip</label><br>
            <input type="radio" name="duration" id="2weeks" value="2 weeks+ trip"><label for="2weeks">2 weeks+ trip</label><br>
        </div>
        <br>

        <label class="form_heading1">Attractions</label>
        <br>
        <label class="form_heading2">attraction 1.</label><br>
        <input name="attrname0" type="text" value="arc de triomphe" placeholder="name" maxlength="70">
        <input type="radio" name="attrnumds0" value=0 checked="checked"><label>FREE</label>
        <input type="radio" name="attrnumds0" value=1><label>$</label>
        <input type="radio" name="attrnumds0" value=2><label>$$</label>
        <input type="radio" name="attrnumds0" value=3><label>$$$</label><br>
        <input name="attrtype0" type="text" value="monument" placeholder="type" maxlength="70">
        <input name="attrdesc0" type="text" value="big old fancy doorway" placeholder="description" maxlength="280">
        <br><br>
        <label class="form_heading2">attraction 2.</label><br>
        <input name="attrname1" type="text" value="eiffel tower" placeholder="name" maxlength="70">
        <input type="radio" name="attrnumds1" value=0 checked="checked"><label>FREE</label>
        <input type="radio" name="attrnumds1" value=1><label>$</label>
        <input type="radio" name="attrnumds1" value=2><label>$$</label>
        <input type="radio" name="attrnumds1" value=3><label>$$$</label><br>
        <input name="attrtype1" type="text" value="monument" placeholder="type" maxlength="70">
        <input name="attrdesc1" type="text" placeholder="description" maxlength="280">
        <br><br>
        <label class="form_heading2">attraction 3.</label><br>
        <input name="attrname2" type="text" placeholder="name" maxlength="70">
        <input type="radio" name="attrnumds2" value=0 checked="checked"><label>FREE</label>
        <input type="radio" name="attrnumds2" value=1><label>$</label>
        <input type="radio" name="attrnumds2" value=2><label>$$</label>
        <input type="radio" name="attrnumds2" value=3><label>$$$</label><br>
        <input name="attrtype2" type="text" placeholder="type" maxlength="70">
        <input name="attrdesc2" type="text" placeholder="description" maxlength="280">

        <br><br><br>
        <label class="form_heading1">Activities</label><br>
        <label class="form_heading2">activity 1.</label><br>
        <input name="actname0" type="text" value="hiking" placeholder="name" maxlength="70">
        <input type="radio" name="actnumds0" value=0 checked="checked"><label>FREE</label>
        <input type="radio" name="actnumds0" value=1><label>$</label>
        <input type="radio" name="actnumds0" value=2><label>$$</label>
        <input type="radio" name="actnumds0" value=3><label>$$$</label><br>
        <input name="acttype0" type="text" value="nature" placeholder="type" maxlength="70">
        <input name="actdesc0" type="text" value="walking up a mountain for fun" placeholder="description" maxlength="280">
        <br><br>
        <label class="form_heading2">activity 2.</label><br>
        <input name="actname1" type="text" value="tour of palace of versailles" placeholder="name" maxlength="70">
        <input type="radio" name="actnumds1" value=0 checked="checked"><label>FREE</label>
        <input type="radio" name="actnumds1" value=1><label>$</label>
        <input type="radio" name="actnumds1" value=2><label>$$</label>
        <input type="radio" name="actnumds1" value=3><label>$$$</label><br>
        <input name="acttype1" type="text" value="historical" placeholder="type" maxlength="70">
        <input name="actdesc1" type="text" placeholder="description" maxlength="280">
        <br><br>
        <label class="form_heading2">activity 3.</label><br>
        <input name="actname2" type="text" placeholder="name" maxlength="70">
        <input type="radio" name="actnumds2" value=0 checked="checked"><label>FREE</label>
        <input type="radio" name="actnumds2" value=1><label>$</label>
        <input type="radio" name="actnumds2" value=2><label>$$</label>
        <input type="radio" name="actnumds2" value=3><label>$$$</label><br>
        <input name="acttype2" type="text" placeholder="type" maxlength="70">
        <input name="actdesc2" type="text" placeholder="description" maxlength="280">
        
        <br><br><br>
        <label class="form_heading1">Restaurants</label><br>
        <label class="form_heading2">restaurant 1.</label><br>
        <input name="restname0" type="text" value="applebees" placeholder="name" maxlength="70">
        <input type="radio" name="restnumds0" value=1 checked="checked"><label>$</label>
        <input type="radio" name="restnumds0" value=2><label>$$</label>
        <input type="radio" name="restnumds0" value=3><label>$$$</label><br>
        <input name="resttype0" type="text" value="fast food" placeholder="type" maxlength="70">
        <br><br>
        <label class="form_heading2">restaurant 2.</label><br>
        <input name="restname1" type="text" placeholder="name" maxlength="70">
        <input type="radio" name="restnumds1" value=1 checked="checked"><label>$</label>
        <input type="radio" name="restnumds1" value=2><label>$$</label>
        <input type="radio" name="restnumds1" value=3><label>$$$</label><br>
        <input name="resttype1" type="text" placeholder="type" maxlength="70">
        <br><br>
        <label class="form_heading2">restaurant 3.</label><br>
        <input name="restname2" type="text" placeholder="name" maxlength="70">
        <input type="radio" name="restnumds2" value=1 checked="checked"><label>$</label>
        <input type="radio" name="restnumds2" value=2><label>$$</label>
        <input type="radio" name="restnumds2" value=3><label>$$$</label><br>
        <input name="resttype2" type="text" placeholder="type" maxlength="70">

        <br><br><br>
        <label class="form_heading1">Media</label><br>
        <label class="form_heading2">photos.</label><br>
        <label class="form_instr">select multiple images to upload:</label>
        <br>
        <!-- https://www.w3schools.com/php/php_file_upload.asp -->
        <input type="file" name="fileToUpload[]" />
        <input name="caption0" type="text" placeholder="Caption image" maxlength="280" />
        <br>
        <input type="file" name="fileToUpload[]" />
        <input name="caption1" type="text" placeholder="Caption image" maxlength="280"/>
        <br>
        <input type="file" name="fileToUpload[]" />
        <input name="caption2" type="text" placeholder="Caption image" maxlength="280"/>

        <br>
        <br>
        <label class="form_heading2">videos. </label><br>
        <input name="yt0" type="text" value="https://www.youtube.com/watch?v=wFyzZFpLeBk" placeholder="YouTube link" maxlength="70"><br>
        <input name="yt1" type="text" placeholder="YouTube link" maxlength="70"><br>
        <input name="yt2" type="text" placeholder="YouTube link" maxlength="70">
        <br>
        <br>
        <label class="form_heading2">reviews, comments. </label><br>
        <textarea name="text0" value="aaa" placeholder="Type here..." rows="4" cols="50" maxlength="280"></textarea>
        <br>
        <textarea name="text1" placeholder="Type here..." rows="4" cols="50" maxlength="280"></textarea>
        
        <br><br><br>
        <input type="submit" disabled style="display: none" aria-hidden="true"></button>
        <button name="submit" type="submit" class="btn_submit">Submit</button>
    </form>
</body>
</html>
<?php

include 'connect.php';

$done_create_flag = false;


function sanitizeStr($str) {
    $str = str_replace("'", "\'", $str);
    $str = trim($str);
    $str = !empty($str) ? "'$str'" : "NULL"; // to allow for ez string concat
    return $str;
}

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
    $ytregex = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';
    // REGEX PATTERN FROM https://stackoverflow.com/questions/13476060/validating-youtube-url-using-regex
    // ~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x
    $yt_default = 'https://youtu.be/B3WJaC-7g2c';
    if ($yt0 != "") {
        $addmedia0 = mysqli_query($dbconn, "insert into media(date, type) values ('$date0', 3)");
        $mediaid0 = mysqli_insert_id($dbconn);
        if (preg_match($ytregex, $yt0) === 1) {
            $addyt0 = mysqli_query($dbconn, "insert into video(post_id, url) values($mediaid0, '$yt0')");
        } else {
            $addyt0 = mysqli_query($dbconn, "insert into video(post_id, url) values($mediaid0, '$yt_default')");
        }
        $addposts0 = mysqli_query($dbconn, "insert into posts(post_id, trip_id) values($mediaid0, $tripid0)");
        $addtags0 = mysqli_query($dbconn, "insert into tags(post_id, location_id) values($mediaid0, $loc_id0)");
    }
}

// addYT($_POST['yt0'], $conn, $date, $tripid, $loc_id);
// addYT($_POST['yt1'], $conn, $date, $tripid, $loc_id);
// addYT($_POST['yt2'], $conn, $date, $tripid, $loc_id);

function addTxt($txt0, $dbconn, $date0, $tripid0, $loc_id0) {
    if ($txt0 != "") {
        $txt0 = sanitizeStr($txt0);
        // echo $txt0;
        $addmedia0 = mysqli_query($dbconn, "insert into media(date, type) values ('$date0', 1)") or die(mysqli_error($dbconn));
        $mediaid0 = mysqli_insert_id($dbconn);
        $addtxt0 = mysqli_query($dbconn, "insert into text(post_id, words) values($mediaid0, $txt0)") or die(mysqli_error($dbconn));
        $addposts0 = mysqli_query($dbconn, "insert into posts(post_id, trip_id) values($mediaid0, $tripid0)") or die(mysqli_error($dbconn));
        $addtags0 = mysqli_query($dbconn, "insert into tags(post_id, location_id) values($mediaid0, $loc_id0)") or die(mysqli_error($dbconn));
    }
}

if (isset($_POST["submit"])) {
    $conn = OpenCon();
    // FOR TESTING - FILL IN LATER
    // $testuser = "insert into `All_Users`(username, password, name)
    //     values('test', 'abc', 'joe');";
    // $testuserresult = mysqli_query($conn, $testuser);
    // $testuserresult = mysqli_query($conn, "insert into Regular_User (username, profile_picture) values('test', NULL)");
    // $author = 'test';
    $author = $username;
    $date = date("Y-m-d");

    $title = sanitizeStr($_POST['title']);
    $desc = sanitizeStr($_POST['desc']);

    $city = sanitizeStr($_POST['city']);
    $province = sanitizeStr($_POST['province']);
    $country = sanitizeStr($_POST['country']);

    $duration = $_POST['duration'];

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

    for ($j = 0; $j < 3; $j++) {
        addAttr($conn, $j, $loc_id, $tripid);
        addAct($conn, $j, $loc_id, $tripid);
        addRest($conn, $j, $loc_id, $tripid);
        addYT($_POST["yt$j"], $conn, $date, $tripid, $loc_id);
    }

    addTxt($_POST['text0'], $conn, $date, $tripid, $loc_id);
    addTxt($_POST['text1'], $conn, $date, $tripid, $loc_id);

    // $target_dir = "uploads/$author/";
    $target_dir = "images/posts/$author/";
    $countfiles = 3;

    for ($i = 0; $i<$countfiles; $i++) {
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
        // echo nl2br("TARGET IS: $target_file\n");
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        if (empty($_FILES["fileToUpload"]["tmp_name"][$i])) {
            // echo "exiting, no image provided";
            continue;
        }

        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$i]);
        if($check !== false) {
            // echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            // echo "File is not an image.";
            $uploadOk = 0;
            continue;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            continue;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $imgname = basename($_FILES["fileToUpload"]["name"][$i]);
            // echo nl2br("\n\nSorry, file $imgname already exists. Please rename the file and try again.\n\n");
            $uploadOk = 0;
            continue;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            // echo "Sorry, your file was not uploaded.";

        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
                // echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                $addMedia = mysqli_query($conn, "insert into media (date, type) values ('$date', 2)") or die(mysqli_error($conn));
                $mediaid = mysqli_insert_id($conn);
                $cap = $_POST["caption$i"];
                $cap = sanitizeStr($cap);
                // echo $cap;
                $addPhoto = mysqli_query($conn, "insert into photo(post_id, caption, file_path) values($mediaid, $cap, '$target_file')") or die(mysqli_error($conn));
                $addposts0 = mysqli_query($conn, "insert into posts(post_id, trip_id) values($mediaid, $tripid)") or die(mysqli_error($conn));
                $addtags0 = mysqli_query($conn, "insert into tags(post_id, location_id) values($mediaid, $loc_id)") or die(mysqli_error($conn));
            } else {
                // echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    mysqli_close($conn);
    
    global $done_create_flag;
    $done_create_flag = true;
}

if ($done_create_flag) {
    echo '<script type="text/javascript">
           window.location = "index.php"
      </script>';
}

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
