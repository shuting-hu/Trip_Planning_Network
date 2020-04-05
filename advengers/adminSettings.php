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

    $doneSet = false;

    // check curr pw w db OR if not changing pw
    if ($currpassword == $currpw_db || empty($currpassword)) {
        if (empty($newpassword) && empty($confnewpassword)) { // not changing pw just proceed with name change
            $sqlnm = "UPDATE All_Users SET name='$name' WHERE username='$username'";
            $querynm = mysqli_query($conn, $sqlnm) or die(mysqli_error($conn));
            $sqle = "UPDATE Admin SET email='$email' WHERE username='$username'";
            $querye = mysqli_query($conn, $sqle) or die(mysqli_error($conn));
            // header("location: index.php");
            $doneSet = true;
        } else if ($newpassword == $confnewpassword) { // match then change pw
            $sql = "UPDATE All_Users SET name='$name', password='$newpassword' WHERE username='$username'";
            $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $sqle = "UPDATE Admin SET email='$email' WHERE username='$username'";
            $querye = mysqli_query($conn, $sqle) or die(mysqli_error($conn));
            // header("location: index.php");
            $doneSet = true;
        } else {
            echo '<script type="text/javascript">alert("Oops... new passwords do not match!")</script>';
        }
    } else {
        echo '<script type="text/javascript">alert("Hm... that is not your current password!")</script>';
    }

    // update pfp
    $target_dir = "images/pfp/";
    $pfppath = $target_dir;

    @$target_file = $target_dir . basename($_FILES["newpfp"]["name"]);
    // echo nl2br("TARGET IS: $target_file\n");
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
    // Check if image file is a actual image or fake image
    if (empty($_FILES["newpfp"]["tmp_name"])) {
        // echo "exiting, no image provided";
        // echo '<script type="text/javascript">alert("ERROR, no image given!")</script>';
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
        // echo '<script type="text/javascript">alert("failed!")</script>';

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
            // echo '<script type="text/javascript">alert("it worked!")</script>';
            if ($doneSet) {
                echo '<script type="text/javascript">window.location = "index.php"</script>';
            }
            // header("location: index.php");
        } //else {
            // echo "Sorry, there was an error uploading your file.";
            // echo '<script type="text/javascript">alert("ERROR!")</script>';
        // }
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
            <form action="adminSettings.php" method="post" enctype="multipart/form-data">
                <div class="placeholder">
                    <h1><?php getUser() ?></h1>
                    <h4>[<?php getRole() ?>]</h4>
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
                    <?php
                    // echo '<meta http-equiv="cache-control" content="no-cache">';
                    // echo '<meta http-equiv="expires" content="0">';
                    // echo '<meta http-equiv="pragma" content="no-cache">';

                    function getAllUsers($dbconn)
                    {
                        $str = "No users were found.";
                        $result = mysqli_query($dbconn, "SELECT username FROM Regular_User") or die(mysqli_error($dbconn));
                        // echo ($allUsersQ->fetch_assoc())['username'];
                        if (mysqli_num_rows($result) > 0) {
                            $str = "<label>All usernames</label><br>";

                            while ($row = mysqli_fetch_array($result)) {
                                $str = $str . $row['username'] . "<br>";
                            }
                        }
                        return $str;
                    }

                    function getAllLocs($dbconn)
                    {
                        $str = "No locations were found.";
                        $result = mysqli_query($dbconn, "SELECT city, country FROM Location ORDER BY city, country") or die(mysqli_error($dbconn));

                        if (mysqli_num_rows($result) > 0) {
                            $str = "<label>All locations</label><br>";

                            while ($row = mysqli_fetch_array($result)) {
                                $str = $str . $row['city'] . ", " . $row['country'] . "<br>";
                            }
                        }
                        // return $str;
                        return $str;
                    }

                    function getAllLocsPop($dbconn)
                    {
                        $str = "No locations were found.";
                        $result = mysqli_query($dbconn, "SELECT city, country, COUNT(location_id) as num
                                        FROM Location L, Trip_In T
                                        WHERE L.id = T.location_id
                                        GROUP BY city, country
                                        ORDER BY num DESC;") or die(mysqli_error($dbconn));

                        if (mysqli_num_rows($result) > 0) {
                            $str = "<label>All locations</label><br><br><table>"
                                . "<tr>"
                                .    "<th>city, country</th>"
                                .    "<th>number of plans for this location</th>"
                                . "</tr>";

                            while ($row = mysqli_fetch_array($result)) {
                                $str = $str . "<tr><td>" . $row['city'] . ", " . $row['country'] . "</td>"
                                    . "<td>" . $row['num'] . "</td></tr>";
                            }
                            $str = $str . "</table>";
                        }
                        return $str;
                    }

                    function getAdmins($dbconn)
                    {
                        $str = "No admins were found - anarchy ensues.";
                        $result = mysqli_query($dbconn, "SELECT name, A.username as `username`, role, email
                                        FROM `Admin` A, All_Users AU
                                        WHERE A.username = AU.username") or die(mysqli_error($dbconn));

                        if (mysqli_num_rows($result) > 0) {
                            $str = "<label>Admin team contact info</label><br><table>"
                                . "<tr>"
                                .    "<th>Name</th>"
                                .    "<th>Username</th>"
                                .    "<th>Role</th>"
                                .    "<th>Email</th>"
                                . "</tr>";
                            // MAJOR BUG FIX was adding the dots instead of line break :')
                            while ($row = mysqli_fetch_array($result)) {
                                $str = $str . "<tr><td>" . $row['name'] . "</td>"
                                    . "<td>" . $row['username'] . "</td>"
                                    . "<td>" . $row['role'] . "</td>"
                                    . "<td>" . $row['email'] . "</td></tr>";
                            }
                            $str = $str . "</table>";
                        }
                        return $str;
                    }

                    function getAggregateStats($dbconn)
                    {
                        $resultu = mysqli_query($dbconn, "SELECT COUNT(*) AS numu FROM Regular_User");
                        // $resulta = mysqli_query($dbconn, "SELECT COUNT(*) AS numa FROM Admin");
                        $resultp = mysqli_query($dbconn, "SELECT COUNT(*) AS nump FROM Plans");
                        $resultm = mysqli_query($dbconn, "SELECT COUNT(*) AS numm FROM Media");
                        $resultavg = mysqli_query($dbconn, "SELECT AVG(T.numplans) AS average
                                            FROM
                                            (SELECT COUNT(*) AS numplans
                                            FROM Plans P GROUP BY username) AS T;");

                        // TODO - average cost by category

                        // $resultmin = mysqli_query($dbconn, "SELECT MIN(date) AS mindate FROM Media");
                        // $resultmax = mysqli_query($dbconn, "SELECT MAX(date) AS maxdate FROM Media");

                        $str = "<label>Total Users</label><br>"
                            . ($resultu->fetch_assoc())['numu'] . "<br>"
                            // . "<label>Total Admins</label><br>"
                            // . ($resulta->fetch_assoc())['numa'] . "<br>"
                            . "<label>Total Plans</label><br>"
                            . ($resultp->fetch_assoc())['nump'] . "<br>"
                            . "<label>Total Pictures, Videos, Text Posts</label><br>"
                            . ($resultm->fetch_assoc())['numm'] . "<br>"
                            . "<label>Average Plans Per User (excluding users who have never made plans)</label><br>"
                            . ($resultavg->fetch_assoc())['average'] . "<br>";
                        // . "<label>First post made on</label><br>"
                        // . ($resultmin->fetch_assoc())['mindate'] . "<br>"
                        // . "<label>Most recent post made on</label><br>"
                        // . ($resultmax->fetch_assoc())['maxdate'] . "<br>";

                        return $str;
                    }

                    /*
    most active users, popular activities, restaurants, and attractions
SELECT U.username as us, COUNT(P.trip_id) as num
FROM Regular_User U, Plans P
WHERE U.username = P.username
GROUP BY U.username
ORDER BY num DESC
LIMIT 5;

SELECT A.name as na, A.type as ty, A.num_dollar_signs as nds, COUNT(*) as num
FROM Activity A, IncludesActivity I
WHERE A.name = I.activity_name
GROUP BY A.name, A.type, A.num_dollar_signs
ORDER BY num DESC
LIMIT 5;

SELECT R.name as na, R.cuisine_type as ct, R.num_dollar_signs as nds, COUNT(*) as num
FROM Restaurant R, IncludesRestaurant I
WHERE R.name = I.restaurant_name
GROUP BY R.name, R.cuisine_type, R.num_dollar_signs
ORDER BY num DESC
LIMIT 5;

SELECT L.city as ci, L.country as co, A.attr_name as an, A.type as ty, A.num_dollar_signs as nds, COUNT(*) as num
FROM Attraction_In A, IncludesAttraction I, Location L
WHERE A.attr_name = I.attr_name AND A.location_id = I.location_id
	AND L.id = A.location_id
GROUP BY A.attr_name, A.type, A.num_dollar_signs, L.city, L.country
ORDER BY num DESC
LIMIT 5;

    */

                    function renderNumDollarSigns($numds)
                    {
                        if ($numds === 0) {
                            return "FREE";
                        } else if ($numds === 1) {
                            return "$";
                        } else if ($numds === 2) {
                            return "$$";
                        } else if ($numds === 3) {
                            return "$$$";
                        } else {
                            return "$";
                        }
                    }

                    function getLeaderboards($dbconn)
                    {
                        $top5users = mysqli_query($dbconn, "SELECT U.username as us, COUNT(P.trip_id) as num
                                            FROM Regular_User U, Plans P
                                            WHERE U.username = P.username
                                            GROUP BY U.username
                                            ORDER BY num DESC
                                            LIMIT 5;") or die(mysqli_error($dbconn));
                        $str = "No users found.";
                        if (mysqli_num_rows($top5users) > 0) {
                            $str = "<label>Top 5 most active users</label><br><table>"
                                . "<tr>"
                                .    "<th>Ranking</th>"
                                .    "<th>Username</th>"
                                .    "<th>Number of plans created</th>"
                                . "</tr>";

                            $i = 1;

                            while ($row = mysqli_fetch_array($top5users)) {
                                $str = $str . "<tr><td>" . $i . "</td>"
                                    . "<td>" . $row['us'] . "</td>"
                                    . "<td>" . $row['num'] . "</td></tr>";
                                $i++;
                            }
                            $str = $str . "</table><br>";
                        }

                        $top5attrs = mysqli_query($dbconn, "SELECT L.city as ci, L.country as co, A.attr_name as an, A.type as ty,
                                            A.num_dollar_signs as nds, COUNT(*) as num
                                            FROM Attraction_In A, IncludesAttraction I, Location L
                                            WHERE A.attr_name = I.attr_name AND A.location_id = I.location_id
                                                AND L.id = A.location_id
                                            GROUP BY A.attr_name, A.type, A.num_dollar_signs, L.city, L.country
                                            ORDER BY num DESC
                                            LIMIT 5;") or die(mysqli_error($dbconn));
                        if (mysqli_num_rows($top5attrs) > 0) {
                            $str = $str . "<label>Top 5 most popular attractions</label><br><table>"
                                . "<tr>"
                                .    "<th>Ranking</th>"
                                .    "<th>City</th>"
                                .    "<th>Country</th>"
                                .    "<th>Attraction</th>"
                                .    "<th>Type</th>"
                                .    "<th>Price</th>"
                                .    "<th>Frequency</th>"
                                . "</tr>";

                            $i = 1;

                            while ($row = mysqli_fetch_array($top5attrs)) {
                                $str = $str . "<tr><td>" . $i . "</td>"
                                    . "<td>" . $row['ci'] . "</td>"
                                    . "<td>" . $row['co'] . "</td>"
                                    . "<td>" . $row['an'] . "</td>"
                                    . "<td>" . $row['ty'] . "</td>"
                                    . "<td>" . renderNumDollarSigns($row['nds']) . "</td>"
                                    . "<td>" . $row['num'] . "</td></tr>";
                                $i++;
                            }
                            $str = $str . "</table><br>";
                        } else {
                            $str = $str . "<br>No attractions found.<br>";
                        }

                        $top5acts = mysqli_query($dbconn, "SELECT A.name as na, A.type as ty, A.num_dollar_signs as nds, COUNT(*) as num
                                            FROM Activity A, IncludesActivity I
                                            WHERE A.name = I.activity_name
                                            GROUP BY A.name, A.type, A.num_dollar_signs
                                            ORDER BY num DESC
                                            LIMIT 5;") or die(mysqli_error($dbconn));
                        if (mysqli_num_rows($top5acts) > 0) {
                            $str = $str . "<label>Top 5 most popular activities</label><br><table>"
                                . "<tr>"
                                .    "<th>Ranking</th>"
                                .    "<th>Activity</th>"
                                .    "<th>Type</th>"
                                .    "<th>Price</th>"
                                .    "<th>Frequency</th>"
                                . "</tr>";

                            $i = 1;

                            while ($row = mysqli_fetch_array($top5acts)) {
                                $str = $str . "<tr><td>" . $i . "</td>"
                                    . "<td>" . $row['na'] . "</td>"
                                    . "<td>" . $row['ty'] . "</td>"
                                    . "<td>" . renderNumDollarSigns($row['nds']) . "</td>"
                                    . "<td>" . $row['num'] . "</td></tr>";
                                $i++;
                            }
                            $str = $str . "</table><br>";
                        } else {
                            $str = $str . "<br>No activities found.<br>";
                        }

                        $top5rests = mysqli_query($dbconn, "SELECT R.name as na, R.cuisine_type as ty, R.num_dollar_signs as nds, COUNT(*) as num
                                            FROM Restaurant R, IncludesRestaurant I
                                            WHERE R.name = I.restaurant_name
                                            GROUP BY R.name, R.cuisine_type, R.num_dollar_signs
                                            ORDER BY num DESC
                                            LIMIT 5;") or die(mysqli_error($dbconn));
                        if (mysqli_num_rows($top5rests) > 0) {
                            $str = $str . "<label>Top 5 most popular restaurants</label><br><table>"
                                . "<tr>"
                                .    "<th>Ranking</th>"
                                .    "<th>Restaurant</th>"
                                .    "<th>Cuisine type</th>"
                                .    "<th>Price</th>"
                                .    "<th>Frequency</th>"
                                . "</tr>";

                            $i = 1;

                            while ($row = mysqli_fetch_array($top5rests)) {
                                $str = $str . "<tr><td>" . $i . "</td>"
                                    . "<td>" . $row['na'] . "</td>"
                                    . "<td>" . $row['ty'] . "</td>"
                                    . "<td>" . renderNumDollarSigns($row['nds']) . "</td>"
                                    . "<td>" . $row['num'] . "</td></tr>";
                                $i++;
                            }
                            $str = $str . "</table><br>";
                        } else {
                            $str = $str . "<br>No restaurants found.<br>";
                        }
                        return $str;
                    }


                    function getTrophies($dbconn)
                    {
                        $str = "<label>Achievement: First!<br>For the authors of the oldest post(s).</label><br>";
                        $first = mysqli_query($dbconn, "SELECT DISTINCT U.username as us, M.date as mindate
                                        FROM Posts P, Media M, Regular_User U, Trip_In T, Plans Pl
                                        WHERE P.post_id = M.post_id AND T.trip_id = P.trip_id AND Pl.trip_id = T.trip_id AND Pl.username = U.username
                                        AND M.date = (SELECT MIN(date) FROM Media);") or die(mysqli_error($dbconn));

                        if (mysqli_num_rows($first) > 0) {
                            $str = $str . "<table>"
                                . "<tr>"
                                .    "<th>Username</th>"
                                .    "<th>Date of first post</th>"
                                . "</tr>";

                            while ($row = mysqli_fetch_array($first)) {
                                $str = $str . "<tr>"
                                    . "<td>" . $row['us'] . "</td>"
                                    . "<td>" . $row['mindate'] . "</td></tr>";
                            }
                            $str = $str . "</table><br>";
                        } else {
                            $str = $str . "No one has this achievement yet.<br>";
                        }

                        $str = $str . "<label>Achievement: O M N I P R E S E N C E<br>"
                            . "For users who have made plans for every location in here. Advengers assemble!</label><br>";


                        $allL = mysqli_query($dbconn, "SELECT DISTINCT username
                                        FROM All_Users U
                                        WHERE NOT EXISTS
                                            (SELECT L.id FROM Location L
                                            WHERE NOT EXISTS
                                                (SELECT T.trip_id
                                                FROM Trip_In T, Plans P
                                                WHERE P.username = U.username
                                                AND P.trip_id = T.trip_id
                                                AND T.location_id = L.id));");
                        if (mysqli_num_rows($allL) > 0) {
                            $str = $str . "<table>"
                                . "<tr>"
                                .    "<th>Username</th>"
                                . "</tr>";

                            while ($row = mysqli_fetch_array($allL)) {
                                $str = $str . "<tr>"
                                    . "<td>" . $row['username'] . "</td></tr>";
                            }
                            $str = $str . "</table><br>";
                        } else {
                            $str = $str . "No one has this achievement yet.<br>";
                        }

                        return $str;
                    }

                    // echo getLeaderboards($conn);

                    // echo getAllUsers($conn);
                    //>>> $allusers = getAllUsers($conn);
                    //$allusers = "$allusers";
                    // echo "$allusers";

                    // echo "'" . htmlspecialchars(getAdmins($conn)) . "'";
                    // echo getAdmins($conn);
                    ?>
                    <html>

                    <head>
                        <style>
                            /* from https://www.w3schools.com/howto/howto_css_overlay.asp */
                            #overlay {
                                position: fixed;
                                /* YESS!! THIS WORKS TO ALLOW SCROLLING */
                                overflow-y: scroll;
                                display: none;
                                width: 100%;
                                height: 100%;
                                top: 0;
                                left: 0;
                                right: 0;
                                bottom: 0;
                                background-color: rgba(233, 227, 255, 0.95);
                                z-index: 2;
                                cursor: pointer;
                            }

                            #text {
                                position: absolute;
                                top: 50%;
                                left: 50%;
                                font-size: 50px;
                                color: rgb(0, 0, 0);
                                transform: translate(-50%, -50%);
                                -ms-transform: translate(-50%, -50%);
                            }
                        </style>
                    </head>

                    <body>
                        Hello Admin, review the latest usage statistics here!
                        <br>
                        <br>
                        <button onclick="on('<?php echo htmlspecialchars(getAdmins($conn)); ?>')" type="button">Contact admins</button>
                        <br>
                        <button onclick="on('<?php echo htmlspecialchars(getAllLocs($conn)); ?>')" type="button">View all locations</button>
                        <br>
                        <button onclick="on('<?php echo htmlspecialchars(getAllLocsPop($conn)); ?>')" type="button">View all locations by most popular</button>
                        <br>
                        <button onclick="on('<?php echo htmlspecialchars(getAggregateStats($conn)); ?>')" type="button">Stats for nerds</button>
                        <br>
                        <button onclick="on('<?php echo htmlspecialchars(getLeaderboards($conn)); ?>')" type="button">Leaderboard</button>
                        <br>
                        <button onclick="on('<?php echo htmlspecialchars(getTrophies($conn)); ?>')" type="button">Trophy case</button>
                        <br>

                        <!-- adapted from https://www.w3schools.com/howto/howto_css_overlay.asp -->
                        <!--  onkeydown="off()" not working -->
                        <div id="overlay" onclick="off()">
                            <div style="overflow-y:scroll;" id="results"></div>
                        </div>

                        <script>
                            function on(str) {
                                document.getElementById("results").innerHTML = "<br><br><br>" + str + "<br>Click anywhere to exit.<br>";
                                document.getElementById("overlay").style.display = "block";
                            }

                            function off() {
                                document.getElementById("overlay").style.display = "none";
                            }
                            // DONE:  trophy case - , omnipresent users (division)

                            // done:  total number of users, total number of media, total number of plans, oldest post
                            //        most popular locations, most active users,
                            //        popular activities, restaurants, attractions by category and num dollar signs
                            //        author of first post

                            /*
    check division
INSERT INTO Trip_In(location_id) values(1);
INSERT INTO Plans(username, trip_id) VALUES ('shuri', LAST_INSERT_ID());
INSERT INTO Trip_In(location_id) values(2);
INSERT INTO Plans(username, trip_id) VALUES ('shuri', LAST_INSERT_ID());
INSERT INTO Trip_In(location_id) values(3);
INSERT INTO Plans(username, trip_id) VALUES ('shuri', LAST_INSERT_ID());
INSERT INTO Trip_In(location_id) values(4);
INSERT INTO Plans(username, trip_id) VALUES ('shuri', LAST_INSERT_ID());
INSERT INTO Trip_In(location_id) values(5);
INSERT INTO Plans(username, trip_id) VALUES ('shuri', LAST_INSERT_ID());
INSERT INTO Trip_In(location_id) values(6);
INSERT INTO Plans(username, trip_id) VALUES ('shuri', LAST_INSERT_ID());
INSERT INTO Trip_In(location_id) values(7);
INSERT INTO Plans(username, trip_id) VALUES ('shuri', LAST_INSERT_ID());
INSERT INTO Trip_In(location_id) values(8);
INSERT INTO Plans(username, trip_id) VALUES ('shuri', LAST_INSERT_ID());
INSERT INTO Trip_In(location_id) values(9);
INSERT INTO Plans(username, trip_id) VALUES ('shuri', LAST_INSERT_ID());
INSERT INTO Trip_In(location_id) values(10);
INSERT INTO Plans(username, trip_id) VALUES ('shuri', LAST_INSERT_ID());
INSERT INTO Trip_In(location_id) values(11);
INSERT INTO Plans(username, trip_id) VALUES ('shuri', LAST_INSERT_ID());
INSERT INTO Trip_In(location_id) values(12);
INSERT INTO Plans(username, trip_id) VALUES ('shuri', LAST_INSERT_ID());


    DIVISION SCRATCH WORK
    SELECT DISTINCT username, city, country
FROM Plans P, Trip_In T, Location L
WHERE T.location_id = L.id AND P.trip_id = T.trip_id
ORDER BY username, city, country;


SELECT DISTINCT city, country
FROM Location L
ORDER BY city, country;

SELECT DISTINCT username
FROM All_Users U
WHERE NOT EXISTS
	(SELECT L.id FROM Location L
	 WHERE NOT EXISTS
        (SELECT T.trip_id
        FROM Trip_In T, Plans P
        WHERE P.username = U.username
         AND P.trip_id = T.trip_id
         AND T.location_id = L.id));
    */
                        </script>
                    </body>

                    </html>
                </p>

            </form>
        </div>

    </div>
</body>

</html>