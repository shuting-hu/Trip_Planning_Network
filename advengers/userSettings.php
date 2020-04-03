<?php
session_start();
$username = $_SESSION["username"];
// redirects to login if no active session
if (!isset($username)) {
    header("location: login.html");
}

include 'connect.php';
$conn = OpenCon();

function getUser()
{
    global $conn;
    global $username;
    echo $username . '<br/>';
}

function getName()
{
    global $conn;
    global $username;
    if (isset($username)) {
        $sql = "SELECT name FROM All_Users WHERE username = '$username'";
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $row = mysqli_fetch_array($res);
        echo $row['name'];
    }
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

function sanitizeStr($str) {
    $str = str_replace("'", "\'", $str);
    $str = trim($str);
    return $str;
}

if(isset($_POST['btn_save'])) {
    $fullname = $_POST['fullname'];
    $name = sanitizeStr($fullname); // fixer upper
    $currpassword = $_POST['currpassword'];
    $newpassword = $_POST['newpassword'];
    $confnewpassword = $_POST['confnewpassword'];

    $currpw = "SELECT password from All_Users WHERE username='$username'";
    $queryget = mysqli_query($conn, $currpw) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($queryget);
    $currpw_db = $row['password'];
    // check curr pw w db OR if not changing pw
    if ($currpassword == $currpw_db || empty($currpassword)) {
        if (empty($newpassword) && empty($confnewpassword)) { // not changing pw just proceed with name change
            $sqlnm = "UPDATE All_Users SET name='$name' WHERE username='$username'";
            $querynm = mysqli_query($conn, $sqlnm);
            header("location: index.php");
        } else if ($newpassword == $confnewpassword) { // match then change pw
            $sql = "UPDATE All_Users SET name='$name', password='$newpassword' WHERE username='$username'";
            $query = mysqli_query($conn, $sql);
            header("location: index.php");
        } else {
            echo '<script type="text/javascript">alert("Oops... new passwords do not match!")</script>';
        }
    } else {
        echo '<script type="text/javascript">alert("Hm... that is not your current password!")</script>';
    }
}

if(isset($_POST['btn_cancel'])) {
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
            <form action="userSettings.php" method="post">
                <div class="placeholder">
                    <h1><?php getUser() ?></h1>
                    <?php getPfp() ?>
                </div>

                <p>
                    <label>Name:</label>
                    <input type="text" value="<?php getName() ?>" name="fullname">
                </p>
                <br>

                <p>
                    <h4>Change Password</h4>
                    <label>Current Password:</label>
                    <input type="text" placeholder="Enter your current password" name="currpassword">
                    <br>
                    <label>New Password:</label>
                    <input type="password" placeholder="Enter your new password" name="newpassword">
                    <br>
                    <label>Confirm New Password:</label>
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