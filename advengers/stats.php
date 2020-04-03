<?php
    // echo '<meta http-equiv="cache-control" content="no-cache">';
    // echo '<meta http-equiv="expires" content="0">';
    // echo '<meta http-equiv="pragma" content="no-cache">';
    include 'connect.php';
    $conn = OpenCon();

    function getAllUsers($dbconn) {
    // function getAllUsers() {
        // $dbconn = OpenCon();
        $str = "No users were found.";
        $result = mysqli_query($dbconn, "SELECT username FROM Regular_User") or die(mysqli_error($dbconn));
        // echo ($allUsersQ->fetch_assoc())['username'];
        if (mysqli_num_rows($result) > 0) {
            $str = "<label>All usernames</label><br>";
            // echo "hello";
            while($row = mysqli_fetch_array($result)) {
                $str = $str . $row['username'] . "<br>";
            }
        }
        // mysqli_close($dbconn);
        return $str;
    }

    function getAdmins($dbconn) {
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
            while($row = mysqli_fetch_array($result)) {
                $str = $str . "<tr><td>" . $row['name'] . "</td>"
                . "<td>" . $row['username'] . "</td>"
                . "<td>" . $row['role'] . "</td>"
                . "<td>" . $row['email'] . "</td></tr>";
            }
        }
        return $str . "</table>";
    }

    function getAggregateStats($dbconn) {
        $resultp = mysqli_query($dbconn, "SELECT COUNT(*) AS nump FROM Plans");
        $resultu = mysqli_query($dbconn, "SELECT COUNT(*) AS numu FROM Plans");
        
    }

    // echo getAllUsers($conn);
    //>>> $allusers = getAllUsers($conn);
    //$allusers = "$allusers";
    // echo "$allusers";

    // echo "'" . htmlspecialchars(getAdmins($conn)) . "'";
    // echo getAdmins($conn);


echo '<head>';
echo '    <style>';
echo '        /* from https://www.w3schools.com/howto/howto_css_overlay.asp */';
echo '        #overlay {';
echo '          position: fixed;';
echo '          display: none;';
echo '          width: 100%;';
echo '          height: 100%;';
echo '          top: 0;';
echo '          left: 0;';
echo '          right: 0;';
echo '          bottom: 0;';
echo '          background-color: rgba(198, 151, 240, 0.5);';
echo '          z-index: 2;';
echo '          cursor: pointer;';
echo '        }';
echo '        ';
echo '        #text{';
echo '          position: absolute;';
echo '          top: 50%;';
echo '          left: 50%;';
echo '          font-size: 50px;';
echo '          color: rgb(0, 0, 0);';
echo '          transform: translate(-50%,-50%);';
echo '          -ms-transform: translate(-50%,-50%);';
echo '        }';
echo '        </style>';
echo '</head>';
echo '<body>';
echo 'try refreshing the page if changes do not appear.<br>';
echo '    <button onclick="on(\''. htmlspecialchars(getAllUsers($conn)).'\')" type="button">View all usernames</button>';
echo '    <button onclick="on(\''. htmlspecialchars(getAdmins($conn)) .'\')" type="button">Contact admins</button>';
echo '    <button onclick="on(\''. htmlspecialchars(getAggregateStats($conn)) .'\')" type="button">Stats for nerds</button>';
// echo '    <!-- total number of users, most active users -->';
// echo "    <button onclick='on('$userstats')' type='button'>User stats</button>";
// echo '    <!-- total number of posts, total number of plans, oldest post, author of first post, omnipresent users (divison) -->';
// echo '    <!-- plan == post (use the terms interchangeably) -->';
// echo "    <button onclick='on('$poststats')' type='button'>Post stats</button> ";
// echo '    <!-- all locations, most popular locations -->';
// echo "    <button onclick='on('$locstats')' type='button'>Location stats</button>";
// echo "    <button onclick='on('$trophies')' type='button'>Trophy case</button>";
// echo '    <!-- put several division queries here ^^ (users who have made a plan everyday) (users who have planned for every location) -->';
// echo '    <!--  -->';

echo '    <!-- adapted from https://www.w3schools.com/howto/howto_css_overlay.asp -->';
echo '    <!--  onkeydown="off()" not working -->';
echo '    <div id="overlay" onclick="off()">';
echo '        <div id="results"></div>';
echo '    </div>';

echo '    <script>';
echo '    function on(str) {';
// echo '        location.reload();';
echo '        document.getElementById("results").innerHTML = "<br><br><br>" +str + "<br>Click anywhere to exit.<br>";';
echo '        document.getElementById("overlay").style.display = "block";';
echo '    }';

echo '    function off() {';
echo '        document.getElementById("overlay").style.display = "none";';
echo '    }';
echo '    </script>';
echo '</body>';

    
?>