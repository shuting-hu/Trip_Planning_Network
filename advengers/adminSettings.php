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

// SEC 1

function getUser()
{
    global $username;
    echo $username . '<br/>';
}

function getRole()
{
    global $conn;
    global $username;
    $sql = "SELECT role FROM Admin WHERE username = '$username'";
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($res);
    echo $row['role'];
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

// ok but this doesn't work for some reason
function getEmail()
{
    global $conn;
    global $username;
    $sql = "SELECT email FROM Admin WHERE username = '$username'";
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($res);
    echo $row['email'];
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

if (isset($_POST['btn_save'])) {
    $fullname = $_POST['fullname'];
    $name = sanitizeStr($fullname); // fixer upper
    $email = $_POST['email'];
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
            $querynm = mysqli_query($conn, $sqlnm) or die(mysqli_error($conn));
            $sqle = "UPDATE Admin SET email='$email' WHERE username='$username'";
            $querye = mysqli_query($conn, $sqle) or die(mysqli_error($conn));
            header("location: index.php");
        } else if ($newpassword == $confnewpassword) { // match then change pw
            $sql = "UPDATE All_Users SET name='$name', password='$newpassword' WHERE username='$username'";
            $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $sqle = "UPDATE Admin SET email='$email' WHERE username='$username'";
            $querye = mysqli_query($conn, $sqle) or die(mysqli_error($conn));
            header("location: index.php");
        } else {
            echo '<script type="text/javascript">alert("Oops... new passwords do not match!")</script>';
        }
    } else {
        echo '<script type="text/javascript">alert("Hm... that is not your current password!")</script>';
    }
}

if (isset($_POST['btn_cancel'])) {
    header("location: index.php");
}

// SEC 2

@$regusername = $_POST['regusername'];
@$regname = $_POST['regname'];
@$regpassword = $_POST['regpassword'];
// monitor users
if (isset($_POST['btn_fetch'])) {
    // echo '<script type="text/javascript">alert("test: viewing user profile")</script>';
    // $regusername = $_POST['regusername'];
    if ($_POST['regusername'] == "") {
        echo '<script type="text/javascript">alert("Please enter username to retrieve user profile")</script>';
    } else {
        $regsql = "SELECT * FROM All_Users WHERE username = '$regusername'";
        $regquery = mysqli_query($conn, $regsql);
        if (mysqli_num_rows($regquery) > 0) {
            $regrow = mysqli_fetch_array($regquery, MYSQLI_ASSOC);
            @$regusername = $regrow['username'];
            @$regname = $regrow['name'];
            @$regpassword = $regrow['password'];
        } else {
            echo '<script type="text/javascript">alert("User does not exist!")</script>';
        }
    }
}

// delete requested user 
if (isset($_POST['btn_delete'])) {
    // echo '<script type="text/javascript">alert("test: user deleted")</script>';
    if ($_POST['regusername'] == "") {
        echo '<script type="text/javascript">alert("Enter user to delete.")</script>';
    } else {
        // can delete non admin
        $sqlflt = "SELECT * FROM Regular_User WHERE username = '$regusername' AND username NOT IN(SELECT username FROM Admin)";
        $queryflt = mysqli_query($conn, $sqlflt) or die(mysqli_error($conn));

        // cannot delete admins, checking just for the petty warning message lol
        $sqladm = "SELECT * FROM Admin WHERE username = '$regusername'";
        $queryadm = mysqli_query($conn, $sqladm) or die(mysqli_error($conn));
        
        if (mysqli_num_rows($queryflt) > 0) {
            $drop = "DELETE FROM All_Users WHERE username='$regusername'";
            $querydel = mysqli_query($conn, $drop) or die(mysqli_error($conn));
            if ($querydel) {
                echo '<script type="text/javascript">alert("User has been deleted.")</script>';
            } else {
                echo '<script type="text/javascript">alert("Error in deleting user.")</script>';
            }
        } else if (mysqli_num_rows($queryadm) > 0) {
            echo '<script type="text/javascript">alert("HEY! Nice try but no deleting your fellow admins OR YOURSELF... tsk tsk")</script>';
        } else { // user DNE
            echo '<script type="text/javascript">alert("User does not exist.")</script>';
        }
    }
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
        <h3>Edit Profile YAYEEET</h3>
        <br>
        <br>

        <div>
            <!-- SEC 1: Edit Profile -->
            <form action="adminSettings.php" method="post">
                <div class="placeholder">
                    <h1><?php getUser() ?></h1>
                    <h4>[<?php getRole() ?>]</h4>
                    <?php getPfp() ?>
                </div>

                <p>
                    <label>Name:</label><br>
                    <input type="text" value="<?php getName() ?>" placeholder="Enter your name" name="fullname">
                </p>
                <br>
                <p>
                    <label>Email:</label><br>
                    <input type="text" value="<?php getEmail() ?>" placeholder="Enter your email" name="email">
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


                <!-- SEC 2: Monitor User (non admins) -->
                <p>
                    <br>
                    <br>
                    <br>
                    <h3>Monitor Users</h3>
                    <br>
                    <label><b>Search by username:</b></label>
                    <br>
                    <input type="text" placeholder="Enter username" name="regusername" value="<?php echo $regusername; ?>">
                    <br>
                    <button id="btn_fetch" name="btn_fetch" type="submit">View User Profile</button>
                    <button id="btn_fetch" name="btn_delete" type="submit">Delete User</button>
                    <br>
                    <br>
                    <label><b>Name:</b></label>
                    <br>
                    <input type="text" placeholder="User's name" name="regname" value="<?php echo $regname; ?>">
                    <br>
                    <br>
                    <label><b>Password:</b></label>
                    <br>
                    <input type="password" placeholder="User's password" name="regpassword" value="<?php echo $regpassword; ?>">
                </p>
                <br>
                <button id="btn_save" name="btn_cancel" type="submit">Home</button>

                <!-- SEC 3: Webpage Stats -->
                <p>
                    <br>
                    <br>
                    <h3>Statistics</h3>
                </p>

            </form>
        </div>

    </div>
</body>

</html>