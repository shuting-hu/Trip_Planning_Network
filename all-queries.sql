-- !!!!!!!!!!!!
-- TODO: at end, recheck the file locations listed for each query
-- !!!!!!!!!!!!









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
CREATE OR REPLACE VIEW Subposts
AS SELECT *
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
 * TODO - add to searchbar
 * (keywords: >locations)
 */


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



-- *** are IMPORTANT

-- *** creating new account (INSERT)
INSERT INTO `All_Users` VALUES ('new-username', 'new-pwd', 'new user');
INSERT INTO `Regular_User` VALUES ('new-username', 'pfp of new user');

-- *** create new plan (INSERT)
INSERT INTO `Location` VALUES (5678, 'country', 'province', 'city'); -- 5678 is loc id
INSERT INTO `Trip_In` VALUES ('new trip', 1234, 5678, 'daytrip', 'description'); -- 1234 is trip id
INSERT INTO `Restaurant` VALUES ('restaurant name', 'type', 3);
INSERT INTO `OperatesAt` VALUES ('restaurant name', 5678);
INSERT INTO `Activity` VALUES ('activity', 'type', 0, 'description');
INSERT INTO `IsAt` VALUES ('activity', 5678);
INSERT INTO `Includes` VALUES (1234, 'activity'); -- trip 1234 includes this activity
INSERT INTO `Attraction_In` VALUES ('attr', 5678, 'type', 'description', 0);
INSERT INTO `Plans` VALUES ('new-username', 1234); -- 1234 = trip_id

-- add media to existing plan (INSERT)
INSERT INTO `Media` VALUES (1000, '2000-12-25'); -- 1000 = media_id
INSERT INTO `Photo` VALUES (1000, 'caption here', 'file path here');
INSERT INTO `Posts` VALUES (1000, 1234);
-- Tags?

INSERT INTO `Media` VALUES (2000, '2000-12-25');
INSERT INTO `Video` VALUES (2000, 'url here');
INSERT INTO `Posts` VALUES (2000, 1234);
-- Tags?

INSERT INTO `Media` VALUES (3000, '2000-12-25');
INSERT INTO `Photo` VALUES (3000, 'text here', 'English');
INSERT INTO `Posts` VALUES (3000, 1234);
-- Tags?

-- *** delete plan (DELETE - CASCADE ON DELETE, with input)
-- !!! TODO: fix schema to add ON DELETE CASCADE

-- delete media associated with a plan (DELETE)
-- !!! TODO: fix schema to add ON DELETE CASCADE (the corresponding `Posts` tuple should also be deleted)

-- *** update password (UPDATE)
UPDATE `All_Users` A
SET A.password = 'this is my new new password'
WHERE username = 'new-username';

-- *** update profile picture (UPDATE)
UPDATE `Regular_User`
SET profile_picture = 'this is my new new pfp'
WHERE username = 'new-username';

-- update name (UPDATE)
UPDATE `All_Users` A
SET A.name = 'this is my new new name'
WHERE username = 'new-username';

-- update plan (UPDATE)

-- *** query for plans by specific user (SELECTION - with input)
SELECT trip_id
FROM Plans
WHERE username = 'new-username';

-- *** query for plans tagged with specific location (SELECTION, JOIN)
SELECT trip_id, city, country
FROM Trip_In, Location
WHERE location_id = id
    AND city='city'
    AND country='country';

-- *** query to show all locations (PROJECTION)
-- !!! TODO: include some kind of user input into projection ?????
SELECT city, country
FROM Location;

-- query for all usernames (PROJECTION)
-- may need to limit who is allowed to do this
SELECT username
FROM All_Users;

SELECT username
FROM Regular_User;

-- *** query for plans by specific user and location (JOIN)
-- need some kind of parser for the search bar

-- *** count total number of plans that exist (AGGREGATION)
SELECT count(*) AS total_plans
FROM Plans;

-- count total users (AGGREGATION)
SELECT count(*) AS total_users
FROM All_Users;

-- first user to post anything
SELECT U.username as us, M.date as mindate
FROM Posts P, Media M, Regular_User U, Trip_In T, Plans Pl
WHERE P.post_id = M.post_id AND T.trip_id = P.trip_id AND Pl.trip_id = T.trip_id AND Pl.username = U.username
AND M.date = (SELECT MIN(date) FROM Media);


-- *** average/min/max $$$ for ??? category that user specifies (NESTED AGGREGATION WITH GROUP BY)
--                      ^ ex. avg price of activities/restaurants grouped by location
-- pma doesn't like this one :(
/* SELECT type, average(num_dollar_signs) AS average_price
FROM Activity
GROUP BY type;
*/


-- *** find all users/plans that were tagged with every location (DIVISION)
-- e.g. maybe a guardian of the galaxy spaceship picture where they can see all of earth ooh la la

