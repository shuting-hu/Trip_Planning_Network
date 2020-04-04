<?php
    // echo '<meta http-equiv="cache-control" content="no-cache">';
    // echo '<meta http-equiv="expires" content="0">';
    // echo '<meta http-equiv="pragma" content="no-cache">';
    include 'connect.php';
    $conn = OpenCon();

    function getAllUsers($dbconn) {        
        $str = "No users were found.";
        $result = mysqli_query($dbconn, "SELECT username FROM Regular_User") or die(mysqli_error($dbconn));
        // echo ($allUsersQ->fetch_assoc())['username'];
        if (mysqli_num_rows($result) > 0) {
            $str = "<label class=\"result-label\">All usernames</label><br>";
            
            while($row = mysqli_fetch_array($result)) {
                $str = $str . $row['username'] . "<br>";
            }
        }
        return $str;
    }

    function getAllLocs($dbconn) {
        $str = "No locations were found.";
        $result = mysqli_query($dbconn, "SELECT city, country FROM Location ORDER BY city, country") or die(mysqli_error($dbconn));
        
        if (mysqli_num_rows($result) > 0) {
            $str = "<br><br><br><label class=\"result-label\">All locations</label><br><br>";
            
            while($row = mysqli_fetch_array($result)) {
                // $str = $str . "<div>" . $row['city'] . ", " . $row['country'] . "</div><br>";
                $str = $str . $row['city'] . ", " . $row['country'] . "<br>";
            }
        }
        // return $str;
        return $str;
    }

    function getAllLocsPop($dbconn) {
        $str = "No locations were found.";
        $result = mysqli_query($dbconn, "SELECT city, country, COUNT(location_id) as num
                                        FROM Location L, Trip_In T
                                        WHERE L.id = T.location_id
                                        GROUP BY city, country
                                        ORDER BY num DESC;") or die(mysqli_error($dbconn));
        
        if (mysqli_num_rows($result) > 0) {
            $str = "<label class=\"result-label\">All locations, sorted by popularity</label>"
            . "<br><br><table class=\"result-table\">"
            . "<tr>"
            .    "<th>Location</th>"
            .    "<th>Frequency</th>"
            . "</tr>";
            
            while($row = mysqli_fetch_array($result)) {
                $str = $str . "<tr><td>" . $row['city'] . ", " . $row['country'] . "</td>"
                . "<td>" . $row['num'] . "</td></tr>";
            }
            $str = $str . "</table>";
        }
        return $str;
    }

    function getAdmins($dbconn) {
        $str = "No admins were found - anarchy ensues.";
        $result = mysqli_query($dbconn, "SELECT name, A.username as `username`, role, email
                                        FROM `Admin` A, All_Users AU
                                        WHERE A.username = AU.username") or die(mysqli_error($dbconn));
        
        if (mysqli_num_rows($result) > 0) {
            $str = "<br><br><label class=\"result-label\">Admin contact info</label>"
            . "<br><br><table class=\"result-table\">"
            // . "<br><br><table class=\"table\">"
            // . "<br><br><table>"
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
            $str = $str . "</table>";
        }
        return $str;
    }

    function getAggregateStats($dbconn) {
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
        
        $str = "<br><br><br><label class=\"result-label\">Total Users</label><br>"
                . "<div class=\"result-single\">" . ($resultu->fetch_assoc())['numu'] . "</div><br><br>"
                // . "<label>Total Admins</label><br>"
                // . ($resulta->fetch_assoc())['numa'] . "<br>"
                . "<label class=\"result-label\">Total Plans</label><br>"
                . "<div class=\"result-single\">" . ($resultp->fetch_assoc())['nump'] . "</div><br><br>"
                . "<label class=\"result-label\">Total Media Uploads</label><br>"
                . "<div class=\"result-single\">" . ($resultm->fetch_assoc())['numm'] . "</div><br><br>"
                . "<label class=\"result-label\">Average Plans Per User</label><br>(excluding users who have never made plans)<br>"
                . "<div class=\"result-single\">" . ($resultavg->fetch_assoc())['average'] . "</div><br>";
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

    function renderNumDollarSigns($numds) {
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

    function getLeaderboards($dbconn) {
        $top5users = mysqli_query($dbconn, "SELECT U.username as us, COUNT(P.trip_id) as num
                                            FROM Regular_User U, Plans P
                                            WHERE U.username = P.username
                                            GROUP BY U.username
                                            ORDER BY num DESC
                                            LIMIT 5;") or die(mysqli_error($dbconn));
        $str = "No users found.";
        if (mysqli_num_rows($top5users) > 0) {
            $str = "<label class=\"result-label\">Top 5 most active users</label>"
            . "<br><br><table class=\"result-table\">"
            . "<tr>"
            .    "<th>Ranking</th>"
            .    "<th>Username</th>"
            .    "<th>Number of plans created</th>"
            . "</tr>";

            $i = 1;
            
            while($row = mysqli_fetch_array($top5users)) {
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
            $str = $str . "<label class=\"result-label\">Top 5 attractions</label>"
            . "<br><br><table class=\"result-table\">"
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
            
            while($row = mysqli_fetch_array($top5attrs)) {
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
            $str = $str . "<label class=\"result-label\">Top 5 activities</label>"
            . "<br><br><table class=\"result-table\">"
            . "<tr>"
            .    "<th>Ranking</th>"
            .    "<th>Activity</th>"
            .    "<th>Type</th>"
            .    "<th>Price</th>"
            .    "<th>Frequency</th>"
            . "</tr>";

            $i = 1;
            
            while($row = mysqli_fetch_array($top5acts)) {
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
            $str = $str . "<label class=\"result-label\">Top 5 restaurants</label>"
            . "<br><br><table class=\"result-table\">"
            . "<tr>"
            .    "<th>Ranking</th>"
            .    "<th>Restaurant</th>"
            .    "<th>Cuisine type</th>"
            .    "<th>Price</th>"
            .    "<th>Frequency</th>"
            . "</tr>";

            $i = 1;
            
            while($row = mysqli_fetch_array($top5rests)) {
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


    function getTrophies($dbconn) {
        $str = "<br><br><label class=\"result-label\">Achievement:  First!</label><br>For the authors of the oldest post(s).<br>";
        $first = mysqli_query($dbconn, "SELECT DISTINCT U.username as us, M.date as mindate
                                        FROM Posts P, Media M, Regular_User U, Trip_In T, Plans Pl
                                        WHERE P.post_id = M.post_id AND T.trip_id = P.trip_id AND Pl.trip_id = T.trip_id AND Pl.username = U.username
                                        AND M.date = (SELECT MIN(date) FROM Media);") or die(mysqli_error($dbconn));

        if (mysqli_num_rows($first) > 0) {
            $str = $str . "<table class=\"result-table\">"
            . "<tr>"
            .    "<th>Username</th>"
            .    "<th>Date of first post</th>"
            . "</tr>";
            
            while($row = mysqli_fetch_array($first)) {
                $str = $str . "<tr>"
                . "<td>" . $row['us'] . "</td>"
                . "<td>" . $row['mindate'] . "</td></tr>";
            }
            $str = $str . "</table><br><br>";
        } else {
            $str = $str . "No one has this achievement yet.<br>";
        }

        $str = $str . "<label class=\"result-label\">Achievement:  O M N I P R E S E N C E</label><br>"
        . "For users who have made plans for every location in here. Advengers assemble!<br>";
        

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
            $str = $str . "<table class=\"result-table\">"
            . "<tr>"
            .    "<th>Username</th>"
            . "</tr>";
            
            while($row = mysqli_fetch_array($allL)) {
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
    <style> /* from https://www.w3schools.com/howto/howto_css_overlay.asp */
        * {
            font-family: sans-serif;
        }

        /*
            position: fixed;
            overflow-y: scroll; 
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(214, 208, 238, 0.9);
            z-index: 2;
            cursor: pointer;
         */
        #overlay {
            position: fixed;
            overflow-y: scroll; 
            display: none;
            width: 700px;
            height: 600px;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background: #FFFFFF;
            border: 5px solid #000000;
            box-sizing: border-box;
            box-shadow: -3px 3px 3px rgba(0, 0, 0, 0.25);
            border-radius: 15px;
            z-index: 2;
            cursor: pointer;
        }

        /* #overlay {
            position: fixed;
            overflow-y: scroll; 
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(214, 208, 238, 0.9);
            z-index: 2;
            cursor: pointer;
        } */
        #results {
            text-align: center;
        }

        .result-label {
            color: black;
            font-weight: bold;
            font-size: 20px;
        }

        .result-single {
            font-size: 26px;
        }

        .result-table {
            margin: 0 auto;
            border-collapse: collapse;
        }
        .result-table th {
            border: 1px solid #ddd;
            padding-top: 12px;
            padding-left: 6px;
            padding-right: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #b4abd9;
            color: white;
        }
        .result-table td {
            border: 1px solid #ddd;
            padding-top: 6px;
            padding-left: 6px;
            padding-right: 12px;
            padding-bottom: 6px;
            text-align: left;
        }

        .stats {
            background-color: #E9E3FF;
            color: black;
            width: 300px;
            margin-top: 5px;
            padding: 5px;
            font-style: normal;
            font-weight: normal;
            font-size: 16px;
            line-height: 15px;
            text-align: center;
            border: 2.5px solid black;
            box-sizing: border-box;
            box-shadow: -2px 2px 3px rgba(0, 0, 0, 0.25);
            border-radius: 25px;
        }
        
        #text{
            position: absolute;
            top: 50%;
            left: 50%;
            font-size: 50px;
            color: rgb(0, 0, 0);
            transform: translate(-50%,-50%);
            -ms-transform: translate(-50%,-50%);
        }
    </style>
</head>
<body>
    try refreshing the page if changes do not appear immediately.
    <br>
    <button class="stats" onclick="on('<?php echo htmlspecialchars(getAdmins($conn)); ?>')" type="button">Contact admins &#x1F9D0;</button>
    <br>
    <button class="stats" onclick="on('<?php echo htmlspecialchars(getAllLocs($conn)); ?>')" type="button">View all locations &#x1F30E;</button>
    <br>
    <button class="stats" onclick="on('<?php echo htmlspecialchars(getAllLocsPop($conn)); ?>')" type="button">View all locations by most popular &#x1F30E;</button>
    <br>
    <button class="stats" onclick="on('<?php echo htmlspecialchars(getAggregateStats($conn)); ?>')" type="button">Stats for nerds &#x1F913;</button>
    <br>
    <button class="stats" onclick="on('<?php echo htmlspecialchars(getLeaderboards($conn)); ?>')" type="button">Leaderboard &#x1F929;</button>
    <br>
    <button class="stats" onclick="on('<?php echo htmlspecialchars(getTrophies($conn)); ?>')" type="button">Trophy case &#x1F3C6;</button>
    <br>

    <!-- adapted from https://www.w3schools.com/howto/howto_css_overlay.asp -->
    <!--  onkeydown="off()" not working -->
    <div id="overlay" onclick="off()">
        <div style="overflow-y:scroll;" id="results"></div>
    </div>

    <script>
    function on(str) {
        document.getElementById("results").innerHTML = "<br>" + str + "<br>Click anywhere to exit.<br>";
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