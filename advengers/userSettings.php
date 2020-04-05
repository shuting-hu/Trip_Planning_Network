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
    echo $username . '<br/>';
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

// update pfp
/*
if (isset($_POST["submit"])) {
    // $user = 'test';
    $target_dir = "images/pfp/";
    $pfppath = $target_dir;

    @$target_file = $target_dir . basename($_FILES["newpfp"]["name"]);
    echo nl2br("TARGET IS: $target_file\n");
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
    // Check if image file is a actual image or fake image
    if (empty($_FILES["newpfp"]["tmp_name"])) {
        echo "exiting, no image provided";
    }

    @$check = getimagesize($_FILES["newpfp"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    $newname = $pfppath . $username . "." . $imageFileType;

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        $oldpfp = mysqli_query($conn, "SELECT profile_picture AS pfp
                                        FROM Regular_User
                                        WHERE username = '$username'
                                        AND profile_picture IS NOT NULL") or die(mysqli_error($conn));
        if (mysqli_num_rows($oldpfp) > 0) {
            unlink(($oldpfp->fetch_assoc())['pfp']);
        }

        if (move_uploaded_file($_FILES["newpfp"]["tmp_name"], $newname)) {//$target_file)) {
            echo "The file ". basename( $_FILES["newpfp"]["name"]). " has been uploaded.";

            $updatepfp = mysqli_query($conn, "UPDATE Regular_User SET profile_picture = '$newname' WHERE username = '$username'") or die(mysqli_error($conn));
            
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
*/

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
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
    // Check if image file is a actual image or fake image
    if (empty($_FILES["newpfp"]["tmp_name"])) {
        // echo "exiting, no image provided";
    }

    @$check = getimagesize($_FILES["newpfp"]["tmp_name"]);
    if($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        // echo "File is not an image.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
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

        if (move_uploaded_file($_FILES["newpfp"]["tmp_name"], $newname)) {//$target_file)) {
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
    <title>Settings</title>
    <link rel="stylesheet" href="css/style.css">

    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="./bootstrap/css/templates/dashboard.css" rel="stylesheet">
    <link href="./bootstrap/css/templates/offcanvas.css" rel="stylesheet">
    <link href="./bootstrap/css/myappendix.css" rel="stylesheet">
</head>

<body style="background-color: white">
    <div>
        <h3>Edit Profile</h3>
        <br>
        <br>

        <div>
            <form action="userSettings.php" method="post" enctype="multipart/form-data">
                <div class="placeholder">
                    <h1><?php getUser() ?></h1>
                    <?php getPfp() ?><br><br>
                    <label>Upload new profile picture:</label><br>
                    <input type="file" name="newpfp">
                </div>

                <p>
                <br>
                    <label>Name:</label><br>
                    <input type="text" value="<?php getName() ?>" placeholder="Enter your name" name="fullname">
                </p>
                <br>

                <p>
                    <h4>Change Password</h4>
                    <label>Current Password:</label><br>
                    <input type="text" placeholder="Enter your current password" name="currpassword">
                    <br>
                    <label>New Password:</label><br>
                    <input type="password" placeholder="Enter your new password" name="newpassword">
                    <br>
                    <label>Confirm New Password:</label><br>
                    <input type="password" placeholder="Enter your new password again" name="confnewpassword">
                    <br>
                </p>
                <br>

                <!-- Cancel and Save buttons -->
                <button id="btn_save" name="btn_cancel" type="submit">Cancel</button>
                <button id="btn_save" name="btn_save" type="submit">Save</button>

            </form>
        </div>

    </div>
</body>

</html>