-- *** are IMPORTANT

-- *** creating new account (INSERT)
INSERT INTO `All_Users` VALUES ('new-username', 'new-pwd', 'new user');
INSERT INTO `Regular_User` VALUES ('new-username', 'pfp of new user');

-- *** create new post (INSERT)

-- add media to existing post (INSERT)

-- *** delete post (DELETE - CASCADE ON DELETE, with input)

-- delete media associated with a post (DELETE)

-- *** update password (UPDATE)

-- *** update profile picture (UPDATE)

-- update name (UPDATE)

-- update post (UPDATE)

-- *** query for posts by specific user (SELECTION - with input)

-- *** query for posts tagged with specific location (SELECTION)

-- *** query to show all locations (PROJECTION)
-- !!! TODO: include some kind of user input into projection ?????

-- query for all usernames (PROJECTION)
-- may need to limit who is allowed to do this

-- *** query for posts by specific user and location (JOIN)
-- need some kind of parser for the search bar

-- *** count total number of posts that exist (AGGREGATION)

-- count total users (AGGREGATION)

-- *** average/min/max $$$ for ??? category that user specifies (NESTED AGGREGATION WITH GROUP BY)
--                      ^ ex. avg price of activities/restaurants grouped by location

-- *** find all users/posts that were tagged with every location (DIVISION)
-- e.g. maybe a guardian of the galaxy spaceship trip where they can see all of earth ooh la la