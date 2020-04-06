<?php
session_start();
$username = $_SESSION["username"];
// redirects to login if no active session
if (!isset($username)) {
    header("location: login.html");
}

include 'connect.php';
$conn = OpenCon();

function sanitizeStr($str)
{
    $str = str_replace("'", "\'", $str);
    $str = trim($str);
    return $str;
}

function getUser()
{
    global $username;
    echo $username;
}

function getName()
{
    global $conn;
    global $username;
    $sql = "SELECT name FROM All_Users WHERE username = '$username'";
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($res);
    echo $row['name'];
}

function getPfp()
{
    global $conn;
    global $username;
    $sql = "SELECT profile_picture FROM regular_user WHERE username = '$username'";
    $rsResult = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = $rsResult->fetch_array(MYSQLI_ASSOC);
    $path = $row['profile_picture'];
    if (empty($path)) {
        echo "<img src='./images/default.png' class='pfp img-responsive' alt='pfp'>";
    } else {
        echo "<img src=$path class='pfp img-responsive' alt='pfp'>";
    }
}

// save changes
if (isset($_POST['btn_save'])) {
    $fullname = $_POST['fullname'];
    $name = sanitizeStr($fullname); // fixer upper
    $currpassword = $_POST['currpassword'];
    $newpassword = $_POST['newpassword'];
    $confnewpassword = $_POST['confnewpassword'];

    $currpw = "SELECT password from All_Users WHERE username='$username'";
    $queryget = mysqli_query($conn, $currpw) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($queryget);
    $currpw_db = $row['password'];

    // $doneSet = false;

    // check curr pw w db OR if not changing pw
    if ($currpassword == $currpw_db || empty($currpassword)) {
        if (empty($newpassword) && empty($confnewpassword)) { // not changing pw just proceed with name change
            $sqlnm = "UPDATE All_Users SET name='$name' WHERE username='$username'";
            $querynm = mysqli_query($conn, $sqlnm) or die(mysqli_error($conn));
            // header("location: index.php");
            // $doneSet = true;
        } else if ($newpassword == $confnewpassword) { // match then change pw
            $sql = "UPDATE All_Users SET name='$name', password='$newpassword' WHERE username='$username'";
            $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            // header("location: index.php");
            // $doneSet = true;
        } else {
            echo '<script type="text/javascript">alert("Oops... new passwords do not match!")</script>';
        }
    } else {
        echo '<script type="text/javascript">alert("Hm... that is not your current password!")</script>';
    }

    $target_dir = "images/pfp/";
    $pfppath = $target_dir;

    @$target_file = $target_dir . basename($_FILES["newpfp"]["name"]);
    // echo nl2br("TARGET IS: $target_file\n");
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (empty($_FILES["newpfp"]["tmp_name"])) {
        // echo "exiting, no image provided";
    }

    @$check = getimagesize($_FILES["newpfp"]["tmp_name"]);
    if ($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        // echo "File is not an image.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    $newname = $pfppath . $username . "." . $imageFileType;

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        // echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        $oldpfp = mysqli_query($conn, "SELECT profile_picture AS pfp
                                        FROM Regular_User
                                        WHERE username = '$username'
                                        AND profile_picture IS NOT NULL") or die(mysqli_error($conn));
        if (mysqli_num_rows($oldpfp) > 0) {
            unlink(($oldpfp->fetch_assoc())['pfp']);
        }

        if (move_uploaded_file($_FILES["newpfp"]["tmp_name"], $newname)) { //$target_file)) {
            // echo "The file ". basename( $_FILES["newpfp"]["name"]). " has been uploaded.";

            $updatepfp = mysqli_query($conn, "UPDATE Regular_User SET profile_picture = '$newname' WHERE username = '$username'") or die(mysqli_error($conn));
            // if ($doneSet) {
            //     echo '<script type="text/javascript">window.location = "index.php"</script>';
            // }

        } // else {
        //     echo "Sorry, there was an error uploading your file.";
        // }
    }
}

if (isset($_POST['btn_cancel'])) {
    header("location: index.php");
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Wanderlist | Settings</title>
    <link href="https://fonts.googleapis.com/css2?family=Muli:ital,wght@0,400;0,500;0,700;0,800;1,800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" href="css/style.css">

    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./bootstrap/css/templates/dashboard.css" rel="stylesheet">
    <link href="./bootstrap/css/templates/offcanvas.css" rel="stylesheet">
    <link href="./bootstrap/css/myappendix.css" rel="stylesheet">

    <style>
        #btn_home1 {
            cursor: pointer;
            max-height: 46px;
            width: auto;
            height: auto;
            vertical-align: middle;
            padding-top: 10px;
            padding-left: 12px;
            padding-bottom: 1px;
        }

        .header { 
            /* this somehow works as a sticky header idek what i did */
            width: 100%;
            height: 50px;
            position: fixed;
            top: 0;
            left: 0;
            background: #E9E3FF;
            /* background: rgba(255, 255, 255, 0); */
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
            max-height: 55px; 
            width: auto;
            height: auto;
            vertical-align: middle;
            padding-top: 2px;
            padding-left: 10px;
            padding-bottom: 7px;
        }

        body {
            background-color: #E9E3FF;
            background-image: url("images/webpage/bkgd.png");
            background-repeat: no-repeat;
            height: 100%;
            background-size: cover;
        }

        .grid {
            display: grid;
            /* margin-left: 500px; */
            /* margin-right: 500px; */
            margin-left: 380px;
            margin-right: 380px;
            /* grid-template-columns: 1fr, 1fr, 1fr; */
        }

        .grid div:nth-child(1) {
            margin-bottom: 50px;
        }

        /* #container {
            position: fixed;
            overflow-wrap: anywhere;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.9);
            border: 5px solid #4A3D79;
            box-sizing: border-box;
            box-shadow: -3px 3px 3px rgba(0, 0, 0, 0.25);
            border-radius: 15px;
            z-index: 2;
            padding: 50px;
        } */

        h1 {
            color: #3E3364;
        }

        h4 {
            color: #4A3D79;
        }

        span {
            transform: rotate(180deg);
            display: inline-block;
        }

        #pfp-shift {
            margin-right: 10%;
            /*sketchyyy*/
        }

        #btn_profile {
            background-color: #E9E3FF;
            color: #4A3D79;
            width: 150px;
            margin-top: 5px;
            padding: 5px;
            font-style: normal;
            font-weight: bold;
            font-size: 18px;
            line-height: 30px;
            text-align: center;
            border: 5px solid #4A3D79;
            box-sizing: border-box;
            border-radius: 25px;
            margin-left: 40px;
            margin-right: 40px;
            transition-duration: 0.3s;
        }

        #btn_profile:hover {
            background-color: #4A3D79;
            color: white;
        }
    </style>
    
    <script>
        function goHome() {
            window.location = "index.php";
        }
    </script>
</head>

<body style="background-color: #E9E3FF">
    <div class="header">
        <img id="btn_home1" src="images/webpage/origami.png" onclick="goHome()" width="100" height="100">
        <div class="overlay">
            <img src="images/webpage/dinosoar.png" onclick="goHome()" alt="fly home!" id="btn_home2">
        </div>
    </div>
    <div>
        <!-- <h3>Edit Profile</h3> -->

        <div class="grid">
            <div style="background-color: white; border: 5px solid #4A3D79; border-radius: 15px; box-sizing: border-box;
            box-shadow: -3px 3px 3px rgba(0, 0, 0, 0.25); padding: 50px; background: rgba(255, 255, 255, 0.9);">
                <center>
                    <form action="userSettings.php" method="post" enctype="multipart/form-data">
                        <div class="placeholder">
                            <h1><b>&#9992;&nbsp;&nbsp;<?php getUser() ?>&nbsp;&nbsp;<span>&#9992;</span></b></h1>
                            <div id="pfp-shift">
                                <?php getPfp() ?><br><br>
                            </div>
                            <h4><b>Change Profile Photo</b></h4>
                            <input type="file" name="newpfp">
                        </div>

                        <p>
                            <h4><b>Name</b></h4>
                            <input type="text" value="<?php getName() ?>" placeholder="Enter your name" name="fullname">
                        </p>
                        <br>

                        <p>
                            <h4><b>Change Password</b></h4>
                            <!-- <label>Current Password:</label><br> -->
                            <input type="text" placeholder="Current password" name="currpassword">
                            <br>
                            <br>
                            <!-- <label>New Password:</label><br> -->
                            <input type="password" placeholder="New password" name="newpassword">
                            <br>
                            <br>
                            <!-- <label>Confirm New Password:</label><br> -->
                            <input type="password" placeholder="Confirm new password" name="confnewpassword">
                            <br>
                        </p>
                        <br>

                        <!-- Cancel and Save buttons -->
                        <button id="btn_profile" name="btn_cancel" type="submit">Return</button>
                        <button id="btn_profile" name="btn_save" type="submit">Save</button>

                    </form>
                </center>
            </div>
        </div>

    </div>
</body>

</html>