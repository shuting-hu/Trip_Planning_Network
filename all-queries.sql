-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
-- TODO: at end, recheck the file locations listed for each query
-- ???
-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!




/* *************************************************
 * DEMO QUERIES
 * *************************************************
 */

/* INSERT
 * Insert a photo associated with a certain trip plan
 * See create.php: $addPhoto
 */
INSERT INTO Photo(post_id, caption, file_path)
VALUES($mediaid, $cap, '$target_file');


/* DELETE
 * Delete a user (admin privilege only)
 * See adminSettings.php: $drop
 */
DELETE FROM All_Users WHERE username='$regusername';


/* UPDATE
 * Update name and password
 * See userSettings.php
 */
UPDATE All_Users SET name='$name', password='$newpassword' WHERE username='$username';


/* SELECTION
 * Search bar query
 * See searchbar-parser.php
 */
CREATE OR REPLACE VIEW Subposts AS
SELECT *
FROM Trip_In
WHERE trip_id IN
        (SELECT trip_id
        FROM Plans
        WHERE username IN ('$wordsStr')
    UNION
        SELECT trip_id
        FROM Trip_In
        WHERE location_id IN
                (SELECT id FROM Location WHERE country IN ('$wordsStr')
            UNION
                SELECT id FROM Location WHERE province IN ('$wordsStr')
            UNION
                SELECT id FROM Location WHERE city IN ('$wordsStr')));


/* PROJECTION
 * TODO - add to searchbar as checkboxes (hide or show attributes)
 * Hide or show different parts of the location hashtags, based on 
 * input to checkboxes.
 * See index.php: parseTags()
 */
select $select from location where id = $location_id;

/* JOIN QUERY
 * Get all locations, sorted by popularity (frequency in trip plans)
 * See stats.php: $result in getAllLocsPop()
 */
SELECT city, country, COUNT(location_id) as num
FROM Location L, Trip_In T
WHERE L.id = T.location_id
GROUP BY city, country
ORDER BY num DESC;


/* AGGREGATION QUERY
 * Find total number of non-admin users
 * See stats.php: $resultu in getAggregateStats()
 */
SELECT COUNT(*) AS numu FROM Regular_User;


/* 
 * NESTED AGGREGATION WITH GROUP BY
 * Find average number of plans per user, excluding users who have never made plans.
 * See stats.php: $resultavg in getAggregateStats()
 */
SELECT AVG(T.numplans) AS average
FROM
(SELECT COUNT(*) AS numplans
FROM Plans P GROUP BY username) AS T;


/*
 * DIVISION QUERY
 * Find users who have made plans for every location
 * See stats.php: $allL in getTrophies()
 */
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



/* *************************************************
 * ALL QUERIES (including the queries above)
 * *************************************************
 */

/* 
 * login.php
 */
SELECT * FROM all_users WHERE username = '$username' AND password = '$password';
SELECT role FROM admin WHERE username = '$username';


/* 
 * register.php
 */
SELECT * FROM All_Users WHERE username = '$username';
INSERT INTO All_Users VALUES ('$username', '$password', '$name');
INSERT INTO Regular_User (username) VALUES ('$username');


/* 
 * searchbar-parser.php
 */
CREATE OR REPLACE VIEW Subposts AS
SELECT *
FROM Trip_In
WHERE trip_id IN
        (SELECT trip_id
        FROM Plans
        WHERE username IN ('$wordsStr')
    UNION
        SELECT trip_id
        FROM Trip_In
        WHERE location_id IN
                (SELECT id FROM Location WHERE country IN ('$wordsStr')
            UNION
                SELECT id FROM Location WHERE province IN ('$wordsStr')
            UNION
                SELECT id FROM Location WHERE city IN ('$wordsStr')));


/* 
 * index.php
 */
select profile_picture from regular_user where username = '$username';
SELECT * FROM Admin WHERE username = '$username';
"SELECT COUNT(*) FROM ".$postSet;
"SELECT * FROM ".$postSet." ORDER BY trip_id DESC LIMIT $offset, $pagesize";

select name, username
from all_users
where username = (select username from plans where trip_id = $trip_id);

select * from location where id = $location_id;
select post_id from posts where trip_id = $trip_id;
"select type from media where post_id = ".$post_id;
select words from text where post_id = $post_id;
select caption, file_path from photo where post_id = $post_id;
select url from video where post_id = $post_id;


/* 
 * create.php
 */
insert into Attraction_In(attr_name, location_id, type, description, num_dollar_signs)
values ($attrname, $loc_idx, $attrtype, $attrdesc, $attrnumds);

insert into IncludesAttraction(trip_id, attr_name, location_id)
values ($tripidx, $attrname, $loc_idx);

insert into Activity(name, type, num_dollar_signs, description)
values ($actname, $acttype, $actnumds, $actdesc);

insert into IsAt(activity_name, location_id)
values ($actname, $loc_idx);

insert into IncludesActivity(trip_id, activity_name)
values($tripidx, $actname);

insert into Restaurant(name, cuisine_type, num_dollar_signs)
values ($restname, $resttype, $restnumds);

insert into OperatesAt(restaurant_name, location_id)
values ($restname, $loc_idx);

insert into IncludesRestaurant(trip_id, restaurant_name)
values($tripidx, $restname);

insert into media(date, type) values ('$date0', 3);
insert into video(post_id, url) values($mediaid0, '$yt0');
insert into video(post_id, url) values($mediaid0, '$yt_default');
insert into posts(post_id, trip_id) values($mediaid0, $tripid0);
insert into tags(post_id, location_id) values($mediaid0, $loc_id0);

insert into media(date, type) values ('$date0', 1);
insert into text(post_id, words) values($mediaid0, $txt0);
insert into posts(post_id, trip_id) values($mediaid0, $tripid0);
insert into tags(post_id, location_id) values($mediaid0, $loc_id0);

insert into `Location`(country, province, city) values($country, $province, $city);
select id from location where lower(country)=lower($country) and lower(city)=lower($city);

insert into `Trip_In`(title, location_id, duration, description)
values($title, $loc_id, '$duration', $desc);

insert into Plans(username, trip_id) values('$author', $tripid);

insert into media (date, type) values ('$date', 2);
insert into photo(post_id, caption, file_path) values($mediaid, $cap, '$target_file');
insert into posts(post_id, trip_id) values($mediaid, $tripid);
insert into tags(post_id, location_id) values($mediaid, $loc_id);


/* 
 * adminSettings.php
 */
SELECT role FROM Admin WHERE username = '$username';
SELECT name FROM All_Users WHERE username = '$username';
SELECT email FROM Admin WHERE username = '$username';
SELECT profile_picture FROM regular_user WHERE username = '$username';
SELECT password from All_Users WHERE username='$username';
UPDATE All_Users SET name='$name' WHERE username='$username';
UPDATE Admin SET email='$email' WHERE username='$username';
UPDATE All_Users SET name='$name', password='$newpassword' WHERE username='$username';
UPDATE Admin SET email='$email' WHERE username='$username';

SELECT profile_picture AS pfp
FROM Regular_User
WHERE username = '$username'
AND profile_picture IS NOT NULL;

UPDATE Regular_User SET profile_picture = '$newname' WHERE username = '$username';
SELECT * FROM All_Users WHERE username = '$regusername'
SELECT * FROM Regular_User WHERE username = '$regusername' AND username NOT IN(SELECT username FROM Admin);
SELECT * FROM Admin WHERE username = '$regusername';
DELETE FROM All_Users WHERE username='$regusername';


/*
 * adminSettings.php - stats
 */
SELECT username FROM Regular_User;
SELECT city, country FROM Location ORDER BY city, country;

SELECT city, country, COUNT(location_id) as num
FROM Location L, Trip_In T
WHERE L.id = T.location_id
GROUP BY city, country
ORDER BY num DESC;

-- admin contact info
SELECT name, A.username as `username`, role, email
FROM `Admin` A, All_Users AU
WHERE A.username = AU.username;

-- aggregate stats
SELECT COUNT(*) AS numu FROM Regular_User;
SELECT COUNT(*) AS nump FROM Plans;
SELECT COUNT(*) AS numm FROM Media;

SELECT AVG(T.numplans) AS average
FROM
(SELECT COUNT(*) AS numplans
FROM Plans P GROUP BY username) AS T;

-- leaderboard: top 5 users
SELECT U.username as us, COUNT(P.trip_id) as num
FROM Regular_User U, Plans P
WHERE U.username = P.username
GROUP BY U.username
ORDER BY num DESC
LIMIT 5;

-- leaderboard: top 5 attractions
SELECT L.city as ci, L.country as co, A.attr_name as an, A.type as ty,
A.num_dollar_signs as nds, COUNT(*) as num
FROM Attraction_In A, IncludesAttraction I, Location L
WHERE A.attr_name = I.attr_name AND A.location_id = I.location_id
    AND L.id = A.location_id
GROUP BY A.attr_name, A.type, A.num_dollar_signs, L.city, L.country
ORDER BY num DESC
LIMIT 5;

-- leaderboard: top 5 activities
SELECT A.name as na, A.type as ty, A.num_dollar_signs as nds, COUNT(*) as num
FROM Activity A, IncludesActivity I
WHERE A.name = I.activity_name
GROUP BY A.name, A.type, A.num_dollar_signs
ORDER BY num DESC
LIMIT 5;

-- leaderboard: top 5 restaurants
SELECT R.name as na, R.cuisine_type as ty, R.num_dollar_signs as nds, COUNT(*) as num
FROM Restaurant R, IncludesRestaurant I
WHERE R.name = I.restaurant_name
GROUP BY R.name, R.cuisine_type, R.num_dollar_signs
ORDER BY num DESC
LIMIT 5;

-- trophy: first author
SELECT DISTINCT U.username as us, M.date as mindate
FROM Posts P, Media M, Regular_User U, Trip_In T, Plans Pl
WHERE P.post_id = M.post_id AND T.trip_id = P.trip_id AND Pl.trip_id = T.trip_id AND Pl.username = U.username
AND M.date = (SELECT MIN(date) FROM Media);

-- trophy: omnipresence
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


/* 
 * userSettings.php
 */
SELECT name FROM All_Users WHERE username = '$username';
SELECT profile_picture FROM regular_user WHERE username = '$username';
SELECT password from All_Users WHERE username='$username';
UPDATE All_Users SET name='$name' WHERE username='$username';
UPDATE All_Users SET name='$name', password='$newpassword' WHERE username='$username';

SELECT profile_picture AS pfp
FROM Regular_User
WHERE username = '$username'
AND profile_picture IS NOT NULL;

UPDATE Regular_User SET profile_picture = '$newname' WHERE username = '$username';